
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
$query_rsVoters = "select r.last_name, r.first_name, r.middle_name, r.party, p.precinct_name,  	CONCAT(a.street_number,  ' ', a.street_name, ' ', a.street_type, ' ',	coalesce(CONCAT(a.post_direction, ' '), ''), coalesce(APT, '')) as Full_address, a.city, a.state, a.zip,  		rp.pin_id 		from 		REGISTRATIONS r  		inner join 		ADDRESS a on 		a.address_uid = r.address_uid 		inner join 		PRECINCT p on 		p.precinct_uid = r.precinct_uid 		inner join 		REG_PIN rp on 		rp.reg_uid = r.reg_uid 		where r.EXPIRATION_DATE is null and rp.expiration_date is null and rp.pin_id = '$pin' AND r.last_name = '$lastname'";
$rsVoters = mysql_query($query_rsVoters, $EISOS) or die(mysql_error());
$row_rsVoters = mysql_fetch_assoc($rsVoters);
$totalRows_rsVoters = mysql_num_rows($rsVoters);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="ps_default.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1010" border="0" cellpadding="0" cellspacing="0" class="ltborder">
  <tr>
    <td colspan="3"><img src="images/boee_banner.jpg" alt="District of Columbia BOEE" width="1010" height="78" /></td>
  </tr>
  <tr>
    <td width="10%"><p class="basictextb"><img src="spacer.gif" width="100" height="2" /></p>    </td>
    <td>
<?php if ($totalRows_rsVoters == 0) { // Show if recordset empty ?>
 <p class="basictext"> We were not able to find your record, please <a href="index.php">click here</a> to try again if you feel this is in error</p>
  <?php } // Show if recordset empty ?>
  
  <?php if ($totalRows_rsVoters > 0) { // Show if recordset not empty ?>
  <table width="550" class="ltborder" align="center">
    <tr><td class="section_header">Please confirm the following information</td></tr>
  <?php do { ?>
    <tr>
      <td class="textentry">Name:<?php echo $row_rsVoters['first_name']; ?> <?php echo $row_rsVoters['middle_name']; ?> <?php echo $row_rsVoters['last_name']; ?></td></tr>
		<tr>
      <td class="textentry">Party: <?php echo $row_rsVoters['party']; ?></td>
      </tr>
      <tr>
      <td class="textentry">Ward: <?php echo $row_rsVoters['precinct_name']; ?></td>
      </tr>
      <tr>
      <td class="textentry">Address: <?php echo $row_rsVoters['Full_address']; ?> 
      <?php echo $row_rsVoters['city']; ?>, <?php echo $row_rsVoters['state']; ?> <?php echo $row_rsVoters['zip']; ?></td>
      </tr>
    <?php } while ($row_rsVoters = mysql_fetch_assoc($rsVoters)); ?>
    <tr><td align="right"><button value="Download Ballot" class="tabs" onclick="window.open('DC_Ward1_closed.pdf', '_blank');">Download Ballot</button></td></tr>
  </table>
	  <?php } // Show if recordset not empty ?>
</td>
</tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsVoters);
?>
