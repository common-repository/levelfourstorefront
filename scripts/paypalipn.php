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


// PHP 4.1

require_once('../Connections/flashdb.php');

mysql_select_db($database_flashdb, $flashdb);



$settingsquery= mysql_query("Select * from settings where settingID = '1'");

$settings = mysql_fetch_array($settingsquery);



// Read the post from PayPal and add 'cmd'

$req = 'cmd=_notify-validate';



if(function_exists('get_magic_quotes_gpc'))

{

$get_magic_quotes_exits = true;

}

foreach ($_POST as $key => $value)

// Handle escape characters, which depends on setting of magic quotes

{

if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1){

$value = urlencode(stripslashes($value));

} else {

$value = urlencode($value);

}

$req .= "&$key=$value";

}

// Post back to PayPal to validate

$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";

$header .= "Content-Type: application/x-www-form-urlencoded\r\n";

$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

if ( $settings['usepaypalsandbox'] == 1) {

	$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

} else {

	$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

}



function recorderror($errortype, $errormessage, $orderid) {

	$geterrors = mysql_query("SELECT * FROM errortable WHERE orderID = '".$orderid."'");

	//test to see if there were any matching subscribers

	if(!mysql_fetch_array($geterrors)) {

		//build the Insert query

		$errorSQL = sprintf("Insert into errortable (errorID, errormessage, orderID) values (Null,  '%s', '%s')",

		mysql_real_escape_string($errormessage),

		mysql_real_escape_string($orderid));

		//run query

		mysql_query($errorSQL);

	} else {

		//delete any who have the same email

		mysql_query("DELETE FROM errortable WHERE orderID = '".$orderid."'");

		//build the Insert query

		$errorSQL = sprintf("Insert into errortable (errorID, errormessage, orderID) values (Null,  '%s', '%s')",

		mysql_real_escape_string($errormessage),

		mysql_real_escape_string($orderid));

		//run query

		mysql_query($errorSQL);

	}	

}



