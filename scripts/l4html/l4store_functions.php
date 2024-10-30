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

//Version 8.0.0

//set our connection variables

$dbhost = HOSTNAME;

$dbname = DATABASE;

$dbuser = USERNAME;

$dbpass = PASSWORD;	

//make a connection to our database

$conn = mysql_pconnect($dbhost, $dbuser, $dbpass);

mysql_select_db ($dbname);	



//query the database for our settings

$query_settingsRS = "SELECT settings.* FROM settings WHERE settings.settingID = 1";

$settingsRS = mysql_query($query_settingsRS);

$row_settingsRS = mysql_fetch_assoc($settingsRS);



$query_siteurl = "SELECT wp_options.option_value as siteurl FROM wp_options WHERE wp_options.option_name = 'siteurl'";

$result_siteurl = mysql_query($query_siteurl);

$row_siteurl = mysql_fetch_assoc($result_siteurl);



$companysql = "SELECT * FROM company";

$company = mysql_query($companysql);

$row_company = mysql_fetch_assoc($company);



if (!function_exists("GetSQLValueString")) {

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 

{

  if (PHP_VERSION < 6) {

    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  }



  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);



  switch ($theType) {

    case "text":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;    

    case "long":

    case "int":

      $theValue = ($theValue != "") ? intval($theValue) : "NULL";

      break;

    case "double":

      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";

      break;

    case "date":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;

    case "defined":

      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;

      break;

  }

  return $theValue;

}

}



$currentPage = $_SERVER["PHP_SELF"];



// First check to see if the session in the cookie matches the current session, if a cookie exists

// and it is not equal to the current session, update the tempcart to match current session

// then update the cookie to the current session.



if(!isset($_COOKIE['l4sessionid'])){

	//set cookie for new user

	setcookie("l4sessionid", session_id(), time()+2592000);

}else if(isset($_COOKIE['l4sessionid']) && $_COOKIE['l4sessionid'] != session_id()){

	//Update tempcart table

	$tempupdatesql = sprintf("UPDATE tempcart SET sessionid = '%s' WHERE sessionid = '%s'", mysql_real_escape_string(session_id()), mysql_real_escape_string($_COOKIE['l4sessionid']));

	$tempupdateresult = mysql_query($tempupdatesql);

	

	//update cookie

	setcookie("l4sessionid", session_id(), time()+2592000);

}



//////////////////////////////////////////////

//Get the users information from the database

//sets $accountinforow

//////////////////////////////////////////////

