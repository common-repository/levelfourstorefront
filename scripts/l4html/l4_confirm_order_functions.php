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



require_once("validation.php");



if (!session_id())

    session_start();

//set our connection variables

$dbhost = HOSTNAME;

$dbname = DATABASE;

$dbuser = USERNAME;

$dbpass = PASSWORD;	

//make a connection to our database

$conn = mysql_pconnect($dbhost, $dbuser, $dbpass);

mysql_select_db ($dbname);



function test_cart_form(){

	if($err = test_address_block($_POST['BillingName'], $_POST['BillingLastName'], $_POST['BillingAddress'], $_POST['BillingCity'], $_POST['BillingState'], $_POST['BillingZip'], $_POST['BillingPhone'])){

		return $err;

	}else if($_POST['UseBilling'] == "true"){

		return 0; //If we are using billing for shipping, no more calcs needed

	}else if($err = test_address_block($_POST['ShippingName'], $_POST['ShippingLastName'], $_POST['ShippingAddress'], $_POST['ShippingCity'], $_POST['ShippingState'], $_POST['ShippingZip'], $_POST['ShippingPhone'])){

		return ($err+7); //Add 7 to each to get the Shipping Error Code

	}else{

		return 0;

	}

}



function set_form_session_vars(){

	$_SESSION['EmailNew'] = $_POST['EmailNew'];

	$_SESSION['BillingName'] = $_POST['BillingName'];

	$_SESSION['BillingLastName'] = $_POST['BillingLastName'];

	$_SESSION['BillingAddress'] = $_POST['BillingAddress'];

	$_SESSION['BillingCity'] = $_POST['BillingCity'];

	$_SESSION['BillingState'] = $_POST['BillingState'];

	$_SESSION['BillingZip'] = $_POST['BillingZip'];

	$_SESSION['BillingCountry'] = $_POST['BillingCountry'];

	$_SESSION['BillingPhone'] = $_POST['BillingPhone'];

	$_SESSION['UseBilling'] = $_POST['UseBilling'];

	if($_POST['UseBilling'] == "true"){

		$_SESSION['ShippingName'] = $_POST['BillingName'];

		$_SESSION['ShippingLastName'] = $_POST['BillingLastName'];

		$_SESSION['ShippingAddress'] = $_POST['BillingAddress'];

		$_SESSION['ShippingCity'] = $_POST['BillingCity'];

		$_SESSION['ShippingState'] = $_POST['BillingState'];

		$_SESSION['ShippingZip'] = $_POST['BillingZip'];

		$_SESSION['ShippingCountry'] = $_POST['BillingCountry'];

		$_SESSION['ShippingPhone'] = $_POST['BillingPhone'];

	}else{

		$_SESSION['ShippingName'] = $_POST['ShippingName'];

		$_SESSION['ShippingLastName'] = $_POST['ShippingLastName'];

		$_SESSION['ShippingAddress'] = $_POST['ShippingAddress'];

		$_SESSION['ShippingCity'] = $_POST['ShippingCity'];

		$_SESSION['ShippingState'] = $_POST['ShippingState'];

		$_SESSION['ShippingZip'] = $_POST['ShippingZip'];

		$_SESSION['ShippingCountry'] = $_POST['ShippingCountry'];

		$_SESSION['ShippingPhone'] = $_POST['ShippingPhone'];

	}

	$_SESSION['ShipExpress'] = $_POST['ShipExpress'];

	$_SESSION['CouponCode'] = $_POST['CouponCode'];

	$_SESSION['GiftCard'] = $_POST['GiftCard'];
	
	$_SESSION['ShippingRate'] = $_POST['ShippingRate'];

}



function test_email_block($Email, $Password1, $Password2){

	$validate = new Validate;

	if($_SESSION['l4userlevel'] != "guest"){

		return 0; //Someone is actually logged in, so create form is not displayed.

	}else if(!$validate->isEmail($Email)){

		return 3; //Email is not valid!

	}else if(!$validate->isPassword($Password1)){

		return 4; //Password is no good!

	}else if(!$validate->isMatch($Password1, $Password2)){

		return 5; //Passwords do not match, at all.

	}else{

		return 0; //Passed all checks

	}

}



function test_address_block($FirstName, $LastName, $Address, $City, $State, $Zip, $Phone){

	$validate = new Validate;

	if(!$validate->isFirstName($FirstName)){

		return 6; //First Name is invalid

	}else if(!$validate->isLastName($LastName)){

		return 7; //Last Name is invalid

	}else if(!$validate->isAddress($Address)){

		return 8; //Address is invalid

	}else if(!$validate->isCity($City)){

		return 9; //City is invalid

	}else if(!$validate->isState($State)){

		return 10; //City is invalid

	}else if(!$validate->isZipCode($Zip)){

		return 11; //Zip Code is invalid

	}else if(!$validate->isPhone($Phone)){

		return 12; //Invalid Phone Number

	}else{

		return 0;

	}

}

?>