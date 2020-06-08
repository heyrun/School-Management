<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_unique = "XpertProCombined";
$database_unique = "uniqueblossom";
$username_unique = "heyrun";
$password_unique = "Journey-45";
$unique = mysql_pconnect($hostname_unique, $username_unique, $password_unique) or trigger_error(mysql_error(),E_USER_ERROR); 
$use_db=mysql_select_db($database_unique,$unique);

?>