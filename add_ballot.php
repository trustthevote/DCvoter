<?php require_once('Connections/EISOS.php'); ?>
<?php
echo realpath("/docs");

$file = file_get_contents('./DC_Ward1_blank.pdf'); 
//$file1 = utf8_decode($file);
$byteArr = str_split($file); 
//$byteArr = array_map('ord', $byteArr);

$decoded = $file; 
file_put_contents("ps_test.pdf",$decoded); 



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



 $insertSQL = sprintf("INSERT INTO BALLOT (BALLOT_NAME, PRECINCT_SPLIT_ID, BALLOT_BYTE_STRING) VALUES (%s, %s, %s)",
                       GetSQLValueString('Ward 1 Blank', "text"),
                       GetSQLValueString(1, "int"),
                       GetSQLValueString($file, "text"));

  mysql_select_db($database_EISOS, $EISOS);
  $Result1 = mysql_query($insertSQL, $EISOS) or die(mysql_error());

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<p>

<a href="DC_Ward1_closed.pdf" target="_blank">Original PDF</a></p>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">BALLOT_NAME:</td>
      <td><input type="text" name="BALLOT_NAME" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">PRECINCT_SPLIT_ID:</td>
      <td><input type="text" name="PRECINCT_SPLIT_ID" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">BALLOT_BYTE_STRING:</td>
      <td><textarea name="BALLOT_BYTE_STRING" cols="50" rows="5" readonly="readonly"><?php echo $file;?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>
  <label></label>
  <br />
  <br />
</p>
<p>
<a href="ps_test.pdf" target="_blank">Generated PDF</a>

</body>
</html>
