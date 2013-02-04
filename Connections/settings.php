<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_settings = "localhost";
$database_settings = "ztpShout";
$username_settings = "ztpShout";
$password_settings = "changeMe";
$settings = mysql_pconnect($hostname_settings, $username_settings, $password_settings) or trigger_error(mysql_error(),E_USER_ERROR); 
?>