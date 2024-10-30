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

class gateways{
	public $BillingName;
	public $BillingLastName;
	public $BillingAddress;
	public $BillingCity;
	public $BillingState;
	public $BillingZip;
	public $BillingCountry;
	public $BillingPhone;
	public $Email;
	
	public $ShippingName;
	public $ShippingLastName;
	public $ShippingAddress;
	public $ShippingCity;
	public $ShippingState;
	public $ShippingZip;
	public $ShippingCountry;
	public $ShippingPhone;
	
	public $CardNumber;
	public $ExpireMonth;
	public $ExpireYear;
	public $SecurityNumber;
	
	public $Subtotal;
	public $ShippingTotal;
	public $TaxTotal;
	public $DiscountTotal;
	public $GrandTotal;
	
	public $OrderDescription;
	public $OrderID;
	public $ClientID;
	
	function setBilling($BName, $BLastName, $BAddress, $BCity, $BState, $BZip, $BCountry, $BPhone, $EM){
		$this->BillingName = $BName;
		$this->BillingLastName = $BLastName;
		$this->BillingAddress = $BAddress;
		$this->BillingCity = $BCity;
		$this->BillingState = $BState;
		$this->BillingZip = $BZip;
		$this->BillingCountry = $BCountry;
		$this->BillingPhone = $BPhone;
		$this->Email = $EM;
	}
	
	function setShipping($SName, $SLastName, $SAddress, $SCity, $SState, $SZip, $SCountry, $SPhone){
		$this->ShippingName = $SName;
		$this->ShippingLastName = $SLastName;
		$this->ShippingAddress = $SAddress;
		$this->ShippingCity = $SCity;
		$this->ShippingState = $SState;
		$this->ShippingZip = $SZip;
		$this->ShippingCountry = $SCountry;
		$this->ShippingPhone = $SPhone;
	}
	
	function setCard($CCNum, $ExpMonth, $ExpYear, $SecNum){
		$this->CardNumber= $CCNum;
		$this->ExpireMonth = $ExpMonth;
		$this->ExpireYear = $ExpYear;
		$this->SecurityNumber = $SecNum;
	}
	
	function setTotals($Sub, $Ship, $Tax, $Discounts, $Grand){
		$this->Subtotal = $Sub;
		$this->ShippingTotal = $Ship;
		$this->TaxTotal = $Tax;
		$this->DiscountTotal = $Discounts;
		$this->GrandTotal = $Grand;
	}
	
	function setOrderInfo($Desc, $ID, $CID){
		$this->OrderDescription = $Desc;
		$this->OrderID = $ID;
		$this->ClientID = $CID;
	}
	
