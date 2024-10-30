<?php
	
	# FileName="Connection_php_mysql.htm"

	# Type="MYSQL"

	# HTTP="true"

	$hostname_flashdb = DB_HOST;  //usually localhost will work

	$database_flashdb = DB_NAME;

	$username_flashdb = DB_USER;

	$password_flashdb = DB_PASSWORD;

	$url_htmlstore = url(); //http://for unsecured, https://for secured stores with certificates

	
	define ("HOSTNAME",$hostname_flashdb); 	

	define ("DATABASE",$database_flashdb); 		

	define ("USERNAME",$username_flashdb); 	

	define ("PASSWORD",$password_flashdb); 	

	define ("HTMLURL", $url_htmlstore);

	define ("DEBUG", "false");

	
	$flashdb = mysql_connect($hostname_flashdb, $username_flashdb, $password_flashdb) or trigger_error(mysql_error(),E_USER_ERROR); 

?>