function sendemail($clientemail, $OrderID){

		//the following sends an itemized record of the shopping experience for each order.

		// retrieve the clients name and email

		$result1 = mysql_query("Select BillName, BillLastName, BillAddress, BillCity, BillState, BillCountry, BillZip, BillPhone, ShipName, ShipLastName, ShipAddress, ShipCity, ShipState, ShipCountry, ShipZip, ShipPhone, Email from orders where Email='".$clientemail."'");

		$client = mysql_fetch_array($result1);	

		

		

		

		////////////////////////////////////////////////////////////////////////////////////////////////////////////

		/////////THIS PORTION OF CONFIRMATION EMAILER IS IDENTICAL TO THAT FOUND THROUGHOUT THE CODE////////////////

		/////////YOU CAN COPY AND PASTE YOUR DESIGNED EMAILER TO ALL THE SPECIFIC LOCATIONS AND IPN////////////////

		/////////SERVICES THROUGHOUT THE STOREFRONT CODE///////////////////////////////////////////////////////////

		///////////////////////////////////////////////////////////////////////////////////////////////////////////

			

		// retrieve the total and shipping from orderID

		$result2 = mysql_query("Select * from orders where OrderID='".$OrderID."'");

		$order = mysql_fetch_array($result2);

		//Select details of each item for an itemized record

		$result3 = mysql_query("Select * from details  where OrderID='".$OrderID."'");

		//get settings for email handling information

		$settingsquery= mysql_query("Select * from settings where settingID = '1'");

		$settings = mysql_fetch_array($settingsquery);

		//Build the email message with full itemized paging

		$Text = "This email is html, please switch to this view";

		$salestax = number_format($order[Tax], 2);

		$shippingcost = number_format($order[Shipping], 2);

		$message = "--==MIME_BOUNDRY_alt_main_message\n";

		$message .= "Content-Type: text/plain; charset=ISO-8859-1\n";

		$message .= "Content-Transfer-Encoding: 7bit\n\n";

		$message .= $Text . "\n\n";

		$message .= "--==MIME_BOUNDRY_alt_main_message\n";

		$message .= "Content-Type: text/html; charset=ISO-8859-1\n";

		$message .= "Content-Transfer-Encoding: 7bit\n\n";

		$message .= "<html><head><title>..::Order Confirmation - Order Number $OrderID ::..</title><style type='text/css'><!--.style20 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }.style22 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }--></style></head><body> <table width='539' border='0' align='center'>   <tr><td colspan='4' align='left' class='style22'><img src='http://$settings[siteURL]/images/emaillogo.jpg' width='532' height='97'></td></tr><tr><td colspan='4' align='left' class='style22'><p><br> Dear $client[BillName]  $client[BillLastName]: </p><p>Thank you for your order!  Your Reference Number is: <strong>$OrderID</strong></p><p>Below is a  summary of order. You can check the status of your order and all the details by visiting our website and logging into your account.</p><p>Please keep this as a record of your order!<br><br><br></p></td></tr><tr><td colspan='4' align='left' class='style20'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td width='47%' bgcolor='#F3F1ED' class='style20'>Billing Address</td><td width='3%'>&nbsp;</td><td width='50%' bgcolor='#F3F1ED' class='style20'>Shipping Address</td></tr><tr>   <td><span class='style22'>     $client[BillName]       $client[BillLastName]    </span></td>    <td>&nbsp;</td>   <td><span class='style22'>     $client[ShipName]       $client[ShipLastName]     </span></td> </tr><tr><td><span class='style22'> $client[BillAddress]  </span></td>   <td>&nbsp;</td><td><span class='style22'>     $client[ShipAddress]    </span></td> </tr><tr><td><span class='style22'>       $client[BillCity]        , $client[BillState]   &nbsp;  $client[BillZip]  </span></td>   <td>&nbsp;</td>   <td><span class='style22'>     $client[ShipCity]      , $client[ShipState]       &nbsp; $client[ShipZip]    </span></td> </tr><tr><td><span class='style22'>Phone:    $client[BillPhone]  </span></td>   <td>&nbsp;</td><td><span class='style22'>Phone:      $client[ShipPhone]    </span></td> </tr></table></td></tr><tr><td width='269' align='left'>&nbsp;</td><td width='80' align='center'>&nbsp;</td><td width='91' align='center'>&nbsp;</td><td align='center'>&nbsp;</td></tr><tr><td width='269' align='left' bgcolor='#F3F1ED' class='style20'>Product</td><td width='80' align='center' bgcolor='#F3F1ED' class='style20'>Qty</td><td width='91' align='center' bgcolor='#F3F1ED' class='style20'>Unit Price</td><td align='center' bgcolor='#F3F1ED' class='style20'>Ext Price</td></tr>";

		while($row=mysql_fetch_array($result3)) 

		{

			$finaltotal = number_format($row[OrderPrice]+$row[OrderGratuity], 2);

			$totalitemprice = number_format($row[Quantity]*$row[OrderPrice], 2);

			$message .= "<tr><td width='269' class='style22'>$row[OrderTitle]</td><td width='80' align='center' class='style22'>$row[Quantity]</td><td width='91' align='center' class='style22'>$$finaltotal </td><td align='center' class='style22'>$$totalitemprice</td></tr> ";

			

		}

		$total = number_format($order[Total], 2);

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











		//Send email to client and return error if not.

		//if results, convert to an array for use in flash

		mail($client[Email], "Order Confirmation -- #$OrderID", $message, $headers);

}





//Build Customer Variables

$Customer_Email = '';
$payment_type = $_POST['payment_type'];
$payment_status = $_POST['payment_status'];
$payment_invoice = $_POST['custom'];
$payment_amount = $_POST['mc_gross'];
$payment_txn_id = $_POST['txn_id'];
$payment_paypal_id = $_POST['payer_id'];

$orderquery= mysql_query("Select * from orders where orders.OrderID = $payment_invoice");

$order = mysql_fetch_array($orderquery);





// Process validation from PayPal

// TODO: This sample does not test the HTTP response code. All

// HTTP response codes must be handles or you should use an HTTP

// library, such as cUrl
$x = 0;
$justupdate = true;

