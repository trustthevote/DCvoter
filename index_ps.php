<?php require_once('Connections/EISOS.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

mysql_select_db($database_EISOS, $EISOS);
$query_rsVoters = "select r.last_name, r.first_name, r.middle_name, r.party, p.precinct_name,  		(a.street_number + ' ' + a.street_name + ' ' + a.street_type + ' ' + 		coalesce(a.post_direction + ' ', '') + coalesce(APT, '')) as Full_address, a.city, a.state, a.zip,  		rp.pin_id 		from 		REGISTRATIONS r  		inner join 		ADDRESS a on 		a.address_uid = r.address_uid 		inner join 		PRECINCT p on 		p.precinct_uid = r.precinct_uid 		inner join 		REG_PIN rp on 		rp.reg_uid = r.reg_uid 		where r.EXPIRATION_DATE is null and rp.expiration_date is null";
$rsVoters = mysql_query($query_rsVoters, $EISOS) or die(mysql_error());
$row_rsVoters = mysql_fetch_assoc($rsVoters);
$totalRows_rsVoters = mysql_num_rows($rsVoters);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>District of Columbia - Board of Elections &amp; Ethics</title>
<link href="ps_default.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
#pinShow {
	position:absolute;
	width:504px;
	height:145px;
	z-index:1;
	left: 401px;
	top: 206px;
	visibility: hidden;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function subMitIt() {
	if (document.getElementById("Lname").value != "" && document.getElementById("PIN").value != ""){
	 	document.pg1.submit();
	}
	else
	{
		alert("Please complete your first name, last name, PIN and Zip code");
	}
}
//-->
</script>
</head>

<body>
<form name="pg1" action="voter_process.php" method="post" id="form1">
<table width="1010" border="0" cellpadding="0" cellspacing="0" class="ltborder">
  <tr>
    <td colspan="3"><img src="images/boee_banner.jpg" alt="District of Columbia BOEE" width="1010" height="78" /></td>
  </tr>
  <tr>
    <td width="10%"><p class="basictextb"><img src="spacer.gif" width="100" height="2" /></p>    </td>
    <td><p class="basictextb">Welcome to the UOCAVA Ballot Electronic Transaction service provided by the District of Columbia, Board of Elections and Ethics.  In order to utilize this service, you will need to have received your confirmation mailing with your assigned personal identification number (PIN).  If you need assistance and have not yet received your confirmation mailing, please contact our offices at (202) NNN-NNNN. </p>
    <p class="basictextb"> If you have access to your PIN, please enter the information below and we will retrieve your information and present you with a ballot in PDF form (you will need a PDF reader installed to be able to read and complete this ballot).  You may save the ballot for later completion or you may complete you ballot now.  Once you have completed your ballot, it will be securely uploaded to the BOEE.</p></td>
    <td width="10%"><span class="basictextb"><img src="spacer.gif" alt="" width="100" height="2" /></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="800" border="0" align="center" cellpadding="1" cellspacing="1">
      <tr>
        <td class="basictextb">First Name:
          <label>
          <input name="Fname" type="text" class="textentry" id="Fname" size="30" />
          </label></td>
        <td class="basictextb">Middle Name:
          <input name="Mname" type="text" class="textentry" id="Mname" size="15" /></td>
        <td class="basictextb">Last Name:
          <input name="Lname" type="text" class="textentry" id="Lname" size="30" /></td>
      </tr>
      <tr>
        <td align="right" class="basictextb"><a href="#" onclick="MM_showHideLayers('pinShow','','show')">PIN Assigned:</a></td>
        <td class="basictextb"><input name="PIN" type="password" class="textentry" id="PIN" size="20" /></td>
        <td class="basictextb">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" class="basictextb">Residence Address:</td>
        <td colspan="2" class="basictextb"><input name="Address1" type="text" class="textentry" id="Address1" size="75" /></td>
        </tr>
      <tr>
        <td class="basictextb">&nbsp;</td>
        <td colspan="2" class="basictextb"><input name="Address2" type="text" class="textentry" id="Address2" size="75" /></td>
        </tr>
      <tr>
        <td class="basictextb">City:
          <input name="City" type="text" class="textentry" id="City" value="Washington" size="35" /></td>
        <td class="basictextb">State:
          <input name="State" type="text" class="textentry" id="State" value="DC" size="5" /></td>
        <td class="basictextb">Zip:
          <input name="Zip" type="text" class="textentry" id="Zip" size="15" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">
          <img src="find_button.gif" alt="Find Your Record" width="140" id="FindButton" onclick="subMitIt();" />   </td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<div id="pinShow"><img src="sample_PIN.gif" alt="SamplePIN - Click to Close" width="540" height="145" onclick="MM_showHideLayers('pinShow','','hide')" /></div>
</body>
</html>
<?php
mysql_free_result($rsVoters);
?>

