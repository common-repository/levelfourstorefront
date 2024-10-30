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



//set our connection variables

$dbhost = HOSTNAME;

$dbname = DATABASE;

$dbuser = USERNAME;

$dbpass = PASSWORD;	

//make a connection to our database

$conn = mysql_pconnect($dbhost, $dbuser, $dbpass);

mysql_select_db ($dbname);		


/////////////////////////////////////////////////

//query for our temporary cart, including options

/////////////////////////////////////////////////

$cart_query = sprintf("SELECT tempcart.*, optionitems1.optionitemname as option1name, optionitems1.optionitemprice as option1price, optionitems2.optionitemname as option2name, optionitems2.optionitemprice as option2price, optionitems3.optionitemname as option3name, optionitems3.optionitemprice as option3price, optionitems4.optionitemname as option4name, optionitems4.optionitemprice as option4price, optionitems5.optionitemname as option5name, optionitems5.optionitemprice as option5price, products.useoptionitemimages, optionitemimages.Image1 as OptionItemImage1 FROM tempcart LEFT JOIN products ON (products.ProductID = tempcart.ProductID) LEFT JOIN optionitemimages ON (optionitemimages.productID = tempcart.ProductID AND optionitemimages.optionitemID = tempcart.orderoption1) LEFT JOIN optionitems as optionitems1 ON(optionitems1.optionitemID = tempcart.orderoption1) LEFT JOIN optionitems as optionitems2 ON(optionitems2.optionitemID = tempcart.orderoption2) LEFT JOIN optionitems as optionitems3 ON(optionitems3.optionitemID = tempcart.orderoption3) LEFT JOIN optionitems as optionitems4 ON(optionitems4.optionitemID = tempcart.orderoption4) LEFT JOIN optionitems as optionitems5 ON(optionitems5.optionitemID = tempcart.orderoption5) WHERE tempcart.sessionid = '%s'", mysql_real_escape_string(session_id()));

$cart = mysql_query($cart_query);

$cart_numrows = mysql_num_rows($cart);



if(isset($_SESSION['currcouponcode']) && strlen(trim($_SESSION['currcouponcode'])) > 0){

	mysql_select_db($database_flashdb, $flashdb);

	$query_coupon = sprintf("SELECT * FROM promocodes WHERE promoID = '%s'", mysql_real_escape_string($_SESSION['currcouponcode']));

	$Counpons = mysql_query($query_coupon, $flashdb) or die(mysql_error());

	$row_Coupons = mysql_fetch_assoc($Counpons);

	$totalRows_Coupons = mysql_num_rows($Counpons);

}

?>