	//tested good
	function authorize() {
		//query the database for our settings
		$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";
		$settingsRS = mysql_query($query_settingsRS);
		$row_settingsRS = mysql_fetch_assoc($settingsRS);
		
		/////////////////////////////////////////////////////////////////////////
		//Set the Login ID and Transaction Key
		//////////////////////////////////////////////////////////////////////////
		$auth_net_login_id			= $row_settingsRS['authorizeloginid'];
		$auth_net_tran_key			= $row_settingsRS['authorizetrankey'];
		
		
		//////////////////////////////////////////////////////////////////////////
		//determine if we are in test mode or regular mode
		/////////////////////////////////////////////////////////////////////////
		if ($row_settingsRS['authorizetestmode'] == 1) {
		  $auth_net_url				= "https://secure.authorize.net/gateway/transact.dll";
		  $ch 						= curl_init("https://secure.authorize.net/gateway/transact.dll"); 
		}
		if ($row_settingsRS['authorizetestmode'] == 0) {
		  $auth_net_url				= "https://secure.authorize.net/gateway/transact.dll";
		  $ch 						= curl_init("https://secure.authorize.net/gateway/transact.dll"); 
		}
		if ($row_settingsRS['authorizedeveloperaccount'] == 1) {
		  $auth_net_url				= "https://test.authorize.net/gateway/transact.dll";
		  $ch 						= curl_init("https://test.authorize.net/gateway/transact.dll"); 
		}
		
		
		//////////////////////////////////////////////////////////////////////////
		//Set authorize.net variables, must have register_globals = on in php.ini
		//////////////////////////////////////////////////////////////////////////
		$authnet_values				= array
		(
		  "x_login"					=> $auth_net_login_id,
		  "x_version"				=> "3.1",
		  "x_delim_char"			=> ",",
		  "x_delim_data"			=> "TRUE",
		  "x_url"					=> "FALSE",
		  "x_type"					=> "AUTH_CAPTURE",
		  "x_method"				=> "CC",
		  "x_tran_key"				=> $auth_net_tran_key,
		  "x_relay_response"		=> "FALSE",
		  "x_card_num"				=> $this->CardNumber,
		  "x_exp_date"				=> $this->ExpireMonth.'/'.$this->ExpireYear,
		  "x_card_code"				=> $this->SecurityNumber,
		  "x_description"			=> $this->OrderDescription,
		  "x_amount"				=> $this->GrandTotal,
		  "x_tax"					=> $this->TaxTotal,
		  "x_freight"				=> $this->ShippingTotal,
		  "x_email"					=> $this->Email,
		  "x_first_name"			=> $this->BillingName,
		  "x_last_name"				=> $this->BillingLastName,
		  "x_address"				=> $this->BillingAddress,
		  "x_city"					=> $this->BillingCity,
		  "x_state"					=> $this->BillingState,
		  "x_zip"					=> $this->BillingZip,
		  "x_country"				=> $this->BillingCountry,
		  "x_phone"					=> $this->BillingPhone,
		  "x_invoice_num"			=> $this->OrderID,
		  "x_cust_id"				=> $this->ClientID,
		  "x_ship_to_first_name"	=> $this->ShippingName,
		  "x_ship_to_last_name"		=> $this->ShippingLastName,
		  "x_ship_to_address"		=> $this->ShippingAddress,
		  "x_ship_to_city"			=> $this->ShippingCity,
		  "x_ship_to_state"			=> $this->ShippingState,
		  "x_ship_to_zip"			=> $this->ShippingZip,
		  "x_ship_to_country"		=> $this->ShippingCountry,
		  "x_ship_to_phone"			=> $this->ShippingPhone,
		);
		
		$fields = "";
		foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); // use HTTP POST to send form data
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. 
		
		
		////////////////////////////////////////////////////////////////////////////////////////////
		// If you have GoDaddy hosting or other hosting services that require use of a proxy to talk to external sites via cURL, 
		// then uncomment the following 5 lines and substitute their proxy server's address for 1.1.1.1 below: 
		if ($row_settingsRS['useproxy'] == 1) {  
		  curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, true); 
		  curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
		  curl_setopt ($ch, CURLOPT_PROXY, $row_settingsRS['proxyaddress']); 
		}
		////////////////////////////////////////////////////////////////////////////////////////////
		
		
		$resp = curl_exec($ch); //execute post and get results
		curl_close ($ch);
		$responseCode = substr($resp, 0, 1);
		$responseCodeReason = substr($resp, 4, 1);
		
		//log the response to our errortable for authiorization result checking
		$authresultssql = sprintf("Insert into errortable (errorID, errormessage, orderID) values(Null,  '%s', '%s')",
			mysql_real_escape_string($resp),
			mysql_real_escape_string($this->OrderID));
		//run query
		mysql_query($authresultssql);
			
		//now handle the response - //return 1 if good, //return other if not good.	
		switch($responseCode) {
			case "1":
				return "1";
				break;
			case "2":
				switch($responseCodeReason) {
					case "27":
						return "ERROR 27: The transaction resulted in an AVS mismatch. The address provided does not match billing address of cardholder.";
						break;
					case "28":
						return "ERROR 28: The merchant does not accept this type of credit card.";
						break;
					default:
						return "ERROR 2: This transaction has been declined.";
						break;
				}
			case "3":
				switch($responseCodeReason) {
					case "6":
						return "ERROR 6: The credit card number is invalid.";
						break;
					case "7":
						return "ERROR 7: The credit card expiration date is invalid.";
						break;
					case "8":
						return "ERROR 8: The credit card has expired.";
						break;
					case "11":
						return "ERROR 11: A duplicate transaction has been submitted.";
						break;
					default:
						return "$responseCodeReason ERROR 3: This transaction has been declined.";
						break;
				}
			case "4":
				switch($responseCodeReason) {
					default:
						return "ERROR 4: This transaction has been declined.";
						break;
				}
			default:
				return "ERROR 100: There was an error processing your order";
		}
		
		mysql_free_result($settingsRS);
		
	}//close authorize
	
	
	//tested good	
	function paypoint() {
		//include paypoint include files
		include("gateways/paypoint/xmlrpc.inc");
		
		//query the database for our settings
		$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";
		$settingsRS = mysql_query($query_settingsRS);
		$row_settingsRS = mysql_fetch_assoc($settingsRS);
		
		
		//Declare the method, validateCardFull, of the SECVPN object to be used via XML RPC.
		//Other methods like this one can be added to handle other methods of the SECVPN object.
		$f=new xmlrpcmsg('SECVPN.validateCardFull');
		
		//Add the test parameters in the order specified
		//by the SECVPN.validateCardFull() method		   
		$merchantid = $row_settingsRS['paypointmerchantid']; //usually six letters and two numbers
		$vpnpassword = $row_settingsRS['paypointvpnpassword'];  //acccount -> remote passwords -> select vpn from the drop down list.
		
		$invoiceid = $this->OrderID;
		$ip = $_SERVER['REMOTE_ADDR']; 
		$cardholdername = $this->BillingName . " " . $this->BillingLastName;
		$cardnumber = $this->CardNumber;
		$finaltotal = $this->GrandTotal;
		$expirationdate = $this->ExpireMonth . substr($this->ExpireYear, -2);
		$shippingaddress = "name=" . urlencode($this->ShippingName . " " . $this->ShippingLastName) . ",addr_1=" . urlencode($this->ShippingAddress) . ",city=" . urlencode($this->ShippingCity) . ",state=" .urlencode($this->ShippingState) . ",post_code=" . urlencode($this->ShippingZip) . ",tel=" . urlencode($this->ShippingPhone) . ",email=" . urlencode($this->Email) . ",url=www.unavailable.com";
		$billingaddress = "name=" . urlencode($this->BillingName . " " . $this->BillingLastName) . ",addr_1=" . urlencode($this->BillingAddress) . ",city=" . urlencode($this->BillingCity) . ",state=" . urlencode($this->BillingState) . ",post_code=" . urlencode($this->BillingZip) . ",tel=" . urlencode($this->BillingPhone) . ",email=" . urlencode($this->Email) . ",url=www.unavailable.com";
		
		
		$f->addParam(new xmlrpcval($merchantid, "string")) ;		// Test MerchantId
		$f->addParam(new xmlrpcval($vpnpassword, "string")) ;		// VPN password
		$f->addParam(new xmlrpcval($invoiceid, "string")) ;		// order ID
		$f->addParam(new xmlrpcval($ip, "string")) ;	// The ip of the original caller
		$f->addParam(new xmlrpcval($cardholdername, "string")) ;	// Card Holders Name
		$f->addParam(new xmlrpcval($cardnumber, "string")) ;	// Card number
		$f->addParam(new xmlrpcval($finaltotal, "string")) ;		// Amount
		$f->addParam(new xmlrpcval($expirationdate, "string")) ;		// Expiry Date
		$f->addParam(new xmlrpcval("", "string")) ;			// Issue (Switch/Solo only)
		$f->addParam(new xmlrpcval("", "string")) ;			// Start Date
		$f->addParam(new xmlrpcval("Online Order", "string")) ;	
		$f->addParam(new xmlrpcval($shippingaddress, "string")) ;			// Shipping Address
		$f->addParam(new xmlrpcval($billingaddress, "string")) ;			// Billing Address
		
		
		//use these for live or test mode servers 
		if ($row_settingsRS['paypointtestmode'] == 1) {
			$optionstring = "test_status=true,dups=false,cv2=" . $this->SecurityNumber; 
			$f->addParam(new xmlrpcval($optionstring, "string")) ;	// Options String
		}
		if ($row_settingsRS['paypointtestmode'] == 0) {
			$optionstring = "dups=false,cv2=" . $this->SecurityNumber; 
			$f->addParam(new xmlrpcval($optionstring, "string")) ;	// Options String
		}
		
		//print out the sending data
		//print "<pre>sending data ...\n" . htmlentities($f->serialize()) . "... end of send\n</pre>";
		
		//Create the XMLRPC client, using the server 'make_call', on the host 'www.secpay.com', via the https port '443'
		$c=new xmlrpc_client("/secxmlrpc/make_call", "www.secpay.com", 443);
		
		
		//Debugging is enabled for testing purposes
		$c->setDebug(0);
		
		//Send the request using the 'https' protocol.
		$r=$c->send($f,20,"https");
		
		
		//Ensure that a response has been received from SECPay
		if (!$r) { 
			die("error"); 
		}
		$v=$r->value();
		
		//log the response to our errortable for authiorization result checking
		$authresultssql = sprintf("Insert into errortable (errorID, errormessage, orderID) values(Null,  '%s', '%s')",
			mysql_real_escape_string($r->serialize()),
			mysql_real_escape_string($this->OrderID));
		//run query
		mysql_query($authresultssql);
		
		//Display response or fault information
		if (!$r->faultCode()) {
			// $v->scalarval()."<BR>";
			//print htmlentities($r->serialize())."</PRE><HR>\n";
			$result = $r->serialize();
			$search = "code=A";
			if(strstr($result, $search)) {
				return "1";
			} else {
				return "ERROR 1: This transaction has been declined.";
			}
		} 
		else {
			return $r->serialize();
		}	
	} //close paypoint
		
	//tested good	
	function chronopay() {
		//query the database for our settings
		$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";
		$settingsRS = mysql_query($query_settingsRS);
		$row_settingsRS = mysql_fetch_assoc($settingsRS);
		
		//set the variables for chronopay
		$ip = $_SERVER['REMOTE_ADDR']; 
		$currency = $row_settingsRS['chronocurrency'] ;
		$product_id = $row_settingsRS['chronoproductid'] ;
		
		//set the hash for chronopay
		$hashvar = $row_settingsRS['chronosharedsecret'] . "1" . $row_settingsRS['chronoproductid'] . $this->BillingName . $this->BillingLastName . $this->BillingAddress . $ip . $this->CardNumber . $this->GrandTotal;
		$newhashvar = md5($hashvar);
		
		//set the chronompay curl gateway
		$ch = curl_init("https://secure.chronopay.com/gateway.cgi"); 
		
		
		//////////////////////////////////////////////////////////////////////////
		//Set chronopay variables to be setn via post curl
		//////////////////////////////////////////////////////////////////////////
		$authnet_values				= array
		(
		"opcode"				=> "1",
		"product_id"			=> $product_id,
		"fname"					=> $this->BillingName,
		"lname"					=> $this->BillingLastName,
		"street"				=> $this->BillingAddress,
		"city"					=> $this->BillingCity,
		"country"				=> $this->BillingCountry,
		"email"					=> $this->Email,
		"zip"					=> $this->BillingZip,
		"phone"					=> $this->BillingPhone,
		"ip"					=> $ip,
		"card_no"				=> $this->CardNumber,
		"cvv"					=> $this->SecurityNumber,
		"expirey"				=> $this->ExpireYear,
		"expirem"				=> $this->ExpireMonth,
		"amount"				=> $this->GrandTotal,
		"currency"				=> $currency,
		"hash"					=> $newhashvar,
		);
		
		$fields = "";
		foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim($fields, "& " )); // use HTTP POST to send form data
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. 
		
		////////////////////////////////////////////////////////////////////////////////////////////
		// If you have GoDaddy hosting or other hosting services that require use of a proxy to talk to external sites via cURL, 
		// then uncomment the following 5 lines and substitute their proxy server's address for 1.1.1.1 below: 
		if ($row_settingsRS['useproxy'] == 1) {  
		curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, true); 
		curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
		curl_setopt ($ch, CURLOPT_PROXY, $row_settingsRS['proxyaddress']); 
		}
		////////////////////////////////////////////////////////////////////////////////////////////
		
		
		
		$resp = curl_exec($ch); //execute post and get results
		curl_close ($ch);
		
		//log the response to our errortable for authiorization result checking
		$authresultssql = sprintf("Insert into errortable (errorID, errormessage, orderID) values(Null,  '%s', '%s')",
			mysql_real_escape_string($resp),
			mysql_real_escape_string($this->OrderID));
		//run query
		mysql_query($authresultssql);
		
		if(substr($resp, 0, 1) == 'Y') {
			return "1";
		} else {
			return $resp;
		}
		
		mysql_free_result($settingsRS);
		
	}//close chronopay
		
		
	//tested good	
	function versapay() {
						
		//query the database for our settings
		$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";
		$settingsRS = mysql_query($query_settingsRS);
		$row_settingsRS = mysql_fetch_assoc($settingsRS);
		
		//collect all the variables for versapay to handle
		$versapayID =  			$row_settingsRS['versapayID'];         //Payment Gateway I.E. CAD="A00990-01" USD="A00991-01"
		$versapayPassword =  	$row_settingsRS['versapayPassword'];   //Gateway Password I.E. CAD="cadsmwp" USD="usdsmwp"
		$ip = 					$_SERVER['REMOTE_ADDR'];
		$language = 			"en";				//English="en" French="fr"
		
		//set the transaction properties
		$trxnProperties = array(
		"ExactID"					=> $versapayID,					
		"Password"					=> $versapayPassword,			
		"Transaction_Type"			=> "00",				   //Transaction Code I.E. Purchase="00" Pre-Authorization="01" etc.
		"DollarAmount"				=> $this->GrandTotal,
		"Card_Number"				=> $this->CardNumber,	
		"Transaction_Tag"			=> "",                   //may be required
		"Track1"					=> "",
		"Track2"					=> "",
		"Authorization_Num"			=> "",                   //may be required
		"Expiry_Date"				=> $this->ExpireMonth . $this->ExpireYear,
		"CardHoldersName"			=> $this->BillingName . " " . $this->BillingLastName,
		"VerificationStr1"			=> "",
		"VerificationStr2"			=> "",
		"CVD_Presence_Ind"			=> "",
		"Secure_AuthRequired"		=> "",
		"Secure_AuthResult"			=> "",
		"Ecommerce_Flag"			=> "",
		"XID"						=> "",
		"CAVV"						=> $this->SecurityCode,
		"CAVV_Algorithm"			=> "",
		"Reference_No"				=> "",
		"Customer_Ref"				=> "",
		"Reference_3"				=> "",
		"Language"					=> $language,								
		"Client_IP"					=> $ip,					 //This value is only used for fraud investigation.
		"Client_Email"				=> $this->Email,		 //This value is only used for fraud investigation.
		
		// Level 2 fields
		"ZipCode"					=> "",
		"Tax1Amount"				=> "",						// PST
		"Tax1Number"				=> "",						// PST number
		"Tax2Amount"				=> "",						// GST
		"Tax2Number"				=> "",						// GST number
		
		// IDebit fields.  Only used with IDebit system.
		"SurchargeAmount"			=> "",
		"PAN"						=> ""
		);
		
		
		$trxn = array("Transaction"=>$trxnProperties);
		
		try {
			// This line of code will throw a warning which seems to be a bug from either PHP or IIS.  Actual cause not confirmed!
			// Please view http://bugs.php.net/bug.php?id=35758
			$client = new SoapClient("https://secure2.e-xact.com/vplug-in/transaction/rpc-enc/Service.asmx?wsdl");
			$trxnResult = $client->__soapCall('SendAndCommit', $trxn);
		}
		catch (Exception $e){
			return "Transaction Failed!";
		}
		
		if(is_soap_fault($trxnResult)){
			// there was a fault, inform
			return $trxnResult->faultstring;
			$trxnResult["CTR"] = "There was an error while processing. No TRANSACTION DATA IN CTR!";
		}
		
		// kill object
		unset($client);
		
		//log the response to our errortable for authiorization result checking
		$authresultssql = sprintf("Insert into errortable (errorID, errormessage, orderID) values(Null,  '%s', '%s')",
			mysql_real_escape_string(serialize($trxnResult)),
			mysql_real_escape_string($this->OrderID));
		//run query
		mysql_query($authresultssql);
		
		// display the transaction response
		foreach($trxnResult as $key=>$value){
			if($key == "CTR") {
				$value = nl2br($value);
				//echo $value;
				if (strpos($value, 'Approved - Thank You 000')) {
					return "1";
				} else {
					foreach($trxnResult as $key=>$value){
						$value = nl2br($value);
						if ($key == "EXact_Message") {
							$returnArray[] = $value;
						}
					}
					return 'Error 1: ' . $returnArray[0];
				}
			}
		}
		
		mysql_free_result($settingsRS);
	}// close versapay
		
	//tested good	
	function eway() {
		require_once( 'gateways/eway/ewaypayment.php' );
		
		//query the database for our settings
		$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";
		$settingsRS = mysql_query($query_settingsRS);
		$row_settingsRS = mysql_fetch_assoc($settingsRS);
		
		
		/////////////////////////////////////////////////////////////////////////
		//Set the customer Number
		//////////////////////////////////////////////////////////////////////////
		$customer = $row_settingsRS['ewaycustid'];
		
		
		//////////////////////////////////////////////////////////////////////////
		//determine if we are in test mode or regular mode
		/////////////////////////////////////////////////////////////////////////
		if ($row_settingsRS['ewaytestmode'] == 1) {
			//test gateway
			//$eway = new EwayPayment( '87654321', 'https://www.eway.com.au/gateway/xmltest/testpage.asp' );
			$eway = new EwayPayment( '87654321', 'https://www.eway.com.au/gateway/xmltest/testpage.asp' );
		}
		if ($row_settingsRS['ewaytestmode'] == 0) {
			//live gateway
			$eway = new EwayPayment( $customer, 'https://www.eway.com.au/gateway_cvn/xmlpayment.asp' );
		}
		
		//////////////////////////////////////////////////////////////////////////
		//load the variables necessary for  payment, incoming from flash
		/////////////////////////////////////////////////////////////////////////
		$eway->setCustomerFirstname( $this->BillingName ); 
		$eway->setCustomerLastname( $this->BillingLastName );
		$eway->setCustomerEmail( $this->Email );
		$eway->setCustomerAddress( $this->BillingAddress );
		$eway->setCustomerPostcode( $this->BillingZip );
		$eway->setCustomerInvoiceDescription( 'Online Order' );
		$eway->setCustomerInvoiceRef( $this->OrderID );
		$eway->setCardHoldersName( $this->BillingFirstName . " " . $this->BillingLastName);
		$eway->setCardNumber( $this->CardNumber );
		$eway->setTransactionData( $this->SecurityCode ); //new adjustment, must also add lines getters and setters in ewaypayment.php file to work
		$eway->setCardExpiryMonth( $this->ExpireMonth );
		$eway->setCardExpiryYear( $this->ExpireYear );
		$eway->setTrxnNumber( $this->OrderID);
		$eway->setTotalAmount( str_replace('.', '', $this->GrandTotal));
		$eway->setOption1('0');
		$eway->setOption2('0');
		$eway->setOption3('0');
		
		//////////////////////////////////////////////////////////////////////////
		//send payment, receive response
		/////////////////////////////////////////////////////////////////////////
		if( $eway->doPayment() == EWAY_TRANSACTION_OK ) {
			//log the response to our errortable for authiorization result checking
			$authresultssql = sprintf("Insert into errortable (errorID, errormessage, orderID) values(Null,  '%s', '%s')",
				mysql_real_escape_string($eway->getErrorMessage()),
				mysql_real_escape_string($this->OrderID));
			//run query
			mysql_query($authresultssql);
		
			return "1";
		} else {
			//log the response to our errortable for authiorization result checking
			$authresultssql = sprintf("Insert into errortable (errorID, errormessage, orderID) values(Null,  '%s', '%s')",
				mysql_real_escape_string($eway->getErrorMessage()),
				mysql_real_escape_string($this->OrderID));
			//run query
			mysql_query($authresultssql);
			
			return $eway->getErrorMessage();
		}
	}//close eway
		
	//tested good	
	function firstdata() {
		//this is the First Data Order Submission Area
		//query the database for our settings
		$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";
		$settingsRS = mysql_query($query_settingsRS);
		$row_settingsRS = mysql_fetch_assoc($settingsRS);
		
		/////////////////////////////////////////////////////////////////////////
		//Set the Login ID and Transaction Key
		//////////////////////////////////////////////////////////////////////////
		$firstdataloginid = $row_settingsRS['firstdataloginid'];		
		
		//build XML request
		$xml = 
			'<order>'.
				'<merchantinfo>'.
					'<configfile>'.$firstdataloginid.'</configfile>'.
					'<keyfile>certificate.pem</keyfile>'.
					'<host>secure.linkpt.net</host>'.
					'<port>1129</port>'.
				'</merchantinfo>'.
				'<billing>'.
					'<name>'.$this->BillingFirstName." ".$this->BillingLastName.'</name>'.
					'<address1>'.$this->BillingAddress.'</address1>'.
					'<city>'.$this->BillingCity.'</city>'.
					'<state>'.$this->BillingState.'</state>'.
					'<zip>'.$this->BillingZip.'</zip>'.
					'<country>'.$this->BillingCountry.'</country>'.
					'<phone>'.$this->BillingPhone.'</phone>'.
					'<email>'.$this->Email.'</email>'.
				'</billing>'.
				'<shipping>'.
					'<name>'.$this->ShippingName." ".$this->ShippingLastName.'</name>'.
					'<address1>'.$this->ShippingAddress.'</address1>'.
					'<city>'.$this->ShippingCity.'</city>'.
					'<state>'.$this->ShippingState.'</state>'.
					'<zip>'.$this->ShippingZip.'</zip>'.
					'<country>'.$this->ShippingCountry.'</country>'.
				'</shipping>'.
				'<transactiondetails>'.
					'<oid>'.$this->OrderID.'</oid>'.
					'<ip>'.$_SERVER["REMOTE_ADDR"].'</ip>'.
				'</transactiondetails>'.
				'<orderoptions>'.
					'<ordertype>SALE</ordertype>'.
				'</orderoptions>'.
				'<payment>'.
					'<chargetotal>'.$this->GrandTotal.'</chargetotal>'.
				'</payment>'.
				'<creditcard>'.
					'<cardnumber>'.$this->CardNumber.'</cardnumber>'.
					'<cardexpmonth>'.$this->ExpireMonth.'</cardexpmonth>'.
					'<cardexpyear>'.substr($this->ExpireYear, -2).'</cardexpyear>'.
					'<cvmvalue>'.$this->SecurityNumber.'</cvmvalue>'.
					'<cvmindicator>provided</cvmindicator>'.
				'</creditcard>'.
			'</order>';
		
		
		//prepare curl 
		if ($row_settingsRS['firstdatatestmode'] == 1) {
			$_post_url = "https://staging.linkpt.net:1129/LSGSXML";
		} else {
			$_post_url = "https://secure.linkpt.net:1129/LSGSXML";
		}
		
		//return $xml;
		
		$_cert_path = "certificate.pem";
		
		$c = curl_init($_post_url);
		
		curl_setopt($c, CURLOPT_POST, 1); 
		curl_setopt($c, CURLOPT_POSTFIELDS, $xml);
		//curl_setopt($c, CURLOPT_SSLCERT, $_cert_path);
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
		
		////////////////////////////////////////////////////////////////////////////////////////////
		// If you have GoDaddy hosting or other hosting services that require use of a proxy to talk to external sites via cURL, 
		// then uncomment the following 5 lines and substitute their proxy server's address for 1.1.1.1 below: 
		 if ($row_settingsRS['useproxy'] == 1) {  
			curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, true); 
			curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
			curl_setopt ($ch, CURLOPT_PROXY, $row_settingsRS['proxyaddress']); 
		  }
		////////////////////////////////////////////////////////////////////////////////////////////
		
		
		$buffer = curl_exec($c);
		
		$err = '';
		if (curl_error($c) != '') {
			$info = curl_getinfo($c);
			return "Curl Error, ! Cannot connect to the server (" . curl_error($c) . ", HTTP status code: " . $info['http_code'] . '), aborting.';
		} else {
			$info = curl_getinfo($c);
			if ($buffer == '') {
				return "Error, There was a problem transmitting your transaction, please try again."; 
			} elseif ($info['http_code'] != 200) {
				return "HTTP ERROR, ! HTTP error (status code: " . $info['http_code'] . "), aborting.";
			}
		}
		
		//check for a empty buffer
		if(strlen($buffer) < 2){
			//return a error codes transaction
			return "Error, There was a problem transmitting your transaction, please try again."; 
		}
		
		//parse buffer
		preg_match_all("/<(.*?)>(.*?)\</", $buffer, $out, PREG_SET_ORDER);
		$n = 0;
		$result = array();
		$response = "";
		while(isset($out[$n])){
			$result[$out[$n][1]] = strip_tags($out[$n][0]);
			$response.=$out[$n][1]." = ".strip_tags($out[$n][0])."\n";
			$n++; 
		}
		
		//log the response to our errortable for authiorization result checking
		$authresultssql = sprintf("Insert into errortable (errorID, errormessage, orderID) values(Null,  '%s', '%s')",
			mysql_real_escape_string($response),
			mysql_real_escape_string($this->OrderID));
		//run query
		mysql_query($authresultssql);
		
		//check response status
		if(!array_key_exists("r_approved", $result)){
			$result["r_approved"] = "FAILURE";
			if(!array_key_exists("r_error", $result)){
				$result["r_error"] = "Internal Transaction Error. Please try again";
			}
		}
		
		switch($result["r_approved"]){
			//transaction completed
			case "APPROVED" : {							
				//return a successful transaction
				return "1"; 
		
			}
			//transaction error
			default : {							
				//return a error codes transaction
				if ($result["r_error"]) {
					return "ERROR, "  . $result["r_error"] ; 
				} else {
					return "ERROR, There was an unknown error processing your transaction.  Please review your information and submit the order again.  Thank You." ; 
				}
			}
		}
		
	}//close First Data
		
		
	//tested good
	function paymentexpress() {
		//query the database for our settings
		$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";
		$settingsRS = mysql_query($query_settingsRS);
		$row_settingsRS = mysql_fetch_assoc($settingsRS);
		
		$cmdDoTxnTransaction .= "<Txn>";
		$cmdDoTxnTransaction .= "<PostUsername>".$row_settingsRS['paymentexpressusername']."</PostUsername>"; #Insert your DPS Username here
		$cmdDoTxnTransaction .= "<PostPassword>".$row_settingsRS['paymentexpresspassword']."</PostPassword>"; #Insert your DPS Password here
		$cmdDoTxnTransaction .= "<Amount>".$this->GrandTotal."</Amount>";
		$cmdDoTxnTransaction .= "<InputCurrency>".$row_settingsRS['paymentexpresscurrency']."</InputCurrency>";
		$cmdDoTxnTransaction .= "<CardHolderName>".$this->BillingName." ".$this->BillingLastName."</CardHolderName>.";
		$cmdDoTxnTransaction .= "<CardNumber>".$this->CardNumber."</CardNumber>";
		$cmdDoTxnTransaction .= "<Cvc2>".$this->SecurityNumber."</Cvc2>";
		$cmdDoTxnTransaction .= "<DateExpiry>".$this->ExpireMonth.substr($this->ExpireYear, -2)."</DateExpiry>";
		$cmdDoTxnTransaction .= "<TxnType>Purchase</TxnType>";
		$cmdDoTxnTransaction .= "<MerchantReference>".$this->OrderID."</MerchantReference>";
		$cmdDoTxnTransaction .= "</Txn>";
				  
		$URL = "https://sec.paymentexpress.com/pxpost.aspx";
		//echo "\n\n\n\nSENT:\n$cmdDoTxnTransaction\n\n\n\n\n$";
				 
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$cmdDoTxnTransaction);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //Needs to be included if no *.crt is available to verify SSL certificates
		curl_setopt($ch, CURLOPT_SSLVERSION,3);	
		$result = curl_exec ($ch); 
		curl_close ($ch);
		
		$xml_parser = xml_parser_create();
		xml_parse_into_struct($xml_parser, $result, $vals, $index);
		xml_parser_free($xml_parser);
		
		$params = array();
		$level = array();
		foreach ($vals as $xml_elem) {
		  if ($xml_elem['type'] == 'open') {
			  if (array_key_exists('attributes',$xml_elem)) {
				 list($level[$xml_elem['level']],$extra) = array_values($xml_elem['attributes']);
			  } 
			  else {
				$level[$xml_elem['level']] = $xml_elem['tag'];
			  }
		  }
		  if ($xml_elem['type'] == 'complete') {
			  $start_level = 1;
			  $php_stmt = '$params';
						  
			  while($start_level < $xml_elem['level']) {
				 $php_stmt .= '[$level['.$start_level.']]';
				 $start_level++;
			  }
			  $php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
			  eval($php_stmt);
		  }
		}
		
		
		/* Uncommenting this block will display the entire array and show all values returned.
		echo "<pre>";
		print_r ($params);
		echo "</pre>";
		*/
			
		$success = $params[TXN][SUCCESS];
		$authorizedresponse = 	$params[TXN][$success][AUTHORIZED];
		$MerchantReference = $params[TXN][$success][MERCHANTREFERENCE];
		$CardHolderName	= $params[TXN][$success][CARDHOLDERNAME];
		$AuthCode = $params[TXN][$success][AUTHCODE];
		$Amount	= $params[TXN][$success][AMOUNT];
		$CurrencyName = $params[TXN][$success][CURRENCYNAME];
		$TxnType = $params[TXN][$success][TXNTYPE];
		$CardNumber	= $params[TXN][$success][CARDNUMBER];
		$DateExpiry	= $params[TXN][$success][DATEEXPIRY];
		$CardHolderResponseText	= $params[TXN][$success][CARDHOLDERRESPONSETEXT];
		$CardHolderResponseDescription = $params[TXN][$success][CARDHOLDERRESPONSEDESCRIPTION];
		$MerchantResponseText = $params[TXN][$success][MERCHANTRESPONSETEXT];
		$DPSTxnRef = $params[TXN][$success][DPSTXNREF];		
		
		//return $AuthCode . ", " . $CardHolderResponseText . ", " . $CardHolderResponseDescription;
		//////////////////////////////////////////////////////////////////////////
		//send payment, receive response
		/////////////////////////////////////////////////////////////////////////
		
		//log the response to our errortable for authiorization result checking
		$authresultssql = sprintf("Insert into errortable (errorID, errormessage, orderID) values(Null,  '%s', '%s')",
			mysql_real_escape_string($result),
			mysql_real_escape_string($this->OrderID));
		//run query
		mysql_query($authresultssql);
		
		
		if( $authorizedresponse == '1') {
			return "1";//"1," . $CardHolderResponseText .", " . $CardHolderResponseDescription;
		} else {
			return "ERROR: " .$CardHolderResponseDescription;
		}
		
		mysql_free_result($settingsRS);
	}// close paymentexpress
	
	
	function paypal($Cart){
		$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";
		$settingsRS = mysql_query($query_settingsRS);
		$row_settingsRS = mysql_fetch_assoc($settingsRS);
		
		//this is what flash does for variables
		//create the URL Request that will hold our paypal information
		
		//this is actionscript version in flash
		if ($row_settingsRS['usepaypalsandbox'] == 0 ) {
			$paypalRequest = "https://www.paypal.com/cgi-bin/webscr";
		} else {
			$paypalRequest = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		}
		
		//specify the business, amount of the item, shipping, etc.
		
		$formhtml = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title>PayPal Redirect</title>
<link href='".str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", str_replace("scripts/", "", str_replace("l4html/", "", plugin_dir_url(__DIR__) ) ) ) )."levelfourstorefront//scripts/mainstylesheet.css' rel='stylesheet' type='text/css'></head><body>";
		$formhtml .= "<form action=\"".$paypalRequest."\" method=\"post\">";
		$formhtml .= "<input name=\"cmd\" id=\"cmd\" type=\"hidden\" value=\"_cart\" />";
		$formhtml .= "<input name=\"upload\" id=\"upload\" type=\"hidden\" value=\"1\" />";
		$formhtml .= "<input name=\"custom\" id=\"custom\" type=\"hidden\" value=\"".$this->OrderID."\" />";
		$formhtml .= "<input name=\"bn\" id=\"bn\" type=\"hidden\" value=\"LevelFourStorefront_Cart_WPS\" />";
		$formhtml .= "<input name=\"business\" id=\"business\" type=\"hidden\" value=\"".$row_settingsRS['paypalemail']."\" />";
		$formhtml .= "<input name=\"currency_code\" id=\"currency_code\" type=\"hidden\" value=\"".$row_settingsRS['paypalcurcode']."\" />";
		$formhtml .= "<input name=\"handling_cart\" id=\"handling_cart\" type=\"hidden\" value=\"".$this->ShippingTotal."\" />";
		$formhtml .= "<input name=\"discount_amount_cart\" id=\"discount_amount_cart\" type=\"hidden\" value=\"".$this->DiscountTotal."\" />";
		$formhtml .= "<input name=\"tax_cart\" id=\"tax_cart\" type=\"hidden\" value=\"".$this->TaxTotal."\" />";
		$formhtml .= "<input name=\"amount\" id=\"amount\" type=\"hidden\" value=\"".$this->GrandTotal."\" />";
		$formhtml .= "<input name=\"no_shipping\" id=\"no_shipping\" type=\"hidden\" value=\"2\" />";
		$formhtml .= "<input name=\"lc\" id=\"lc\" type=\"hidden\" value=\"".$row_settingsRS['paypallc']."\" />";
		$formhtml .= "<input name=\"notify_url\" id=\"notify_url\" type=\"hidden\" value=\"".  str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", str_replace("scripts/", "", str_replace("l4html/", "", plugin_dir_url(__DIR__) ) ) ) ) . "levelfourstorefront/scripts/paypalipn.php"."\" />";
		
		//customer billing information and address info
		$formhtml .= "<input name=\"first_name\" id=\"first_name\" type=\"hidden\" value=\"".$this->BillingName."\" />";
		$formhtml .= "<input name=\"last_name\" id=\"last_name\" type=\"hidden\" value=\"".$this->BillingLastName."\" />";
		$formhtml .= "<input name=\"address1\" id=\"address1\" type=\"hidden\" value=\"".$this->BillingAddress."\" />";
		$formhtml .= "<input name=\"city\" id=\"city\" type=\"hidden\" value=\"".$this->BillingCity."\" />";
		$formhtml .= "<input name=\"state\" id=\"state\" type=\"hidden\" value=\"".strtoupper($this->BillingState)."\" />";
		$formhtml .= "<input name=\"zip\" id=\"zip\" type=\"hidden\" value=\"".$this->BillingZip."\" />";
		$formhtml .= "<input name=\"country\" id=\"country\" type=\"hidden\" value=\"".$this->BillingCountry."\" />";
		$formhtml .= "<input name=\"email\" id=\"email\" type=\"hidden\" value=\"".$this->Email."\" />";
		
		//add the cart contents to paypal
		for($x = 0; $x<count($Cart); $x++){
			$paypalcounter = $x+1;
			$formhtml .= "<input name=\"item_name_".$paypalcounter."\" id=\"item_name_".$paypalcounter."\" type=\"hidden\" value=\"".$Cart[$x]['title']."\" />";
			$formhtml .= "<input name=\"amount_".$paypalcounter."\" id=\"amount_".$paypalcounter."\" type=\"hidden\" value=\"".$Cart[$x]['price']."\" />";
			$formhtml .= "<input name=\"quantity_".$paypalcounter."\" id=\"quantity_".$paypalcounter."\" type=\"hidden\" value=\"".$Cart[$x]['quantity']."\" />";
			$formhtml .= "<input name=\"shipping_".$paypalcounter."\" id=\"shipping_".$paypalcounter."\" type=\"hidden\" value=\"0.00\" />";
			$formhtml .= "<input name=\"shipping2_".$paypalcounter."\" id=\"shipping2_".$paypalcounter."\" type=\"hidden\" value=\"0.00\" />";
		}
		
		//Now add the design stuff!
		$formhtml .= "<div class=\"paypalalign\"><img src=\"".str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", str_replace("scripts/", "", str_replace("l4html/", "", plugin_dir_url(__DIR__) ) ) ) )."levelfourstorefront/images/paypalimg.jpg\" alt=\"PayPal Image\"><br \>Your order has been placed and is 'Pending Payment' from PayPal. To complete your order you must be redirected to PayPal. Once the order has been completed through PayPal you will be brought back to our site.<br /><br /><input type=\"submit\" value=\"Click Here to Complete Order\" /></div>";
		
		$formhtml .= "</form></body></html>";
		
		return $formhtml;
	}//close paypal
}
?>