function initiate_getuser(){

	if(userloggedin()){

		$accountinfosql=sprintf("SELECT * FROM clients WHERE Email='%s' and Password='%s'", mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']));

		$accountinforesult=mysql_query($accountinfosql);

		$accountinforow = mysql_fetch_assoc($accountinforesult);

		$accountinfototalrows=mysql_num_rows($accountinforesult);

	}

}





//////////////////////////////////////////////

//Check if user is logged in

//returns true or false;

//////////////////////////////////////////////

function userloggedin(){

	if(isset($_SESSION['l4userlevel']) && $_SESSION['l4userlevel'] == "guest"){

		return 1;

	}else if( 	isset($_SESSION['l4username']) && 

				isset($_SESSION['l4password']) && 

				$_SESSION['l4username'] != "" && 

				$_SESSION['l4password'] != ""){

					

		$checkusersql=sprintf("SELECT * FROM clients WHERE Email='%s' and Password='%s'", mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']));

		$checkuserresult=mysql_query($checkusersql);

		$checkusercount=mysql_num_rows($checkuserresult);

		//return 'count='.$checkusercount;

		if($checkusercount>0){

			return 1;

		}else{

			return 0;

		}

	}else{

		return 0;

	}

}





//////////////////////////////////////////////

//creates new user account

//sets SESSION l4username and l4password

//////////////////////////////////////////////

function createnewaccount(){

	$newemail=$_POST['EmailNew'];

	$newpassword=md5($_POST['PasswordNew']);

	

	$sqlcheck = sprintf("SELECT Email FROM clients WHERE Email='%s'", mysql_real_escape_string($newemail));

	$resultcheck = mysql_query($sqlcheck);

	$total_rows = mysql_num_rows($resultcheck);

	

	if($total_rows == 0){

		$sql=sprintf("INSERT INTO clients(Email, Password, UserLevel) VALUES ('%s', '%s', '%s')", mysql_real_escape_string($newemail), mysql_real_escape_string($newpassword), mysql_real_escape_string("shopper"));

		$result=mysql_query($sql);

		session_start();

		$_SESSION['l4username'] = $newemail;

		$_SESSION['l4password'] = $newpassword;

	}	

}





//////////////////////////////////////////////

//logs user in

//sets $l4username and $l4password

//////////////////////////////////////////////

function loginuser(){

	// username and password sent from form

	$l4username=$_POST['SigninEmail'];

	$l4password=md5($_POST['SigninPassword']);

	// To protect MySQL injection (more detail about MySQL injection)

	$l4username = stripslashes($l4username);

	$l4password = stripslashes($l4password);

	$l4username = mysql_real_escape_string($l4username);

	$l4password = mysql_real_escape_string($l4password);

	

	$sql = "SELECT * FROM clients WHERE Email='$l4username' and Password='" . $l4password . "'";

	$result=mysql_query($sql);

	$row = mysql_fetch_assoc($result);

	

	// Mysql_num_row is counting table row

	$count=mysql_num_rows($result);

	// If result matched $myusername and $mypassword, table row must be 1 row

	

	if($count==1){

		// Register $myusername, $mypassword and redirect to file "login_success.php"

		session_start();

		$_SESSION['l4username'] = $l4username;

		$_SESSION['l4password'] = $l4password;

	}

}



//////////////////////////////////////////////

//Logs out users

//resets SESSION variables

//////////////////////////////////////////////

function logoutuser(){

	session_start();

	$_SESSION['l4username'] = "";

	$_SESSION['l4password'] = "";

}





//////////////////////////////////////////////

//Updates user account

//////////////////////////////////////////////

function updateaccount(){

	if(userloggedin()){

		$sql = sprintf("UPDATE clients SET BillPhone = '%s', BillName = '%s', BillLastName = '%s', BillAddress = '%s', BillCity = '%s', BillState = '%s', BillZip = '%s', BillCountry = '%s', ShipPhone = '%s', ShipName = '%s', ShipLastName = '%s', ShipAddress = '%s', ShipCity = '%s', ShipState = '%s', ShipZip = '%s', ShipCountry = '%s' WHERE clients.Email = '%s' AND clients.Password = '%s'", mysql_real_escape_string($_POST['BillingPhone2']), mysql_real_escape_string($_POST['BillingFirstName2']), mysql_real_escape_string($_POST['BillingLastName2']), mysql_real_escape_string($_POST['BillingAddress2']), mysql_real_escape_string($_POST['BillingCity2']), mysql_real_escape_string($_POST['BillingState2']), mysql_real_escape_string($_POST['BillingZip2']), mysql_real_escape_string($_POST['BillingCountry2']), mysql_real_escape_string($_POST['ShippingPhone2']), mysql_real_escape_string($_POST['ShippingFirstName2']), mysql_real_escape_string($_POST['ShippingLastName2']), mysql_real_escape_string($_POST['ShippingAddress2']), mysql_real_escape_string($_POST['ShippingCity2']), mysql_real_escape_string($_POST['ShippingState2']), mysql_real_escape_string($_POST['ShippingZip2']), mysql_real_escape_string($_POST['ShippingCountry2']), mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']));

		$result=mysql_query($sql);

	}	

}





//////////////////////////////////////////////

//updates users email and resets session variables

//////////////////////////////////////////////

function updateemail(){

	if(userloggedin()){

		session_start();

		if($_SESSION['l4password'] == md5($_POST['PasswordOld'])){

			if(strlen(trim($_POST['PasswordNew'])) > 0){

				$sql = sprintf("UPDATE clients SET Email = '%s', Password = '%s' WHERE clients.Email = '%s' AND clients.Password = '%s'", mysql_real_escape_string($_POST['EmailAddress']), mysql_real_escape_string(md5($_POST['PasswordNew'])), mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string(md5($_POST['PasswordOld'])));

				$result=mysql_query($sql);

				$_SESSION['l4username'] = $_POST['EmailAddress'];

				$_SESSION['l4password'] = md5($_POST['PasswordNew']);

			}else{

				$sql = sprintf("UPDATE clients SET Email = '%s' WHERE clients.Email = '%s' AND clients.Password = '%s'", mysql_real_escape_string($_POST['EmailAddress']), mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string(md5($_POST['PasswordOld'])));

				$result=mysql_query($sql);

				$_SESSION['l4username'] = $_POST['EmailAddress'];

			}

		}

	}	

}





//////////////////////////////////////////////

//reset password and email to customer

//////////////////////////////////////////////

function retrievepassword(){

	$sql = sprintf("Select BillName, BillLastName, Email from clients where email='%s'", mysql_real_escape_string($_POST['EmailAddress']));

	$result1 = mysql_query($sql);

	$client = mysql_fetch_assoc($result1);

	

	$settingsquery= mysql_query("Select * from settings where settingID = '1'");

	$settings = mysql_fetch_assoc($settingsquery);

	

	$randomnumber = (rand()%3000);

	$Password = md5($client['BillLastName'] . $randomnumber);

	

	$sql2 = sprintf("UPDATE clients SET Password='%s' WHERE clients.Email = '%s'", mysql_real_escape_string($Password), mysql_real_escape_string($_POST['EmailAddress']));

	mysql_query($sql2);

	

	require_once '../store/phpmailer/class.phpmailer.php';

	$mail = new PHPMailer(true);

	

	$message .= "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Password Reset Request</title></head><body><p>A request has been made for this email address to retrieve the password on file.  All of our passwords are encrypted and require a reset to be issued.  below is your new account information for this email address.</p><p>We suggest that you log into your account and change your password to something you will remember as it will ensure that your account information stays safe.<br />  </p><p>Email Address: " . $_POST['EmailAddress'] . "<br />  Password: " . $client['BillLastName'] . $randomnumber . "<br />  </p><p>If you have trouble logging in, please visit our website and contact us through our contact page.</p><p>Thanks Again,</p><p><a href='https://" . $settings['siteURL'] . "' target='_blank'>https://" . $settings['siteURL'] . "</a></p></body></html>";

	try {

		$mail->AddReplyTo($settings['passwordrecoveryemail'], 'Order Receipt');

		$mail->AddAddress($_POST['EmailAddress']);

		$mail->SetFrom($settings['passwordrecoveryemail'], 'Password Reset Request');

		$mail->Subject = 'Password Reset Request';

		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

		$mail->MsgHTML($message);

		$mail->Send();

	} catch (phpmailerException $e) {

	  

	} catch (Exception $e) {

	  

	}

}



function addtocart(){

	$sqlcheck = sprintf("SELECT productid FROM tempcart WHERE productid = '%s' AND sessionid = '%s' AND orderoption1 = '%s' AND orderoption2 = '%s' AND orderoption3 = '%s' AND orderoption4 = '%s' AND orderoption5 = '%s'", mysql_real_escape_string($_POST['ProductID']), mysql_real_escape_string(session_id()), mysql_real_escape_string($_POST['option1']), mysql_real_escape_string($_POST['option2']), mysql_real_escape_string($_POST['option3']), mysql_real_escape_string($_POST['option4']), mysql_real_escape_string($_POST['option5']));

	$resultcheck = mysql_query($sqlcheck);

	$numrowscheck = mysql_num_rows($resultcheck);

	if($numrowscheck == 0){

		$sqlprod = sprintf("SELECT products.Title, products.Price, products.Image1 FROM products WHERE products.ProductID = '%s'", mysql_real_escape_string($_POST['ProductID']));

		$resultprod = mysql_query($sqlprod);

		$rowprod = mysql_fetch_assoc($resultprod);

		$sql = sprintf("INSERT INTO tempcart(sessionid, productid, ordertitle, orderprice, quantity, image1, orderoption1, orderoption2, orderoption3, orderoption4, orderoption5) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", mysql_real_escape_string(session_id()), mysql_real_escape_string($_POST['ProductID']), mysql_real_escape_string($rowprod['Title']), mysql_real_escape_string($rowprod['Price']), mysql_real_escape_string($_POST['Quantity']), mysql_real_escape_string($rowprod['Image1']), mysql_real_escape_string($_POST['option1']), mysql_real_escape_string($_POST['option2']), mysql_real_escape_string($_POST['option3']), mysql_real_escape_string($_POST['option4']), mysql_real_escape_string($_POST['option5']));

		$result=mysql_query($sql);	

	}

}







//////////////////////////////////////////////

//remove cart item from our tempcart

//////////////////////////////////////////////

function removecartitem(){

	$sql = sprintf("DELETE FROM tempcart WHERE sessionid = '%s' AND tempcartid = '%s'", mysql_real_escape_string(session_id()), mysql_real_escape_string($_POST['tempcartid']));

	$result=mysql_query($sql);

}





//////////////////////////////////////////////

//update cart item from our tempcart

//////////////////////////////////////////////

function updatecartitem(){

	$sql = sprintf("UPDATE tempcart SET quantity = '%s' WHERE sessionid = '%s' AND tempcartid = '%s'", mysql_real_escape_string($_POST['Quantity']), mysql_real_escape_string(session_id()), mysql_real_escape_string($_POST['tempcartid']));

	$result=mysql_query($sql);

}





//////////////////////////////////////////////

//calculate shipping for our cart

//price trigger rate

//returns matching rate

//////////////////////////////////////////////

function calculateshipping($Cart, $CartTotal, $WeightTotal, $ShipExpedite, $ShipCountry, $ShipZip){ 

	$settingssql = "SELECT settings.shippingusetriggers, settings.shippinguseweighttriggers, settings.shippingusedynamic, settings.shippingdynamicuserid, settings.shippingdynamicziporigin FROM settings";

	$settingsresult = mysql_query($settingssql);

	$settingsrow = mysql_fetch_assoc($settingsresult);

	if($settingsrow['shippingusetriggers']){

		$sql = "SELECT shippingrates.triggerrate, shippingrates.shippingrate FROM shippingrates ORDER BY shippingrates.triggerrate DESC";

	}else{

		$sql = "SELECT shippingweightrates.triggerrate, shippingweightrates.shippingrate FROM shippingweightrates ORDER BY shippingweightrates.triggerrate DESC";

	}

	$result=mysql_query($sql);
	
	if($ShipExpedite){

		$shipexpeditesql = "SELECT * FROM shippingratesexpedite";

		$shipexpediteresult = mysql_query($shipexpeditesql);

		$shipexpediterow = mysql_fetch_assoc($shipexpediteresult);

		$expedite_price = $shipexpediterow['expediteamount'];

	}else{

		$expedite_price = 0;

	}

	

	if($settingsrow['shippingusedynamic'] == '1'){

		// Please enter your account Id that you receive when you register at AuctionInc site

	   $API_AccountId = $settingsrow['shippingdynamicuserid'];  //replace with their account ID here...

	   //

	   // Data used to initialize the rate engine with various carriers/services

	   $carrierList = array(

		  'UPS'   => 'R',     // Retail Entrypoint

		  'USPS'  => 'M',     // Manual (no discount for electronic delivery confirmation

		  'FEDEX' => 'C'      // Request Courier  

		  );

		  

	   $serviceList = array(

		  'UPSGND' => array( 'carrier' => 'UPS'),

		  'UPS3DS' => array( 'carrier' => 'UPS'),

		  'UPS2DA' => array( 'carrier' => 'UPS'),

		  'UPSNDS' => array( 'carrier' => 'UPS'),

		  'UPSNDA' => array( 'carrier' => 'UPS'),

		  'FDXGND' => array( 'carrier' => 'FEDEX'),

		  'FDX2D'  => array( 'carrier' => 'FEDEX'),

		  'FDXES'  => array( 'carrier' => 'FEDEX'),

		  'FDXFO'  => array( 'carrier' => 'FEDEX'),

		  'FDXIP'  => array( 'carrier' => 'FEDEX'),

		  'USPPP'  => array( 'carrier' => 'USPS'),

		  'USPPM'  => array( 'carrier' => 'USPS'),

		  'USPMM'  => array( 'carrier' => 'USPS', 'ondemand'=> true),

		  'USPBPM' => array( 'carrier' => 'USPS', 'ondemand'=> true)

		  );

				 

		   // User input for origin/destination addresses

		   $origCountryCode = "US";         // Presently only US origins supported

		   $origPostalCode  = $settingsrow['shippingdynamicziporigin'];

		   $destCountryCode = $ShipCountry;

		   $destPostalCode  = $ShipZip;

		   $residential     = true;

		



		

		   // Instantiate the Shipping Rate API interface

		   // NOTE: 

		   $shipAPI = new ShipRateAPI($API_AccountId);

		

		   // We dont currently support SSL

		   $shipAPI->setSecureComm(false);

		

		   $shipAPI->setDestinationAddress($destCountryCode, $destPostalCode, '', $residential);

		   

		   // Setup Carriers and Services

		   foreach($carrierList AS $code => $entryPoint) {

			  $shipAPI->addCarrier($code, $entryPoint);

		   }

		   foreach($serviceList AS $scode => $data) {

			  $onDemand = isset($data['ondemand']) ? $data['ondemand'] : false;

			  // Add service to the API 

			  $shipAPI->addService($data['carrier'], $scode, $onDemand);

		   }  

		   

		   for ($i=0; $i<sizeof($Cart); $i++){    

			   // Item information

			   $totalweight = $Cart[$i]['Weight'];

			   $lotsize = '1';  //optional

			   $weightUOM = 'LBS';  //LBS, OZ, KGS

			   $length = '';  //optional

			   $width = '';   //optional

			   $height = '';  //optional

			   $dimUOM = 'IN'; //IN, CM

			   $declaredvalue = $Cart[$i]['Price'];

			   $packMethod = 'T';      // T)ogether or S)eparate

			   $odservices = "USPMM, USPBPM"; 

			   

			   // Add data on one cart item

			   $shipAPI->addItemCalc($i, $lotsize, $totalweight, $weightUOM, $length, $width, $height, $dimUOM,  $declaredvalue, $packMethod);

		   }

		   

		   $shipAPI->addItemOnDemandServices($odservices);

			

		   $ok = $shipAPI->GetItemShipRateSS( $shipRates );

		   if ($ok) {

			//return "success";

			   for($i=0, $c=sizeof($shipRates['ShipRate']); $i < $c; $i++) {

				   $rate[$i][Rate] = $shipRates['ShipRate'][$i]['Rate'];

				   $rate[$i][Valid] = $shipRates['ShipRate'][$i]['Valid'];

				   $rate[$i][CarrierCode] = $shipRates['ShipRate'][$i]['CarrierCode'];

				   $rate[$i][ServiceCode] = $shipRates['ShipRate'][$i]['ServiceCode'];

				   $rate[$i][ServiceName] = $shipRates['ShipRate'][$i]['ServiceName'];

				   $rate[$i][CalcMethod] = $shipRates['ShipRate'][$i]['CalcMethod'];

				   $rate[$i][PackageDetail] = $shipRates['ShipRate'][$i]['PackageDetail'];

				}

			   return $rate;

			   //return all the details

		   } else {

			// return "0.00";

			 // return $shipRates;

			 return "error";

		   }

		return "0.00";

	}else{

		while($row_result = mysql_fetch_assoc($result)){

			if($settingsrow['shippingusetriggers'] == '1'){

				if($CartTotal >= $row_result['triggerrate']){

					return number_format($row_result['shippingrate'] + $expedite_price, 2, ".", '');

				}

			}else if($settingsrow['shippinguseweighttriggers'] == '1'){

				if(number_format($WeightTotal, 2) >= number_format($row_result['triggerrate'], 2)){

					return number_format($row_result['shippingrate'] + $expedite_price, 2, ".", '');

				}

			}

		}

		return "0.00";

	}

}



//////////////////////////////////////////////

//calculate tax (if needed) for our cart

//returns tax total

//////////////////////////////////////////////

function calculatetax($ShipState, $ShipCountry, $CartTotal){ 

	$sql = "SELECT * FROM taxrate";

	$result = mysql_query($sql);

	$row_result = mysql_fetch_assoc($result);

	if($row_result['taxstateenable']){

		if($ShipState == $row_result['taxstateID']){

			return number_format( ( ($row_result['taxrate']/100) * $CartTotal), 2);

		}else{

			return number_format("0.00", 2);

		}

	}else if($row_result['taxcountryenable']){

		if($ShipCountry == $row_result['taxcountryID']){

			return number_format( ( ($row_result['taxcountryrate']/100) * $CartTotal), 2);

		}else{

			return number_format("0.00", 2);

		}

	}else if($row_result['taxallenable']){

		return number_format( ( ($row_result['taxallrate']/100) * $CartTotal), 2);

	}else{

		return number_format("0.00", 2);

	}

}



function calculatediscounts($CouponCode, $GiftCard, $CartTotal, $ShippingTotal, $Cart){

	

	$couponTotal = calculatecoupon($CouponCode, $CartTotal, $ShippingTotal, $Cart);

	

	$giftCardTotal = calculategiftcard($GiftCard, $CartTotal-$couponTotal);

	

	return number_format(($couponTotal + $giftCardTotal), 2);



}



function isvalidgiftcard($GiftCard){

	$sql = sprintf("SELECT * FROM giftcards WHERE giftcardid = '%s'", mysql_real_escape_string($GiftCard));

	$result = mysql_query($sql);

	if(mysql_num_rows($result) > 0){

		$row = mysql_fetch_assoc($result);

		return 1;

	}else{

		return 0;

	}

}



function getgiftcardmessage($GiftCard){

	$sql = sprintf("SELECT * FROM giftcards WHERE giftcardid = '%s'", mysql_real_escape_string($GiftCard));

	$result = mysql_query($sql);

	$row = mysql_fetch_assoc($result);

	$numresults = mysql_num_rows($result);

	if($numresults > 0){

		return $row['giftcardmessage'] . " ($" . number_format($row['giftcardamount'], 2) . " Remaining)";

	}else{

		return "";

	}

}



function isvalidcoupon($CouponCode){

	$sql = sprintf("SELECT * FROM promocodes WHERE promoID = '%s'", mysql_real_escape_string($CouponCode));

	$result = mysql_query($sql);

	if(mysql_num_rows($result) > 0){

		$row = mysql_fetch_assoc($result);

		if(!$row['isgiftcard']){

			return 1;

		}else{

			return 0;

		}

	}else{

		return 0;

	}

}



function getcouponmessage($CouponCode){

	$sql = sprintf("SELECT * FROM promocodes WHERE promoID = '%s'", mysql_real_escape_string($CouponCode));

	$result = mysql_query($sql);

	$row = mysql_fetch_assoc($result);

	if(!$row['isgiftcard']){

		return $row['promomessage'];

	}else{

		return "";

	}

}



function calculategiftcard($GiftCard, $CartTotal){

	$sql = sprintf("SELECT * FROM giftcards WHERE giftcardid = '%s'", mysql_real_escape_string($GiftCard));

	$result = mysql_query($sql);

	$row = mysql_fetch_assoc($result);

	if($row['giftcardamount'] < $CartTotal ){

		return $row['giftcardamount'];

	}else{

		return $CartTotal;

	}

}

function isShipBased($CouponCode){
	
	$sql = sprintf("SELECT * FROM promocodes WHERE promoID = '%s'", mysql_real_escape_string($CouponCode));

	$result = mysql_query($sql);

	$row = mysql_fetch_assoc($result);

	if($row['shippingbased']){
	
		return true;
	
	}else{
	
		return false;
	
	}
	
}

function calculatecoupon($CouponCode, $CartTotal, $ShippingTotal, $Cart){

	$sql = sprintf("SELECT * FROM promocodes WHERE promoID = '%s'", mysql_real_escape_string($CouponCode));

	$result = mysql_query($sql);

	$row = mysql_fetch_assoc($result);

	if(!$row['isgiftcard']){

		if($row['byallproducts']){

			if($row['dollarbased']){

				if($row['promodollar'] < $CartTotal){

					return $row['promodollar'];

				}else{

					return $CartTotal;	

				}

			}else if($row['percentagebased']){

				return $row['promopercentage']/100*$CartTotal;

			}else if($row['shippingbased']){

				if ($row['promoshipping']  == 0) {
					
					return $ShippingTotal;
				
				} else if($row['promoshipping'] < $ShippingTotal){

					return $row['promoshipping'];

				}else{

					return $ShippingTotal;

				}

			}else{

				return 0;

			}

		}else if($row['byproductname']){

			$ByProductTotal = 0;

			for($i=0;$i<count($Cart);$i++){

				if($Cart[$i]['Title'] == $row['productname']){

					$ByProductTotal += $Cart[$i]['Price'];

				}

			}

			

			if($row['dollarbased']){

				if($row['promodollar'] < $ByProductTotal){

					return $row['promodollar'];	

				}else{

					return $ByProductTotal;

				}

			}else if($row['percentagebased']){

				return $row['promopercentage']/100*$ByProductTotal;

			}else if($row['shippingbased']){

				if($ByProductTotal > 0){

					if($row['promoshipping'] < $ShippingTotal){

						return $row['promoshipping'];

					}else{

						return $ShippingTotal;

					}

				}else{

					return 0;

				}

			}else{

				return 0;

			}

		}else if($row['bymanufacturer']){

			$ByManufacturerTotal = 0;

			for($i=0;$i<count($Cart);$i++){

				if($Cart[$i]['manufacturer'] == $row['manufacturer']){

					$ByManufacturerTotal += $Cart[$i]['Price'];

				}

			}

			

			if($row['dollarbased']){

				if($ByManufacturerTotal > $row['promodollar']){

					return $row['promodollar'];	

				}else{

					return $ByManufacturerTotal;

				}

			}else if($row['percentagebased']){

				return $row['promopercentage']/100*$ByManufacturerTotal;

			}else if($row['shippingbased']){

				if($ByManufacturerTotal > 0){

					if($row['promoshipping'] < $ShippingTotal){

						return $row['promoshipping'];

					}else{

						return $ShippingTotal;

					}

				}else{

					return 0;

				}

			}else{

				return 0;

			}

		}

	}else{

		return 0;

	}

}



//////////////////////////////////////////////

//Get state ID for taxable state

//returns taxstateID

//////////////////////////////////////////////

function gettaxstateid(){ 

	$sql = "SELECT taxrate.taxstateID FROM taxrate";

	$result=mysql_query($sql);

	$row_result = mysql_fetch_assoc($result);

	return $row_result['taxstateID'];

}



//////////////////////////////////////////////

//Get country ID for taxable country

//returns taxcountryID

//////////////////////////////////////////////

function gettaxcountryid(){ 

	$sql = "SELECT taxrate.taxcountryID FROM taxrate";

	$result=mysql_query($sql);

	$row_result = mysql_fetch_assoc($result);

	return $row_result['taxcountryID'];

}



//////////////////////////////////////////////

//calculate shipping for our cart

//weight trigger rate

//returns matching rate

//////////////////////////////////////////////

function calculateweightshipping($WeightTotal){ 

	$sql = "SELECT shippingweightrates.triggerrate, shippingweightrates.shippingrate FROM shippingweightrates ORDER BY shippingweightrates.triggerrate DESC";

	$result=mysql_query($sql);

	while($row_result = mysql_fetch_assoc($result)){

		if($WeightTotal > $row_result['triggerrate']){

			return number_format($row_result['shippingrate'], 2, ".", '');

		}

	}

}



//////////////////////////////////////////////

//retreive our expedite shipping charge

//returns expedite rate

//////////////////////////////////////////////

function getexpeditedshipping(){

	$sql = "SELECT shippingratesexpedite.expediteamount FROM shippingratesexpedite";

	$result=mysql_query($sql);

	$row = mysql_fetch_assoc($result);

	return number_format($row['expediteamount'], 2, ".", '');

}





//////////////////////////////////////////////

//calculate shipping totals

//calculates shipping and expedited rates

//needs to see which method we are using in db

//////////////////////////////////////////////

function getshippingcost($expedited){

	if($expedited == 1){ 

		return number_format(getexpeditedshipping(), 2, ".", '');

	}else{

		return "0.00";

	}

}



//////////////////////////////////////////////

//calculate tax totals

//needs to check our tax system in the db

//based on country, state, or global

//////////////////////////////////////////////

function gettaxtotal($CartTotal, $TaxRate){

	return number_format($TaxRate*$CartTotal/100, 2, ".", ''); 

}





//////////////////////////////////////////////

//checks the email address for valid format

//returns true if valid, false if invalid

//////////////////////////////////////////////

function check_email_address($email) {

	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {

		return false;

	}

	$email_array = explode("@", $email);

	$local_array = explode(".", $email_array[0]);

	for ($i = 0; $i < sizeof($local_array); $i++) {

		if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {

			return false;

		}

	}

	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {

		$domain_array = explode(".", $email_array[1]);

		if (sizeof($domain_array) < 2) {

			return false; // Not enough parts to domain

		}

		for ($i = 0; $i < sizeof($domain_array); $i++) {

		  if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|↪([A-Za-z0-9]+))$", $domain_array[$i])) {

			return false;

		  }

		}

	}

	return true;

}



function getProtocol(){

	if(isset($_SERVER['HTTPS'])){ 

		return "https://"; 

	}else{ 

		return "http://"; 

	}

}



function sanatizeCategory($cat){
	return str_replace("/", "%2F", str_replace(":", "%3A", str_replace("'", "%27", str_replace('"', "%22", str_replace("#", "%23", str_replace(" ", "%20", str_replace("-", "%2D", $cat)))))));
}

function unsanatizeCategory($cat){
	return str_replace("%2F", "/", str_replace("%3A", ":", str_replace("%27", "'", str_replace("%22", '"', str_replace("%23", "#", str_replace("%20", " ", str_replace("%2D", "-", $cat)))))));
}

?>