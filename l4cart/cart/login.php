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

<script type="text/javascript">

function check_login_form(f){

	var errors = 0;

	if(document.getElementById('SigninEmail').value.length == 0){

		document.getElementById('SigninEmail').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('SigninEmail').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('SigninPassword').value.length == 0){

		document.getElementById('SigninPassword').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('SigninPassword').style.border = "solid 1px #666666";

	}

	

	if(errors == 0){	

		
		document.getElementById('errortext2').style.display = "none";
		
		
		
		
		f.submit();
		
		
		
		return false;

	}else{
		
		document.getElementById('errortext2').style.display = "block";
		
		return false;

	}

}



</script>

<div class="l4store_header" style="margin-top:10px;">Account Information</div>
<div class="checkout_form_content">
	<div class="checkout_form_padding">
    	<div id="errortext2" class="errortext_full">Please make corrections to the highlighted fields</div>
        <div class="checkout_form_title">Please sign in or proceed as a guest</div>
        <div class="checkout_signin_form">
            <form id="cart_signin_form" name="cart_signin_form" method="post" action="<?php echo $cartpage; ?>" onsubmit="return check_login_form(); return false;">
                <div class="register_row"><div class="checkout_form_label_nomargleft">Email:</div><div class="checkout_form_input"><input type="text" name="SigninEmail" id="SigninEmail" class="checkout_form_email_input" /></div></div>
                <div class="register_row"><div class="checkout_form_label_nomargleft">Password:</div><div class="checkout_form_input"><input type="password" name="SigninPassword" id="SigninPassword" class="checkout_form_password_input" /></div></div>
                <div class="checkout_form_label_nomargleft">&nbsp;&nbsp;&nbsp;</div><div class="checkout_form_input"><input type="submit" value="Sign In" class="l4store_button" /></div>
                <div class="checkout_form_label_nomargleft">&nbsp;&nbsp;&nbsp;</div><div class="login_field_align"><a href="<?php echo $accountpage . $permalinkdivider; ?>page=forgotpw" class="l4store_link">Forgot your Password?</a></div>
                
                <input type="hidden" name="l4_action" value="login" />
                    
            </form>
        </div>
        <div class="checkout_form_divider"></div>
        <div class="checkout_create_account_form">
            <div class="guest_text"><?php echo get_option('l4_option_guest_text'); ?></div>
            <div class="floatleft">
                <form id="cart_guest_checkout" name="cart_guest_checkout" method="post" action="<?php echo $cartpage; ?>">
                    <input type="submit" value="Continue Checkout" class="l4store_button" />
                    <input type="hidden" name="l4_action" value="guestcheckout" />
                </form>
            </div>
        </div>
    </div>
</div>