<?php require_once('Connections/EISOS.php'); ?>
<?php
$r_id = $_GET['REG_ID'];

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

mysql_select_db($database_EISOS, $EISOS);
$query_rsBallot = "select distinct c.CANDIDATE_ID, d.district_name as DISTRICT_NAME, o.NUMBER_SEATS, o.OFFICE_ID, o.OFFICE_TITLE as OFFICE_TITLE, c.ballot_name, c.party, o.BALLOT_ORDER as BAL_ORD, cde.BALLOT_ORDER as CAN_ORD FROM REGISTRATIONS r  inner join PRECINCT_DISTRICT pd on pd.PRECINCT_SPLIT_ID = r.PRECINCT_SPLIT_ID inner join DISTRICT d ON d.DISTRICT_UID = pd.DISTRICT_UID inner join OFFICE o on o.DISTRICT_ID = d.DISTRICT_UID inner join CANDIDATE_OFFICE_ELECTION cde ON o.OFFICE_ID = cde.OFFICE_ID inner join CANDIDATE c on c.CANDIDATE_ID = cde.CANDIDATE_ID WHERE r.REG_UID = '$r_id' union  select DISTINCT 0, d.district_name as DISTRICT_NAME, o.NUMBER_SEATS, o.OFFICE_ID, o.OFFICE_TITLE as OFFICE_TITLE, 'Write-in', '', o.BALLOT_ORDER as BAL_ORD, 999 as CAN_ORD  FROM REGISTRATIONS r  inner join PRECINCT_DISTRICT pd on pd.PRECINCT_SPLIT_ID = r.PRECINCT_SPLIT_ID inner join DISTRICT d ON d.DISTRICT_UID = pd.DISTRICT_UID inner join OFFICE o on o.DISTRICT_ID = d.DISTRICT_UID left outer join CANDIDATE_OFFICE_ELECTION cde ON o.OFFICE_ID = cde.OFFICE_ID WHERE r.REG_UID = '$r_id' ORDER BY DISTRICT_NAME, BAL_ORD, OFFICE_TITLE, CAN_ORD  ";
$rsBallot = mysql_query($query_rsBallot, $EISOS) or die(mysql_error());
$row_rsBallot = mysql_fetch_assoc($rsBallot);
$totalRows_rsBallot = mysql_num_rows($rsBallot);

mysql_select_db($database_EISOS, $EISOS);
$query_rsPDFBallot = "select distinct b.ballot_id, b.ballot_name FROM REGISTRATIONS r inner join BALLOT b on b.PRECINCT_SPLIT_ID = r.PRECINCT_SPLIT_ID where b.ballot_name like '%blank%' and r.REG_UID = '$r_id'";
$rsPDFBallot = mysql_query($query_rsPDFBallot, $EISOS) or die(mysql_error());
$row_rsPDFBallot = mysql_fetch_assoc($rsPDFBallot);
$totalRows_rsPDFBallot = mysql_num_rows($rsPDFBallot);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>District of Columbia Distance Voting</title>
<link href="style01_1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>
 
<BODY id="welcomepage">
<DIV id="wrapper">
<DIV id=header><A href="index.htm"><IMG 
alt="docdv-header" 
src="images/docdv-header.jpg" 
width=950 height=70></A> </DIV><!--end header-->
<DIV id="title">
<H1>Completing Your Ballot</H1>
</DIV><!--end title-->
<DIV id="maincontent">
<DIV id="welcomeinstructions">
<FORM id="ballot" method="post" action="voter_ballot_prep.php">
  <p>Please complete your ballot selections below and click continue to generate your ballot</p> 
    <?php do {
	?>
    <p>Or <a href='download_ballot.php?id=<?php echo $row_rsPDFBallot['ballot_id'];?>' target="_blank">Download and complete a blank ballot</a> </p>
	<?php } while ($row_rsPDFBallot = mysql_fetch_assoc($rsPDFBallot)); ?>
  <table width="400" bgcolor="#FFFFFF">
    <?php 
	$dn = '';
	$ot = '';
	do { 
		if($dn != $row_rsBallot['district_name']){
			$dn = $row_rsBallot['district_name'];		
		?>
      		<tr><td colspan="2">District: <b><?php echo $row_rsBallot['district_name']; ?></b></td></tr>
            <tr><td>&nbsp;</td></tr>
        <?php }?>
        <?php
			if($ot !=$row_rsBallot['OFFICE_TITLE']){
				$ot = $row_rsBallot['OFFICE_TITLE'];
		?>
        <tr><td colspan="2">Office: <b><?php echo $row_rsBallot['OFFICE_TITLE']; ?></b></td></tr>
            <tr><td colspan="2">Vote for <?php echo $row_rsBallot['NUMBER_SEATS']; ?></td></tr>
		<?php }?>
        <tr>
        <td width="22"><input type="radio" name="<?php echo $row_rsBallot['OFFICE_ID'];?>" value="<?php echo $row_rsBallot['CANDIDATE_ID']; ?>" />
        </td>
        <td><?php echo $row_rsBallot['ballot_name']; ?> - <?php echo $row_rsBallot['party']; ?>
        	<?php if ($row_rsBallot['ballot_name'] == 'Write-in') {
			?>
            <input type="text" name="<?php echo $row_rsBallot['OFFICE_ID'];?>_writein" />
            <?php } ?>
        
        </td>
        </tr>
      </tr>
      <?php } while ($row_rsBallot = mysql_fetch_assoc($rsBallot)); ?>
  </table>
  <P></P>
</DIV>
<!--end welcomeinstructions-->

<FIELDSET><A 
href="voter-login.html"><INPUT type="Submit" id="start" value="Continue"> or <input onclick="window.open('voter_upload.php?R_ID=<?php echo $r_id;?>', '_self');" type="button" value="Upload Ballot" id="upload" />
</A> 
<input type="hidden" name="reg_id" value="<?php echo $r_id;?>"
</FIELDSET> </FORM></DIV><!--end maincontent-->
<DIV id="footer">
<DIV class="footertext">District of Columbia Distance Voting | <A 
href="">About</A> 
</DIV><IMG id=footerlogos alt="" 
src="images/footer.png"> 
</DIV>

<div id="helpcontent">
  <p>&nbsp;</p>
  <div class="bodybold">Please follow the steps below:</div>
  </p>
  <p>1. Check attestation box<br />
    2.  Complete ballot<br />
    3. Review PDF Ballot<br />
4. Press &quot;Save and send&quot; button <br />
    5. This page will show confirmation<br />
  </p>
</div>
</DIV><!--end wrapper--></BODY></HTML>
<?php
mysql_free_result($rsBallot);

mysql_free_result($rsPDFBallot);
?>
