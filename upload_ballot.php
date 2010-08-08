<?php require_once('Connections/EISOS.php'); ?>
<?php
if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
{
$fileName = $_FILES['userfile']['name'];
$tmpName  = $_FILES['userfile']['tmp_name'];
$fileSize = $_FILES['userfile']['size'];
$fileType = $_FILES['userfile']['type'];

$ballot_name = $_POST['BALLOT_NAME'];
$precinct_split_id = $_POST['PRECINCT_SPLIT_ID'];

$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = addslashes($content);
fclose($fp);

if(!get_magic_quotes_gpc())
{
    $fileName = addslashes($fileName);
}


$query = "INSERT INTO BALLOT (BALLOT_NAME, PRECINCT_SPLIT_ID, BALLOT_BYTE_STRING, FILE_SIZE, FILE_TYPE ) ".
"VALUES ('$ballot_name', '$precinct_split_id', '$content', '$fileSize', '$fileType')";

mysql_select_db($database_EISOS, $EISOS);
mysql_query($query) or die('Error, query failed'); 

echo "<br>File $fileName uploaded<br>";
} 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Ballots</title>
</head>

<body>
<form method="post" enctype="multipart/form-data">
<table width="444" border="0" cellpadding="1" cellspacing="1" class="box">
<tr> 
<td width="246">
Ballot Name:
<input type="text" name="BALLOT_NAME" value="" />
<br />
Precinct Split ID
<input type="text" name="PRECINCT_SPLIT_ID" />
<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
<input name="userfile" type="file" id="userfile"> 
</td>
<td width="80"><input name="upload" type="submit" class="box" id="upload" value=" Upload "></td>
</tr>
</table>
</form>


</body>
</html>
