<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_EISOS = "elephant.arvixe.com";
$database_EISOS = "paulos_eis";
$username_EISOS = "paulos_eis1";
$password_EISOS = "RedSox0407";
$EISOS = mysql_pconnect($hostname_EISOS, $username_EISOS, $password_EISOS) or trigger_error(mysql_error(),E_USER_ERROR); 
?>