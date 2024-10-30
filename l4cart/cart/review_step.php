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

<div class="l4store_header">Review Billing and Shipping Information</div>

<div class="checkout_review_content">

    <div class="checkout_form_padding">

    	<div class="checkout_review_spacer">&nbsp;&nbsp;&nbsp;</div>

		<div class="checkout_review_billing_form">

            <div class="checkout_review_title">Billing Address:</div>

                <?php echo $_SESSION['BillingName'] . " " . $_SESSION['BillingLastName']; ?><br /><?php echo $_SESSION['BillingAddress']; ?><br /><?php echo $_SESSION['BillingCity'] . ", " . $_SESSION['BillingState'] . " " . $_SESSION['BillingZip']; ?><br /><?php echo $_SESSION['BillingPhone']; ?>

            </div>

        <div class="checkout_review_spacer2">&nbsp;&nbsp;&nbsp;</div>

        <div class="checkout_review_shipping_form">

            <div class="checkout_review_title">Shipping Address:</div>

            <?php echo $_SESSION['ShippingName'] . " " . $_SESSION['ShippingLastName']; ?><br /><?php echo $_SESSION['ShippingAddress']; ?><br /><?php echo $_SESSION['ShippingCity'] . ", " . $_SESSION['ShippingState'] . " " . $_SESSION['ShippingZip']; ?><br /><?php echo $_SESSION['ShippingPhone']; ?>

        </div>

        <div class="checkout_review_spacer">&nbsp;&nbsp;&nbsp;</div>

        <div class="checkout_review_form">

            <br />

            <a href="<?php echo $cartpage; ?>" class="l4store_link">Edit Addresses or Shipping Options</a>

        </div>

    </div>

</div>

<input type="hidden" name="BillingName" id="BillingName" value="<?php echo $_SESSION['BillingName']; ?>" />

<input type="hidden" name="BillingLastName" id="BillingLastName" value="<?php echo $_SESSION['BillingLastName']; ?>" />

<input type="hidden" name="BillingAddress" id="BillingAddress" value="<?php echo $_SESSION['BillingAddress']; ?>" />

<input type="hidden" name="BillingCity" id="BillingCity" value="<?php echo $_SESSION['BillingCity']; ?>" />

<input type="hidden" name="BillingState" id="BillingState" value="<?php echo $_SESSION['BillingState']; ?>" />

<input type="hidden" name="BillingZip" id="BillingZip" value="<?php echo $_SESSION['BillingZip']; ?>" />

<input type="hidden" name="BillingCountry" id="BillingCountry" value="<?php echo $_SESSION['BillingCountry']; ?>" />

<input type="hidden" name="BillingPhone" id="BillingPhone" value="<?php echo $_SESSION['BillingPhone']; ?>" />



<input type="hidden" name="ShippingName" id="ShippingName" value="<?php echo $_SESSION['ShippingName']; ?>" />

<input type="hidden" name="ShippingLastName" id="ShippingLastName" value="<?php echo $_SESSION['ShippingLastName']; ?>" />

<input type="hidden" name="ShippingAddress" id="ShippingAddress" value="<?php echo $_SESSION['ShippingAddress']; ?>" />

<input type="hidden" name="ShippingCity" id="ShippingCity" value="<?php echo $_SESSION['ShippingCity']; ?>" />

<input type="hidden" name="ShippingState" id="ShippingState" value="<?php echo $_SESSION['ShippingState']; ?>" />

<input type="hidden" name="ShippingZip" id="ShippingZip" value="<?php echo $_SESSION['ShippingZip']; ?>" />

<input type="hidden" name="ShippingCountry" id="ShippingCountry" value="<?php echo $_SESSION['ShippingCountry']; ?>" />

<input type="hidden" name="ShippingPhone" id="ShippingPhone" value="<?php echo $_SESSION['ShippingPhone']; ?>" />



<input type="hidden" name="ShipExpress" id="ShipExpress" value="<?php echo $_SESSION['ShipExpress']; ?>" />

<input type="hidden" name="CouponCode" id="CouponCode" value="<?php echo $_SESSION['CouponCode']; ?>" />

<input type="hidden" name="GiftCard" id="GiftCard" value="<?php echo $_SESSION['GiftCard']; ?>" />