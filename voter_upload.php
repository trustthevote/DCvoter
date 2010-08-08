<?php require_once('Connections/EISOS.php'); ?>
<?php
$re_dir = 0;
if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
{
$fileName = $_FILES['userfile']['name'];
$tmpName  = $_FILES['userfile']['tmp_name'];
$fileSize = $_FILES['userfile']['size'];
$fileType = $_FILES['userfile']['type'];

$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = addslashes($content);
fclose($fp);

$r_id = $_GET['R_ID'];


if(!get_magic_quotes_gpc())
{
    $fileName = addslashes($fileName);
}


$query = "INSERT INTO ABSENTEE_BALLOT (REG_UID, DATE_SENT, DATE_RECEIVED, BALLOT_STATUS_UID, CREATE_DATE, CREATE_USER, LAST_CHANGE_DATE, LAST_CHANGE_USER, EXPIRATION_DATE, BALLOT_BLOB, FILE_SIZE, FILE_TYPE) ".
"VALUES ('$r_id', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(), 1, CURRENT_TIMESTAMP(), 'site_user', CURRENT_TIMESTAMP(), 'site_user', null, '$content', '$fileSize', '$fileType')";

mysql_select_db($database_EISOS, $EISOS);
mysql_query($query) or die('Error, query failed'); 

$re_dir = 1;

echo "<br>File $fileName uploaded<br>";
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>District of Columbia Distance Voting</title>
<link href="style01.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

if (<?php echo $re_dir?> == 1){
	window.open("voter_end.php", "_self");
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
<H1>Upload Completed Ballot</H1>
</DIV><!--end title-->
<DIV id="maincontent">
  <!--end welcomeinstructions-->
<form method="post" enctype="multipart/form-data">
<table width="444" border="0" cellpadding="1" cellspacing="1" class="box">
<tr> 
<td width="246">
<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
Click Browse to locate your completed ballot and then click upload, once you have uploaded your ballot, your access to this system will be restricted.  Please verify the contents of your ballot before uploading it.<br />
<input name="userfile" type="file" id="userfile"> 
</td>
<td width="80"><input name="upload" type="submit" id="upload" value=" Upload "></td>
</tr>
</table>
</form>

</DIV><!--end maincontent-->
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
