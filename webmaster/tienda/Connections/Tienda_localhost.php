<?php
	# FileName="Connection_php_mysql.htm"
	# Type="MYSQL"
	# HTTP="true"
	$hostname_Tienda_localhost = "dns22.cyberneticos.com";
	$database_Tienda_localhost = "pavimpre_tienda";
	$username_Tienda_localhost = "pavimpre";
	$password_Tienda_localhost = "UiL1101gxx";
	$Tienda_localhost = mysql_pconnect($hostname_Tienda_localhost, $username_Tienda_localhost, $password_Tienda_localhost) or trigger_error(mysql_error(), E_USER_ERROR); 
?>