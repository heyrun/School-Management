<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_unique = "Host";
$database_unique = "DataBase Name";
$username_unique = "test username";
$password_unique = "Test Password";
$unique = mysql_pconnect($hostname_unique, $username_unique, $password_unique) or trigger_error(mysql_error(),E_USER_ERROR); 
$use_db=mysql_select_db($database_unique,$unique);

?>