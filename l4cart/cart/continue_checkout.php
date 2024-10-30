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

<div class="l4store_header">Continue to Payment</div>

<div class="checkout_form_content">

	<div class="checkout_form_holder_wide">

        <div class="checkout_form_holder_single">

            <div id="errortext2" class="errortext_full">Please make corrections to the highlighted fields.</div>

            <div class="coupon_text">Applicable coupons, discounts, and local taxes will be applied on the next page of checkout.</div>

            <div><input type="submit" value="Continue" onclick="return check_billing_shipping_information('<?php echo $_SESSION['l4userlevel']; ?>'); return false;" class="l4store_button" /></div>

		</div>

    </div>

</div>