if (!$fp) { // HTTP ERROR

} else {

	// NO HTTP ERROR

	fputs ($fp, $header . $req);

	while (!feof($fp)) {
		
		$res = fgets ($fp, 1024);
		$x += 1;
		if ($x == 1) {
		//if (strcmp($res, "VERIFIED") == -1) {
			if ($order['OrderID'] == $payment_invoice) {


				if ($order['Total'] == $payment_amount) {
	
					if ($payment_status == 'Completed') {
	
						//build the Insert Query
						if (isset($_POST['payer_email'])) {
							$Customer_Email = $_POST['payer_email'];
						} else {
							$Customer_Email = '';
						}
						
						if (!isset($order['PaypalTransactionID']) || trim($order['PaypalTransactionID'])==='') {
							$justupdate = false;
						} else {
							
						}
	
						$ordersql = sprintf("UPDATE orders SET OrderStatus='PayPal Approved', PaypalEmailID = '".$Customer_Email."', PaypalTransactionID = '".$payment_txn_id."', PaypalPayerID='".$payment_paypal_id."' WHERE orders.OrderID = '%s'" ,	mysql_real_escape_string($payment_invoice));
	
						//send the query
	
						mysql_query($ordersql);
	
					
	
						$errorcode = "Completed, Payment Type: " . $payment_type;
	
						$errortype = 'PayPal Approved';
	
						recorderror($errortype, $errorcode, $payment_invoice);
						
						if ($justupdate == false) {
							sendemail($Customer_Email, $payment_invoice);
						}
							
	
					} else {
	
						//build the Insert Query
						if (isset($_POST['payer_email'])) {
							$Customer_Email = $_POST['payer_email'];
						} else {
							$Customer_Email = '';
						}
	
						$ordersql = sprintf("UPDATE orders SET OrderStatus='PayPal Pending', PaypalEmailID = '".$Customer_Email."', PaypalTransactionID = '".$payment_txn_id."', PaypalPayerID='".$payment_paypal_id."' WHERE orders.OrderID = '%s'" ,	mysql_real_escape_string($payment_invoice));
	
						//send the query
	
						mysql_query($ordersql);
	
					
	
						$payment_pending_reason = $_POST['pending_reason'];
	
						$errorcode = "Payment Status: ," . $payment_status . ", Payment Type: " . $payment_type . ", Pending Reason: " . $payment_pending_reason. ' amount1: ' .$payment_amount . ' amount2: ' .$order['Total'];
	
						$errortype = 'PayPal Error';
	
						recorderror($errortype, $errorcode, $payment_invoice);
	
					} //end if it is completed or not
	
				} else {
	
					//build the Insert Query
						if (isset($_POST['payer_email'])) {
							$Customer_Email = $_POST['payer_email'];
						} else {
							$Customer_Email = '';
						}
	
						$ordersql = sprintf("UPDATE orders SET OrderStatus='PayPal Error', PaypalEmailID = '".$Customer_Email."', PaypalTransactionID = '".$payment_txn_id."', PaypalPayerID='".$payment_paypal_id."' WHERE orders.OrderID = '%s'" ,	mysql_real_escape_string($payment_invoice));
	
						//send the query
	
						mysql_query($ordersql);
	
					
	
						$payment_pending_reason = $_POST['pending_reason'];
	
						$errorcode = "Payment Status: ," . $payment_status . ", Amount Match Incorrect , Payment Type: " . $payment_type . ", Pending Reason: " . $payment_pending_reason;
	
						$errortype = 'PayPal Error';
	
						recorderror($errortype, $errorcode, $payment_invoice);
	
	
	
				} //end if the total matches
			} //end if it's the same order ID
		}//end our loop control

/*		} else {

			// If 'INVALID', send an email. TODO: Log for manual investigation.

			//build the Insert Query

				$ordersql = sprintf("UPDATE orders SET OrderStatus='PayPal Error' WHERE orders.OrderID = '%s'" ,	mysql_real_escape_string($payment_invoice));

				//send the query

				mysql_query($ordersql);

			

				$payment_pending_reason = $_POST['pending_reason'];

				$errorcode = "Payment Status: , " . $payment_status . " - INVALID, Payment Type: " . $payment_type . ", Pending Reason: " . $payment_pending_reason;

				$errortype = 'PayPal Error';

				recorderror($errortype, $errorcode, $payment_invoice);

		}*/

	}

}





fclose ($fp);

?>