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

//VALIDATE FORM BEFORE CONTINUING!!! ////////

require_once(WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/scripts/l4html/validation.php");

require_once(WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/scripts/l4html/gateways.php");

require_once(WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/scripts/shipping/ShipRateAPI.inc");

$validate = new Validate;

if(!$validate->isFirstName($_POST['BillingName'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=6");

}else if(!$validate->isLastName($_POST['BillingLastName'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=7");

}else if(!$validate->isAddress($_POST['BillingAddress'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=8");

}else if(!$validate->isCity($_POST['BillingCity'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=9");

}else if(!$validate->isState($_POST['BillingState'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=10");

}else if(!$validate->isZipCode($_POST['BillingZip'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=11");

}else if(!$validate->isPhone($_POST['BillingPhone'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=12");

}else if(!$validate->isFirstName($_POST['ShippingName'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=13");

}else if(!$validate->isLastName($_POST['ShippingLastName'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=14");

}else if(!$validate->isAddress($_POST['ShippingAddress'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=15");

}else if(!$validate->isCity($_POST['ShippingCity'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=16");

}else if(!$validate->isState($_POST['ShippingState'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=17");

}else if(!$validate->isZipCode($_POST['ShippingZip'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=18");

}else if(!$validate->isPhone($_POST['ShippingPhone'])){

	header("location:".$cartpage.$permalinkdivider."errorcode=19");

}else if($_POST['PaymentType'] == 2 && !$validate->isVisa($_POST['CardNumber'])){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=21");	

}else if($_POST['PaymentType'] == 3 && !$validate->isDiscover($_POST['CardNumber'])){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=21");	

}else if($_POST['PaymentType'] == 4 && !$validate->isMastercard($_POST['CardNumber'])){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=21");	

}else if($_POST['PaymentType'] == 5 && !$validate->isAmex($_POST['CardNumber'])){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=21");	

}else if($_POST['PaymentType'] == 6 && !$validate->isDiners($_POST['CardNumber'])){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=21");	

}else if($_POST['PaymentType'] == 7 && !$validate->isJcb($_POST['CardNumber'])){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=21");	

}else if($_POST['PaymentType'] != 1 && $_POST['PaymentType'] != 0 && ( strlen(trim($_POST['SecurityNumber'])) < 3 || strlen(trim($_POST['SecurityNumber'])) > 4 ) ){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=22");

}else if(!$validate->isEmail($_POST['EmailNew'])){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=3");

}else if(!$validate->isEmail($_POST['EmailNewRetype'])){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=3");

}else if($_POST['EmailNew'] != $_POST['EmailNewRetype']){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=23");

}else if($_SESSION['l4userlevel'] == "guest" && $_POST['CreateAccount'] && !$validate->isPassword($_POST['PasswordNew'])){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=4");

}else if($_SESSION['l4userlevel'] == "guest" && $_POST['CreateAccount'] && !$validate->isPassword($_POST['RetypePasswordNew'])){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=4");

}else if($_SESSION['l4userlevel'] == "guest" && $_POST['CreateAccount'] && $_POST['PasswordNew'] != $_POST['RetypePasswordNew']){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=5");

}else if(!$_POST['AgreeTerms']){

	header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=24");

}else{

	//If creating account, check that the email is not taken
	//Query for client... If we need to use it we will.
	
	$sql = sprintf("SELECT Email FROM clients WHERE Email = '%s'", mysql_real_escape_string($_POST['EmailNew']));
	
	$result = mysql_query($sql);
	
	$numrows = mysql_num_rows($result);
	
	if($_SESSION['l4userlevel'] == "guest" && $numrows > 0){
	
		header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=25");
	
	} else { //END VALIDATION
	
		/////////////////////////////////////////////////
		
		//query for our temporary cart, including options
		
		/////////////////////////////////////////////////
		
		mysql_select_db($database_flashdb, $flashdb);
		
		$cart_query = sprintf("SELECT tempcart.*, optionitems1.optionitemID as option1ID, optionitems1.optionitemname as option1name, optionitems1.optionitemprice as option1price, optionitems2.optionitemID as option2ID, optionitems2.optionitemname as option2name, optionitems2.optionitemprice as option2price, optionitems3.optionitemID as option3ID, optionitems3.optionitemname as option3name, optionitems3.optionitemprice as option3price, optionitems4.optionitemID as option4ID, optionitems4.optionitemname as option4name, optionitems4.optionitemprice as option4price, optionitems5.optionitemID as option5ID, optionitems5.optionitemname as option5name, optionitems5.optionitemprice as option5price, products.useQuantityTracking, products.Image1, products.useoptionitemimages FROM tempcart LEFT JOIN optionitems as optionitems1 ON(optionitems1.optionitemID = tempcart.orderoption1) LEFT JOIN optionitems as optionitems2 ON(optionitems2.optionitemID = tempcart.orderoption2) LEFT JOIN optionitems as optionitems3 ON(optionitems3.optionitemID = tempcart.orderoption3) LEFT JOIN optionitems as optionitems4 ON(optionitems4.optionitemID = tempcart.orderoption4) LEFT JOIN optionitems as optionitems5 ON(optionitems5.optionitemID = tempcart.orderoption5) LEFT JOIN products ON (products.ProductID = tempcart.productid) WHERE tempcart.sessionid = '%s'", mysql_real_escape_string(session_id()));
		
		$cart = mysql_query($cart_query);
		
		$cart_numrows = mysql_num_rows($cart);
		
		
		
		if($_SESSION['l4userlevel'] == "guest"){
		
			if($_POST['CreateAccount']){
		
				$ClientID = insert_client();	
		
			}else{
		
				$ClientID = 0;
		
			}
		
		}else{
		
			$user_query = sprintf("SELECT * FROM clients WHERE Email='%s' and Password='%s'", mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']));
		
			$user_result = mysql_query($user_query);
		
			$user_row = mysql_fetch_assoc($user_result);
		
			$ClientID = $user_row['ClientID'];
		
		}
		
		
		
		if(!$validate->validated($row_settingsRS['regcode'])){
	
			$PaymentMethod = "Manual Billing";
			//echo "<p style=\"font-size:22px; text-align:center;\">This store is not registered. Please visit <a href=\"https://www.levelfourstorefront.com/store/index.php#/shop/product/prod315\">Level Four Storefront</a> to purchase a license. If you have purchased a license, please submit a ticket to the 'Store Register' department <a href=\"http://www.levelfourdevelopment.com/support/index.php?/LevelFourStore/Tickets/Submit\">here</a> to get your registration code.</p>";
		
		}else if($_POST['PaymentType'] == "1"){
		
			$PaymentMethod = "PayPal";
		
		}else if($_POST['PaymentType'] == "2"){
		
			$PaymentMethod = "Visa";
		
		}else if($_POST['PaymentType'] == "3"){
		
			$PaymentMethod = "Discover";
		
		}else if($_POST['PaymentType'] == "4"){
		
			$PaymentMethod = "Mastercard";
		
		}else if($_POST['PaymentType'] == "5"){
		
			$PaymentMethod = "American Express";
		
		}else if($_POST['PaymentType'] == "6"){
		
			$PaymentMethod = "Diners";
		
		}else if($_POST['PaymentType'] == "7"){
		
			$PaymentMethod = "JCB";
		
		}
		
		
		
		$subtotal = 0;
		
		$shippable_subtotal = 0;
		
		$discountable_subtotal = 0;
		
		$taxable_subtotal = 0;
		
		$totalproducts = 0;
		
		$totalweight = 0;
		
		$Cart = array();
		
		while($row_cart = mysql_fetch_assoc($cart)){
		
			$thisitemprice = $row_cart['orderprice'];
			
			if($row_cart['useoptionitemimages']){
				
				//Get the correct image!
				$optimage_sql = sprintf("SELECT Image1 FROM optionitemimages WHERE optionitemID = %s AND productID = %s", mysql_real_escape_string($row_cart['orderoption1']), mysql_real_escape_string($row_cart['productid']));
				
				$optimage_result = mysql_query($optimage_sql);
				
				$optimage_row = mysql_fetch_assoc($optimage_result);
			}
		
			$subtotal = $subtotal + ($thisitemprice * $row_cart['quantity']);
		
			if( ($row_cart['isgiftcard'] && $row_cart['deliverymethod']) || !$row_cart['isdownload']){
		
				$shippable_subtotal = $shippable_subtotal + ($thisitemprice * $row_cart['quantity']);
		
			}
		
			
		
			if(!$row_cart['isgiftcard']){
		
				$discountable_subtotal = $discountable_subtotal + ($thisitemprice * $row_cart['quantity']);
		
			}
		
			
		
			if( $row_cart['istaxable'] ){
		
				$taxable_subtotal = $taxable_subtotal + ($thisitemprice * $row_cart['quantity']);
		
			}
		
			$totalproducts = $totalproducts + $row_cart['quantity'];
		
			$totalweight = $totalweight +  ( $row_cart['weight'] * $row_cart['quantity'] );
			
			if($row_cart['useoptionitemimages']){
				$imagetopush = $optimage_row['Image1'];
			}else{
				$imagetopush = $row_cart['Image1'];
			}
			
			array_push($Cart, array('title'=>$row_cart['ordertitle'], 'price'=>$thisitemprice, 'manufacturer'=>$row_cart['manufacturer'], 'productid'=>$row_cart['productid'], 'quantity'=>$row_cart['quantity'], 'image1'=>$imagetopush, 'option1'=>$row_cart['option1name'], 'option2'=>$row_cart['option2name'], 'option3'=>$row_cart['option3name'], 'option4'=>$row_cart['option4name'], 'option5'=>$row_cart['option5name'], 'isgiftcard'=>$row_cart['isgiftcard'], 'description'=>$row_cart['orderdescription'], 'modelnumber'=>$row_cart['ordermodelnumber'], 'textmessage'=>$row_cart['message'], 'shipperfname'=>"", 'shipperlname'=>"", 'fromname'=>$row_cart['fromname'], 'toname'=>$row_cart['toname'], 'deliverymethod'=>$row_cart['deliverymethod'], 'istaxable'=>$row_cart['istaxable'], 'isdownload'=>$row_cart['isdownload'], 'downloadid'=>$row_cart['downloadid'],'Price'=>$thisitemprice, 'Weight'=>$row_cart['weight'], 'useQuantityTracking'=>$row_cart['useQuantityTracking'], 'option1ID'=>$row_cart['option1ID'], 'option3ID'=>$row_cart['option2ID'], 'option3ID'=>$row_cart['option3ID'], 'option4ID'=>$row_cart['option4ID'], 'option5ID'=>$row_cart['option5ID'], 'orderoption1'=>$row_cart['orderoption1'], 'orderoption2'=>$row_cart['orderoption2'], 'orderoption3'=>$row_cart['orderoption3'], 'orderoption4'=>$row_cart['orderoption4'], 'orderoption5'=>$row_cart['orderoption5']));
		
		}
		
		
		
		$SubtotalPrice = $subtotal;
		
		$ShippingPrice = 0.00;
		
		$ShippingType = "none";
		
		if($row_settingsRS['shippingusedynamic'] == "1"){
		
			$shipxmldata = calculateshipping($Cart, $shippable_subtotal, $totalweight, "0", $_POST['ShippingCountry'], $_POST['ShippingZip']);
		
			for($i=0; $i<count($shipxmldata); $i++){
		
				if( $_POST['ShippingRate'] == $shipxmldata[$i]['ServiceName'] ){ 
		
					$ShippingPrice = number_format($shipxmldata[$i]['Rate'], 2, '.', '');
		
					$ShippingType = $shipxmldata[$i]['ServiceName'];
		
				}
		
			}
		
		}else{
		
			$ShippingPrice = calculateshipping($Cart, $shippable_subtotal, $totalweight, $_POST['ShipExpress'], $_POST['ShippingCountry'], $_POST['ShippingZip']);
		
		}
		
		if($ShippingType != "none"){
		
			$ShippingMethod = $ShippingType;
		
		}else if($_POST['ShipExpress']){
		
			$ShippingMethod = "Expedited Air Service";
		
		}else{
		
			$ShippingMethod = "Standard Shipping";
		
		}
		
		
		
		//Get Coupon Discount
		$couponDiscount = calculatecoupon($_POST['CouponCode'], $subtotal, $ShippingPrice, $Cart);
		
		$isShipBasedCoupon = isShipBased($_SESSION['CouponCode']);
		
		//Get Gift Card Discount
		$giftCardDiscount = calculategiftcard($_POST['GiftCard'], $subtotal - $couponDiscount + $taxRate + $ShippingPrice);
		
		//Add up discounts
		$DiscountsPrice = number_format($couponDiscount + $giftCardDiscount, 2, '.', '');
		
		//Change taxable total to match discounts. If discount is applied to shipping, then we must tax on the order, 
		//but if the discount is applied to the order then we must subtract that discount and then tax.
		if($isShipBasedCoupon){
			$taxable_subtotal = $taxable_subtotal - $giftCardDiscount;
		}else{
			$taxable_subtotal = $taxable_subtotal - $DiscountsPrice;
		}
		
		if($taxable_subtotal < 0){
			$taxable_subtotal = 0;
		}
		
		$TaxPrice = calculatetax($_SESSION['ShippingState'], $_SESSION['ShippingCountry'], $taxable_subtotal);
		
		$GrandTotalPrice = number_format($subtotal + $ShippingPrice + $TaxPrice - $DiscountsPrice, 2, '.', '');
		
		
		
		$OrderID = insert_order($ClientID, $GrandTotalPrice, $ShippingMethod, $OrderStatus, $TaxPrice, $ShippingPrice, $totalweight, $PaymentMethod);
		
		
		//Check for any total. If not, then advance past gateways, its FREEEEE.
		if($GrandTotalPrice > 0){
		
			//check the gateway now and process the payment using the selected gateway
			
			$gateway = new gateways();
			
			$gateway->setBilling($_POST['BillingName'], $_POST['BillingLastName'], $_POST['BillingAddress'], $_POST['BillingCity'], $_POST['BillingState'], $_POST['BillingZip'], $_POST['BillingCountry'], $_POST['BillingPhone'], $_POST['EmailNew']);
			
			$gateway->setShipping($_POST['ShippingName'], $_POST['ShippingLastName'], $_POST['ShippingAddress'], $_POST['ShippingCity'], $_POST['ShippingState'], $_POST['ShippingZip'], $_POST['ShippingCountry'], $_POST['ShippingPhone']);
			
			$gateway->setCard($_POST['CardNumber'], $_POST['ExpirationDateMonth'], $_POST['ExpirationDateYear'], $_POST['SecurityNumber']);
			
			$gateway->setTotals($SubtotalPrice, $ShippingPrice, $TaxPrice, $DiscountsPrice, $GrandTotalPrice);
			
			$gateway->setOrderInfo("Description", $OrderID, $ClientID);
			
			
			
			if($PaymentMethod == "Manual Billing"){
				
				//You must manually bill this customer following the order
				
				$result = 1;
				
			}else if($PaymentMethod == "PayPal"){
			
				//need to submit the details, order, client and put as paypal pending
			
				//need to correct gift card if there was one
			
				//then send to paypal via this function
			
				//then the IPN_listner should get the information and then send email, clear session, clear tempcart, confirm order, etc.
			
				//$result = $gateway->paypal();
			
				//If paypal, no need to do anything! Just move on and show a form later. Redirects user to paypal.
			
				$result = 1;
			
			}else if($row_settingsRS['useauthorize']){
			
				$result = $gateway->authorize();
			
			}else if($row_settingsRS['usechronopay']){
			
				$result = $gateway->chronopay();
			
			}else if($row_settingsRS['useversapay']){
			
				$result = $gateway->versapay();
			
			}else if($row_settingsRS['useeway']){
			
				$result = $gateway->eway();
			
			}else if($row_settingsRS['usepaypoint']){
			
				$result = $gateway->paypoint();
			
			}else if($row_settingsRS['usepaymentexpress']){
			
				$result = $gateway->paymentexpress();
			
			}else if($row_settingsRS['usefirstdata']){
			
				$result = $gateway->firstdata(); 
			
			}
		
		}else{
		
			$result = 1;
		
		}
		
		
		if(strlen(trim($result)) == 1){
		
			//Order processed, so insert all the details
			$company_sql = "SELECT * FROM company";
			$company_result = mysql_query($company_sql);
			$company_row = mysql_fetch_assoc($company_result);
			
			//print_analytics_start(get_option('l4_option_googleanalyticsid'), $OrderID, $company_row['businessname'], $GrandTotalPrice, $TaxPrice, $ShippingPrice, $_POST['BillingCity'], $_POST['BillingState'], $_POST['BillingCountry']);
	
			insert_details($Cart, $OrderID);
		
			//print_analytics_end();
			
			correct_gift_card($_POST['GiftCard'], $giftCardDiscount);
		
			//if paypal, put into pending, then IPN will send emailer
		
			//else process like a gateway
		
			clear_session();
	
			clear_tempcart();
			
			if($_SESSION['l4userlevel'] == "guest"){
	
				unset($_SESSION['l4userlevel'] );
	
				unset($_SESSION['l4username'] );
	
				unset($_SESSION['l4password'] );
	
			}
		
			if($PaymentMethod == "Manual Billing"){
			
				send_email($OrderID); 
		
				confirmorder($OrderID, 'Order on Hold');
				
				header("location:".$accountpage.$permalinkdivider."page=orderdetails&orderid=".$OrderID."&key=".md5($_POST['EmailNew'])."&ordersuccess=success");
				
			}else if($PaymentMethod == "PayPal" && $GrandTotalPrice > 0){
				
				//DO NOT SEND EMAIL. THIS SHOULD WAIT UNTIL AFTER PAYPAL PROCESSES ORDER
		
				confirmorder($OrderID, 'PayPal Pending');
		
				echo $gateway->paypal($Cart);
				
				exit;
		
			}else{
			
				send_email($OrderID); 
		
				confirmorder($OrderID,'Card Approved');
		
				header("location:".$accountpage.$permalinkdivider."page=orderdetails&orderid=".$OrderID."&key=".md5($_POST['EmailNew'])."&ordersuccess=success");
		
			}
		
		}else{
		
			remove_order($OrderID);
		
			//forward to order form with error
		
			header("location:".$cartpage.$permalinkdivider."errorcode=26&message=".$result);
		
		}

	}

}

function correct_gift_card($GiftCard, $GiftCardDiscount){

	subtract_from_gift_card($GiftCard, $GiftCardDiscount);

}

function subtract_from_gift_card($GiftCard, $amount){

	$sql = sprintf("UPDATE giftcards SET giftcardamount = giftcardamount - %01.2f WHERE giftcardid = '%s'", mysql_real_escape_string($amount), mysql_real_escape_string($GiftCard));

	mysql_query($sql);	

}



function insert_client(){

	if ($_POST['EmailList']) {

		//let's check to see if the subscriber is already there, delete if they are, then insert the new one...

		$sql = sprintf("SELECT * FROM subscribers WHERE email = '%s'", mysql_real_escape_string($_POST['EmailNew']));

		$getsubscribers = mysql_query($sql);

		//test to see if there were any matching subscribers

		if(!mysql_fetch_array($getsubscribers)) {

			//build the Insert query

			$insertsubscriber = sprintf("Insert into subscribers(email, firstname, lastname) values('%s', '%s', '%s')",

				mysql_real_escape_string($_POST['EmailNew']),

				mysql_real_escape_string($_POST['BillingName']),

				mysql_real_escape_string($_POST['BillingLastName']));

		} else {

			//delete any who have the same email

			$sql = sprintf("DELETE FROM subscribers WHERE email = '%s'", mysql_real_escape_string($_POST['EmailNew']));

			mysql_query($sql);

			//then build the Insert query

			$insertsubscriber = sprintf("Insert into subscribers(email, firstname, lastname) values('%s', '%s', '%s')",

				mysql_real_escape_string($_POST['EmailNew']),

				mysql_real_escape_string($_POST['BillingName']),

				mysql_real_escape_string($_POST['BillingLastName']));

		}

		//send query

		mysql_query($insertsubscriber);	

	}



	//*****************************************************************************************

	

	//inserts a new client into the system if they fill out all the information during checkout

	//build the Insert query

	$sql = sprintf("Insert into clients(ClientID, Email, Password, BillName, BillLastName, BillAddress, BillCity, BillState, BillCountry, BillZip, BillPhone, ShipName, ShipLastName, ShipAddress, ShipCity, ShipState, ShipCountry, ShipZip, ShipPhone, UserLevel, subscriber) values(Null, '%s', '%s', '%s',  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',  '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",

		mysql_real_escape_string($_POST['EmailNew']),

		mysql_real_escape_string(md5($_POST['PasswordNew'])),

		mysql_real_escape_string($_POST['BillingName']),

		mysql_real_escape_string($_POST['BillingLastName']),

		mysql_real_escape_string($_POST['BillingAddress']),

		mysql_real_escape_string($_POST['BillingCity']),

		mysql_real_escape_string($_POST['BillingState']),

		mysql_real_escape_string($_POST['BillingCountry']),

		mysql_real_escape_string($_POST['BillingZip']),

		mysql_real_escape_string($_POST['BillingPhone']),

		mysql_real_escape_string($_POST['ShippingName']),

		mysql_real_escape_string($_POST['ShippingLastName']),

		mysql_real_escape_string($_POST['ShippingAddress']),

		mysql_real_escape_string($_POST['ShippingCity']),

		mysql_real_escape_string($_POST['ShippingState']),

		mysql_real_escape_string($_POST['ShippingCountry']),

		mysql_real_escape_string($_POST['ShippingZip']),

		mysql_real_escape_string($_POST['ShippingPhone']),

		mysql_real_escape_string("shopper"),

		mysql_real_escape_string($_POST['EmailList']));



	mysql_query($sql);



	//if no errors, return insert ID

	$sql = sprintf("SELECT clients.* FROM clients where Email = '%s' AND Password = '%s'", mysql_real_escape_string($_POST['EmailNew']), mysql_real_escape_string(md5($_POST['PasswordNew'])));

	$result = mysql_query($sql);

	$row = mysql_fetch_assoc($result);

	

	//Update Session Vars

	$_SESSION['l4userlevel'] = "shopper";

	$_SESSION['l4username'] = $_POST['EmailNew'];

	$_SESSION['l4password'] = md5($_POST['PasswordNew']);

	

	return $row['ClientID'];

}



function insert_order($ClientID, $GrandTotalPrice, $ShippingMethod, $OrderStatus, $TaxPrice, $ShippingPrice, $totalweight, $PaymentMethod){

	//inserts a new order into the system with total and shipping information

	//all new orders get stamped with "order started"

	$OrderStatus = "Order Started";

	//build the Insert Query

	$ordersql = sprintf("Insert into orders(OrderID, ClientID, Total, ShipMethod, OrderDate, OrderStatus, UpdateDate, PromoCode, GiftCard, Tax, Shipping, ExpediteShipping, TotalWeight, BillName, BillLastName, BillAddress, BillCity, BillState, BillZip, BillCountry, BillPhone, ShipName, ShipLastName, ShipAddress, ShipCity, ShipState, ShipZip, ShipCountry, ShipPhone, Email, PaymentMethod) values(Null, '%s', '%s', '%s', NOW(), '%s', NOW(), '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",	        

		mysql_real_escape_string($ClientID),

		mysql_real_escape_string($GrandTotalPrice),

		mysql_real_escape_string($ShippingMethod),

		mysql_real_escape_string($OrderStatus),

		mysql_real_escape_string($_POST['CouponCode']),

		mysql_real_escape_string($_POST['GiftCard']),

		mysql_real_escape_string($TaxPrice),

		mysql_real_escape_string($ShippingPrice),

		mysql_real_escape_string($_POST['ShipExpress']),

		mysql_real_escape_string($totalweight),

		mysql_real_escape_string($_POST['BillingName']),

		mysql_real_escape_string($_POST['BillingLastName']),

		mysql_real_escape_string($_POST['BillingAddress']),

		mysql_real_escape_string($_POST['BillingCity']),

		mysql_real_escape_string($_POST['BillingState']),

		mysql_real_escape_string($_POST['BillingZip']),

		mysql_real_escape_string($_POST['BillingCountry']),

		mysql_real_escape_string($_POST['BillingPhone']),

		mysql_real_escape_string($_POST['ShippingName']),

		mysql_real_escape_string($_POST['ShippingLastName']),

		mysql_real_escape_string($_POST['ShippingAddress']),

		mysql_real_escape_string($_POST['ShippingCity']),

		mysql_real_escape_string($_POST['ShippingState']),

		mysql_real_escape_string($_POST['ShippingZip']),

		mysql_real_escape_string($_POST['ShippingCountry']),

		mysql_real_escape_string($_POST['ShippingPhone']),

		mysql_real_escape_string($_POST['EmailNew']),

		mysql_real_escape_string($PaymentMethod));

	

	//send the query

	mysql_query($ordersql);

	if(!mysql_error()) {

		$sql_getorderid = sprintf("SELECT OrderID FROM orders WHERE ClientID = '%s' AND Total = %01.2f ORDER BY OrderDate DESC", mysql_real_escape_string($ClientID), mysql_real_escape_string(number_format($GrandTotalPrice,2, '.', '')));

		$result_getorderid = mysql_query($sql_getorderid);

		$row_getorderid = mysql_fetch_assoc($result_getorderid);

		

		//if no errors, return the inserted

		if(!mysql_error()) {

			return $row_getorderid['OrderID'];

		} else {

			return 0; //return noresults if there are no results

		}

	} else {

		return 0; //return noresults if there are no results

	}

}



function remove_order($OID){

	$ordersql = sprintf("DELETE FROM orders WHERE OrderID = '%s'", mysql_real_escape_string($OID));

	mysql_query($ordersql);

}

function print_analytics_start($GID, $OID, $storename, $total, $tax, $shipping, $billcity, $billstate, $billcountry){
	echo "<script type=\"text/javascript\">";
  	echo "var _gaq = _gaq || [];";
 	echo "_gaq.push(['_setAccount', '".$GID."']);";
	echo "_gaq.push(['_trackPageview']);";
  	echo "_gaq.push(['_addTrans', '".$OID."', '".$storename."', '".$total."', '".$tax."', '".$shipping."', '".$billcity."', '".$billstate."', '".$billcountry."']);";
}

function print_analytics_end(){
	echo "_gaq.push(['_trackTrans']);";
	echo "(function() {";
	echo "var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;";
	echo "ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';";
	echo "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);";
	echo "})();";
	echo "</script>";
}

function insert_details($Cart, $OID){

	$cardquery= mysql_query("SELECT cardnumbers.cardnumber FROM cardnumbers WHERE cardnumbers.idfield = 1");

	$row=mysql_fetch_array($cardquery);

	if(!mysql_error()){

		$cardnumber = $row['cardnumber'];

		for ($i=0; $i<count($Cart); $i++){
			
			//if($PM != "PayPal"){
			
				//echo out analytics code for order submission if not paypal.
				//for paypal do this in the ipn listener.
				//echo "_gaq.push(['_addItem', '".$OID."', '".$Cart[$i]['modelnumber']."', '".$Cart[$i]['title']."', '". trim($Cart[$i]['option1'] . " " . $Cart[$i]['option2'] . " " . $Cart[$i]['option3'] . " " . $Cart[$i]['option4'] . " " . $Cart[$i]['option5']) . "', '". $Cart[$i]['price'] ."', '".$Cart[$i]['quantity']."']);";
			
			//}

			$cardnumber++;

			$optionCode = "GiftCard";

			$optionCode .= $cardnumber;

			$fullhashedcode = strtoupper(md5($optionCode));

			$slicedhashcode = str_split($fullhashedcode, 12);

			$newhashcode = $slicedhashcode[0];

			$promomessage = "A match was found for your gift card.";

			if ($Cart[$i]['isgiftcard'] == 1) {

				//if this is a gift card, build teh query

				$giftcardsql = sprintf("Insert into giftcards(giftcardid, giftcardamount, giftcardmessage) values('%s', '%s', '%s')",

				mysql_real_escape_string($newhashcode),

				mysql_real_escape_string($Cart[$i]['price']),

				mysql_real_escape_string($promomessage));

				//send the query

				mysql_query($giftcardsql);

				

			}



			if ($Cart[$i]['isdownload'] == 1) {

				//set encryptkey and time

				$encryptkey = uniqid(md5(rand()));

				$time = date('U');

				$downloadid = $Cart[$i]['downloadid'];

				

				//insert into downloadkey table

				$sql = "INSERT INTO downloadkey (uniqueid,timestamp,orderid,productid) VALUES('" . mysql_real_escape_string($encryptkey) . "','" . mysql_real_escape_string($time) . "','" . mysql_real_escape_string($OID) . "', '" . mysql_real_escape_string($downloadid) . "')";

				mysql_query($sql);

			} else {

				$encryptkey = 0;

			}



			

			$sql = sprintf("INSERT INTO details(OrderID, ProductID, Quantity, Image1, orderoption1, orderoption2, orderoption3, orderoption4, orderoption5, orderedItemCode, isGiftCard,  OrderTitle, OrderDescription, OrderPrice, OrderModelNumber, message, orderdate, shipperfname, shipperlname, fromname, toname, deliverymethod, isTaxable, isDownload, downloadID, downloadkey) values('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' , '%s', '%s',  '%s', NOW(), '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",

			mysql_real_escape_string($OID),

			mysql_real_escape_string($Cart[$i]['productid']),

			mysql_real_escape_string($Cart[$i]['quantity']),

			mysql_real_escape_string($Cart[$i]['image1']),

			mysql_real_escape_string($Cart[$i]['option1']),

			mysql_real_escape_string($Cart[$i]['option2']),

			mysql_real_escape_string($Cart[$i]['option3']),

			mysql_real_escape_string($Cart[$i]['option4']),

			mysql_real_escape_string($Cart[$i]['option5']),

			mysql_real_escape_string($newhashcode),

			mysql_real_escape_string($Cart[$i]['isgiftcard']),

			mysql_real_escape_string($Cart[$i]['title']),	

			mysql_real_escape_string($Cart[$i]['description']),

			mysql_real_escape_string($Cart[$i]['price']),

			mysql_real_escape_string($Cart[$i]['modelnumber']),

			mysql_real_escape_string($Cart[$i]['textmessage']),

			mysql_real_escape_string($Cart[$i]['shipperfname']),

			mysql_real_escape_string($Cart[$i]['shipperlname']),

			mysql_real_escape_string($Cart[$i]['fromname']),

			mysql_real_escape_string($Cart[$i]['toname']),

			mysql_real_escape_string($Cart[$i]['deliverymethod']),

			mysql_real_escape_string($Cart[$i]['istaxable']),

			mysql_real_escape_string($Cart[$i]['isdownload']),

			mysql_real_escape_string($Cart[$i]['downloadid']),

			mysql_real_escape_string($encryptkey));	

			//send query

			mysql_query($sql);

			if (mysql_error()) return 0;

			

			
			if($Cart[$i]['useQuantityTracking']){
				
				//UPDATE OPTION ITEM QUANTITY VALUES
				
				$updatesql = sprintf("UPDATE optionitemquantity SET Quantity = Quantity - '%s' WHERE optionitemquantity.ProductID = '%s' AND optionitemquantity.OptionItemID1 = '%s' AND optionitemquantity.OptionItemID2 = '%s' AND  optionitemquantity.OptionItemID3 = '%s' AND  optionitemquantity.OptionItemID4 = '%s' AND  optionitemquantity.OptionItemID5 = '%s'",
	
				mysql_real_escape_string($Cart[$i]['quantity']),
	
				mysql_real_escape_string($Cart[$i]['productid']),
	
				mysql_real_escape_string($Cart[$i]['orderoption1']),
	
				mysql_real_escape_string($Cart[$i]['orderoption2']),
	
				mysql_real_escape_string($Cart[$i]['orderoption3']),
	
				mysql_real_escape_string($Cart[$i]['orderoption4']),
	
				mysql_real_escape_string($Cart[$i]['orderoption5']));
	
				mysql_query($updatesql);
				
			}
		
			//update the quantity for the products if purchased to keep inventory accurate

			$updatesql = sprintf("UPDATE products SET quantity = quantity - '%s' WHERE products.ProductID = '%s'",

			mysql_real_escape_string($Cart[$i]['quantity']),

			mysql_real_escape_string($Cart[$i]['productid']));

			mysql_query($updatesql);

		}

		$giftcardnum = sprintf("REPLACE into cardnumbers(idfield, cardnumber) values(1, '%s')",

			mysql_real_escape_string($cardnumber));

		

		mysql_query($giftcardnum);



	} else {

		return 0;

	}

	

	//if no errors, return the OrderID

	if(!mysql_error()) return $OrderID;

	//else return error

	else return 0;

}



function send_email($OrderID){

	////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/////////THIS PORTION OF CONFIRMATION EMAILER IS IDENTICAL TO THAT FOUND THROUGHOUT THE CODE////////////////

	/////////YOU CAN COPY AND PASTE YOUR DESIGNED EMAILER TO ALL THE SPECIFIC LOCATIONS AND IPN////////////////

	/////////SERVICES THROUGHOUT THE STOREFRONT CODE///////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////////////////////////////////////////////////

		

	// retrieve the total and shipping from orderID

	$sql2 = sprintf("Select * from orders where OrderID='%s'", mysql_real_escape_string($OrderID));

	$result2 = mysql_query($sql2);

	$order = mysql_fetch_array($result2);

	//Select details of each item for an itemized record

	$sql3 = sprintf("Select * from details  where OrderID = '%s'", mysql_real_escape_string($OrderID));

	$result3 = mysql_query($sql3);

	//get settings for email handling information

	$settingsquery= mysql_query("Select * from settings where settingID = '1'");

	$settings = mysql_fetch_array($settingsquery);

	//Build the email message with full itemized paging

	$Text = "This email is html, please switch to this view";

	$salestax = number_format($order[Tax], 2, '.', '');

	$shippingcost = number_format($order[Shipping], 2, '.', '');

	$message = "--==MIME_BOUNDRY_alt_main_message\n";

	$message .= "Content-Type: text/plain; charset=ISO-8859-1\n";

	$message .= "Content-Transfer-Encoding: 7bit\n\n";

	$message .= $Text . "\n\n";

	$message .= "--==MIME_BOUNDRY_alt_main_message\n";

	$message .= "Content-Type: text/html; charset=ISO-8859-1\n";

	$message .= "Content-Transfer-Encoding: 7bit\n\n";

	$message .= "<html><head><title>..::Order Confirmation - Order Number $OrderID ::..</title><style type='text/css'><!--.style20 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }.style22 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }--></style></head><body> <table width='539' border='0' align='center'>   <tr><td colspan='4' align='left' class='style22'><img src='http://$settings[siteURL]/images/emaillogo.jpg' width='532' height='97'></td></tr><tr><td colspan='4' align='left' class='style22'><p><br> Dear $_POST[BillingName]  $_POST[BillingLastName]: </p><p>Thank you for your order!  Your Reference Number is: <strong>$OrderID</strong></p><p>Below is a  summary of order. You can check the status of your order and all the details by visiting our website and logging into your account.</p><p>Please keep this as a record of your order!<br><br><br></p></td></tr><tr><td colspan='4' align='left' class='style20'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td width='47%' bgcolor='#F3F1ED' class='style20'>Billing Address</td><td width='3%'>&nbsp;</td><td width='50%' bgcolor='#F3F1ED' class='style20'>Shipping Address</td></tr><tr>   <td><span class='style22'>     $_POST[BillingName]       $_POST[BillingLastName]    </span></td>    <td>&nbsp;</td>   <td><span class='style22'>     $_POST[ShippingName]       $_POST[ShippingLastName]     </span></td> </tr><tr><td><span class='style22'> $_POST[BillingAddress]  </span></td>   <td>&nbsp;</td><td><span class='style22'>     $_POST[ShippingAddress]    </span></td> </tr><tr><td><span class='style22'>       $_POST[BillingCity]        , $_POST[BillingState]   &nbsp;  $_POST[BillingZip]  </span></td>   <td>&nbsp;</td>   <td><span class='style22'>     $_POST[ShippingCity]      , $_POST[ShippingState]       &nbsp; $_POST[ShippingZip]    </span></td> </tr><tr><td><span class='style22'>Phone:    $_POST[BillingPhone]  </span></td>   <td>&nbsp;</td><td><span class='style22'>Phone:      $_POST[ShippingPhone]    </span></td> </tr></table></td></tr><tr><td width='269' align='left'>&nbsp;</td><td width='80' align='center'>&nbsp;</td><td width='91' align='center'>&nbsp;</td><td align='center'>&nbsp;</td></tr><tr><td width='269' align='left' bgcolor='#F3F1ED' class='style20'>Product</td><td width='80' align='center' bgcolor='#F3F1ED' class='style20'>Qty</td><td width='91' align='center' bgcolor='#F3F1ED' class='style20'>Unit Price</td><td align='center' bgcolor='#F3F1ED' class='style20'>Ext Price</td></tr>";

	while($row=mysql_fetch_array($result3)) 

	{

		$finaltotal = number_format($row[OrderPrice]+$row[OrderGratuity], 2, '.', '');

		$totalitemprice = number_format($row[Quantity]*$row[OrderPrice], 2, '.', '');

		$message .= "<tr><td width='269' class='style22'>$row[OrderTitle]</td><td width='80' align='center' class='style22'>$row[Quantity]</td><td width='91' align='center' class='style22'>$$finaltotal </td><td align='center' class='style22'>$$totalitemprice</td></tr> ";

		

	}

	$total = number_format($order[Total], 2, '.', '');

	$message .="<tr><td width='269'>&nbsp;</td><td width='80' align='center'>&nbsp;</td><td width='91' align='center'>&nbsp;</td><td>&nbsp;</td></tr><tr><td width='269'>&nbsp;</td><td width='80' align='center' class='style22'>&nbsp;</td><td width='91' align='center' class='style22'>Sales Tax</td><td align='center' class='style22'>$$salestax</td></tr><tr><td width='269'>&nbsp;</td><td width='80' align='center' class='style22'>&nbsp;</td><td width='91' align='center' class='style22'>Shipping</td><td  align='center'  class='style22'>$$shippingcost </td></tr><tr><td width='269'>&nbsp;</td><td width='80' align='center' class='style22'>&nbsp;</td><td width='91' align='center' class='style22'><strong>Order Total</strong></td><td align='center' class='style22'><strong>$$total</strong></td></tr><tr><td colspan='4' class='style22'><p><br>Please double check your order when you receive it and let us know immediately if there are any concerns or issues. We always value your business and hope you enjoy your product.<br><br>  Thank You Very much!</p>  <p>&nbsp;</p></td></tr><tr><td colspan='4'><p class='style22'><img src='http://$settings[siteURL]/images/emailfooter.jpg' width='532' height='97'></p></td></tr></table></body></html>";

	

	//headers

	$headers = "From: $settings[orderfromemail]\r\n";

	$headers .= "Reply-To: $settings[orderfromemail]\r\n";

	$headers .= "X-Mailer: PHP4\n";

	$headers .= "X-Priority: 3\n";

	$headers .= "MIME-Version: 1.0\n";

	$headers .= "Return-Path: $settings[orderfromemail]\r\n"; 

	$headers .= "Content-Type: multipart/alternative; boundary=\"==MIME_BOUNDRY_alt_main_message\"\n\n";

	

	/////////////////////////////////////////////////////////////////////////////////////

	//////////////////////END CONFIRMATION EMAILER CODE//////////////////////////////////

	/////////////////////////////////////////////////////////////////////////////////////



	//add mulitple mail commands here for going to store admins if necessary

	//just copy this line several times and replace the client[Email] with any email address

	mail($_POST['EmailNew'], "Order Confirmation -- #$OrderID", $message, $headers);



}



function clear_session(){

	unset($_SESSION['EmailNew']);

	unset($_SESSION['BillingName'] );

	unset($_SESSION['BillingLastName'] );

	unset($_SESSION['BillingAddress'] );

	unset($_SESSION['BillingCity'] );

	unset($_SESSION['BillingState'] );

	unset($_SESSION['BillingZip'] );

	unset($_SESSION['BillingCountry'] );

	unset($_SESSION['BillingPhone'] );

	unset($_SESSION['UseBilling'] );

	

	unset($_SESSION['ShippingName'] );

	unset($_SESSION['ShippingLastName'] );

	unset($_SESSION['ShippingAddress'] );

	unset($_SESSION['ShippingCity'] );

	unset($_SESSION['ShippingState'] );

	unset($_SESSION['ShippingZip'] );

	unset($_SESSION['ShippingCountry'] );

	unset($_SESSION['ShippingPhone'] );

	

	unset($_SESSION['ShipExpress'] );

	unset($_SESSION['CouponCode'] );

	unset($_SESSION['GiftCard'] );

}



function clear_tempcart(){

	$sql = sprintf("DELETE FROM tempcart WHERE sessionid = '%s'", mysql_real_escape_string(session_id()));

	$result = mysql_query($sql);

}



function confirmorder($orderID,$status){

	//Create SQL Query

	$confirmsql = sprintf("UPDATE orders SET OrderStatus='%s' WHERE orders.OrderID = '%s'", mysql_real_escape_string($status), mysql_real_escape_string($orderID));

	//Run query on database;

	mysql_query($confirmsql);

}

?>