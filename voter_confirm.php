<?php require_once('Connections/EISOS.php'); ?>
<?php 
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$lastname = $_POST["Lname"];
$pin = $_POST["PIN"];
$zip = $_POST["Zip"];


mysql_select_db($database_EISOS, $EISOS);
$query_rsVoters = "select r.reg_uid, r.last_name, r.first_name, r.middle_name, r.party, p.precinct_name,  	CONCAT(a.street_number,  ' ', a.street_name, ' ', a.street_type, ' ',	coalesce(CONCAT(a.post_direction, ' '), ''), coalesce(APT, '')) as Full_address, a.city, a.state, a.zip,  		rp.pin_id 		from 		REGISTRATIONS r  		inner join 		ADDRESS a on 		a.address_uid = r.address_uid 		inner join 		PRECINCT p on 		p.precinct_uid = r.precinct_uid 		inner join 		REG_PIN rp on 		rp.reg_uid = r.reg_uid 		where r.EXPIRATION_DATE is null and rp.expiration_date is null and rp.pin_id = '$pin' AND r.last_name = '$lastname'";
$rsVoters = mysql_query($query_rsVoters, $EISOS) or die(mysql_error());
$row_rsVoters = mysql_fetch_assoc($rsVoters);
$totalRows_rsVoters = mysql_num_rows($rsVoters);

if ($totalRows_rsVoters == 1) {
	$reg_id = $row_rsVoters['reg_uid'];
}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>District of Columbia Distance Voting</title>
<link href="style01_1.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function gotoBallot() {
	if (document.getElementById("chkCert").checked == false){
		alert("Please check the certification box");
	} else {
		window.open("voter_ballot.php?REG_ID=<?php echo $reg_id?>", "_self");
	}
}



</script>

</head>
 
 
<body id="confirmationpage">
 
<div id="wrapper">
	<div id="header">
		<a href="index.html"><img src="images/docdv-header.jpg" alt="docdv-header" width="950" height="70" /></a>
	</div><!--end header-->
	
	<div id="title">
 <?php if ($totalRows_rsVoters > 0) { // Show if recordset not empty ?>
			<h1>Confirm identity</h1>
 <?php }?>
 <?php if ($totalRows_rsVoters == 0) { // Show if recordset empty ?>
 			<h1>Record Not Found</h1>
 <?php }?>
 
	</div><!--end title-->
	
 	<div id="maincontent">
 	
			
			<div id="confirmrecord">
		
				
				<form id="confirmid" method="post" action="">
				
					<fieldset id="record">
						<?php if ($totalRows_rsVoters == 0) { // Show if recordset empty ?>
 <p> We were not able to find your record, please <a href="voter_login.php">click here</a> to try again if you feel this is in error</p>
  <?php } // Show if recordset empty ?>
  
  <?php if ($totalRows_rsVoters > 0) { // Show if recordset not empty ?>
 <p>We found the following record. Is this you?</p>
  <?php do { ?>
   Name: <?php echo $row_rsVoters['first_name']; ?> <?php echo $row_rsVoters['middle_name']; ?> <?php echo $row_rsVoters['last_name']; ?><br />
   Party: <?php echo $row_rsVoters['party']; ?><br />
   Ward: <?php echo $row_rsVoters['precinct_name']; ?><br />
   Address: <?php echo $row_rsVoters['Full_address']; ?> 
      <?php echo $row_rsVoters['city']; ?>, <?php echo $row_rsVoters['state']; ?> <?php echo $row_rsVoters['zip']; ?><br />

                      
                        
	<p>Status: Not yet voted</p>
						<input type="checkbox" name="chkCert" id="chkCert" />
						<label for="attestcheckbox"> I certify that I am the individual named above <br />
						and that I am a registered voter residing at <br />
						the address shown on the Board’s records. </label>
	   <?php } while ($row_rsVoters = mysql_fetch_assoc($rsVoters)); ?>
	  <?php } // Show if recordset not empty ?>
 
    					<a href="voter-login.html"><input onclick="window.open('voter_login.php');" type="button" id="cancel" value="Cancel"/></a>
						
						<div id="warningtext">
							<p><b>Warning</b></p>
							<p>You can be fined up to $10,000 and/or jailed<br />
							for up to five (5) years if you are convicted of <br />
							any of the following:</p>
							
							<ul>
								<li>Making false statements about your qualificiations for voting</li>
								<li>Voting or trying to vote more than once</li>
								<li>Bribing or intimidating any voter</li>
								<li>Hiding any of the votes cast in the election</li>
							</ul>
					</div>
					</fieldset>
					
 
					
					<fieldset id="downloadballot">
						<img src="images/ballotpreview.png" alt="ballotpreview" width="160" height="350"/>
					<input type="button" onClick="gotoBallot();" value="Complete Ballot"/>
					</fieldset>
					
				</form>
 
			</div><!--end confirmrecord-->		
 
 
 	</div><!--end maincontent-->
  	<div id="helpcontent">
		<p><div class="bodybold">Please follow the steps below:</div></p>
		<p>1. Check attestation box<br />
	  2.  Complete ballot<br />
	  3. Review PDF Ballot<br />
	  4. Press "Save and send" button <br />
		  5. This page will show confirmation<br />
      
  </div><!--end contenthelp-->
 
	<div id="footer">
		<div class="footertext">
			District of Columbia Distance Voting | <a href="">About</a>
		</div>
			<img id="footerlogos" src="images/footer.png" alt=""/>
	</div>
</div><!--end wrapper-->
</body>
</html>
 <?php
mysql_free_result($rsVoters);
?>

