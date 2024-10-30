<?php 

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//All Code and Design is copyrighted by Level Four Development, LLC

//Level Four Development, LLC provides this code "as is" without     

//warranty of any kind, either express or implied,       

//including but not limited to the implied warranties    

//of merchantability and/or fitness for a particular     

//purpose.         

//

//Only licnesed users may use this code and storfront for live purposes.

//All other use is prohibited and may be subject to copyright violation laws.

//If you have any questions regarding proper use of this code, please

//contact Level Four Development, LLC prior to use.

//

//All use of this storefront is subject to our terms of agreement found on

// Level Four Development, LLC's official website.

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//Version 8.1.0

require_once( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/scripts/l4html/validation.php");

if(userloggedin()){

	//set our connection variables

	$dbhost = HOSTNAME;

	$dbname = DATABASE;

	$dbuser = USERNAME;

	$dbpass = PASSWORD;	

	//make a connection to our database

	mysql_pconnect($dbhost, $dbuser, $dbpass);

	mysql_select_db ($dbname);

	$sql = sprintf("UPDATE clients SET BillPhone = '%s', BillName = '%s', BillLastName = '%s', BillAddress = '%s', BillCity = '%s', BillState = '%s', BillZip = '%s', BillCountry = '%s', ShipPhone = '%s', ShipName = '%s', ShipLastName = '%s', ShipAddress = '%s', ShipCity = '%s', ShipState = '%s', ShipZip = '%s', ShipCountry = '%s' WHERE clients.Email = '%s' AND clients.Password = '%s'", $_POST['BillingPhone2'], $_POST['BillingFirstName2'], $_POST['BillingLastName2'], $_POST['BillingAddress2'], $_POST['BillingCity2'], $_POST['BillingState2'], $_POST['BillingZip2'], $_POST['BillingCountry2'], $_POST['ShippingPhone2'], $_POST['ShippingFirstName2'], $_POST['ShippingLastName2'], $_POST['ShippingAddress2'], $_POST['ShippingCity2'], $_POST['ShippingState2'], $_POST['ShippingZip2'], $_POST['ShippingCountry2'], $_SESSION['l4username'], $_SESSION['l4password']);

		$result=mysql_query($sql);

}

header("location:../account/");

?>