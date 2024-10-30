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

unset($_SESSION['EmailNew']);

unset($_SESSION['BillingName']);

unset($_SESSION['BillingLastName']);

unset($_SESSION['BillingAddress']);

unset($_SESSION['BillingCity']);

unset($_SESSION['BillingState']);

unset($_SESSION['BillingZip']);

unset($_SESSION['BillingCountry']);

unset($_SESSION['BillingPhone']);

unset($_SESSION['UseBilling']);

unset($_SESSION['ShippingName']);

unset($_SESSION['ShippingLastName']);

unset($_SESSION['ShippingAddress']);

unset($_SESSION['ShippingCity']);

unset($_SESSION['ShippingState']);

unset($_SESSION['ShippingZip']);

unset($_SESSION['ShippingCountry']);

unset($_SESSION['ShippingPhone']);

unset($_SESSION['ShipExpress']);

unset($_SESSION['CouponCode']);

unset($_SESSION['GiftCard']);

unset($_SESSION['l4username']);

unset($_SESSION['l4password']);

unset($_SESSION['l4userlevel']);

unset($_SESSION['currcouponcode']);

header("location:".$cartpage);

?>