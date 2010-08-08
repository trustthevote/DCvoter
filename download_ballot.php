<?php require_once('Connections/EISOS.php'); ?>
<?php
if(isset($_GET['id'])) 
{
// if id is set then get the file with the id from database

$id    = $_GET['id'];
$query = "SELECT file_type, file_size, BALLOT_BYTE_STRING " .
         "FROM BALLOT WHERE BALLOT_ID = '$id'";

mysql_select_db($database_EISOS, $EISOS);

$result = mysql_query($query) or die('Error, query failed');
list($type, $size, $content) =  mysql_fetch_array($result);

$name = 'temp_file_name.pdf';

header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
echo $content;


exit;
}

?>
