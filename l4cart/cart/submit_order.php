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

<div class="l4store_header">Submit Order</div>

<div class="checkout_review_content">

	<div class="checkout_form_padding">

    	<div class="errortext_full" id="AgreeToTermsError">Please agree to the terms and conditions</div>

        <div class="checkout_form_holder_single">

            <input type="checkbox" name="AgreeTerms" id="AgreeTerms" class="agree_checkbox" /> I agree to the Terms and Conditions and Privacy Policy of this website.

        </div>

        <div class="checkout_form_holder_single_left">

            <div class="guest_text"><?php echo get_option('l4_option_submit_order_text'); ?></div>

        </div>

        <div class="checkout_form_holder_single">
        	<input type="hidden" name="l4_action" value="submitorder" />
        	<input type="submit" value="Submit Order" onclick="check_submit_form(<?php if($_SESSION['l4userlevel'] == "guest"){echo 1;}else{echo 0;} ?>, <?php echo $cartGrandTotal; ?>); return false;" class="l4store_button" />

        </div>

	</div>

</div>