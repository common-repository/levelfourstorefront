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

?>

<div class="cart_price_row">

	<div class="cart_long_spacer">Shipping:</div>

    <div class="cart_price_spacer"><div class="cart_total_text"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($ShippingPrice, 2); ?></div></div>

</div>

<div class="cart_price_row">

	<div class="cart_long_spacer">Tax:</div>

    <div class="cart_price_spacer"><div class="cart_total_text"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($TaxPrice, 2); ?></div></div>

</div>

<div class="cart_price_row">

	<div class="cart_long_spacer">Discounts:</div>

    <div class="cart_price_spacer"><div class="cart_total_text"><?php if($DiscountsPrice > 0){?>-<?php }?><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($DiscountsPrice, 2); ?></div></div>

</div>

<div class="cart_price_row" style="margin-bottom:8px;">

	<div class="cart_long_spacer">Total Due:</div>

    <div class="cart_price_spacer"><div class="cart_total_text"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($GrandTotalPrice, 2); ?></div></div>

</div>