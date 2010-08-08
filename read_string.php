<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?

if($_POST['Bytes'] != "") {
	file_put_contents("ps_test1.pdf",$_POST['Bytes']);

}

echo realpath("/docs");

$file = file_get_contents('./DC_Ward1_closed.pdf'); 
//$file1 = utf8_decode($file);
$byteArr = str_split($file); 
//$byteArr = array_map('ord', $byteArr);

//echo $file
$decoded = $file; 
file_put_contents("ps_test.pdf",$decoded); 

?>
<form name="test" action="read_string.php" method="post">
<a href="DC_Ward1_closed.pdf" target="_blank">Original PDF</a><br />
PDF Byte Array<br />
<textarea name="Bytes" cols="100" rows="10" readonly="readonly"><? echo $file;?></textarea><p>

</p>
<input type="submit" value="send" />
</form>
<a href="ps_test.pdf" target="_blank">Generated PDF</a>
<p>
<a href="ps_test1.pdf" target="_blank">From Form PDF</a>
</body>
</html>
