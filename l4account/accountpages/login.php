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

<div id="errortext2" class="errortext_full">Please make corrections to the highlighted fields.</div>

<div class="login_main">	

	<div class="login_space">&nbsp;&nbsp;&nbsp;</div>

    <div class="login_left">

		<div class="l4store_title">Your Account</div>

      	<div class="login_content_small">Registered users can login here</div>

        <div>

        	<form id="loginForm" name="loginForm" method="post" action="<?php echo $accountpage; ?>" onSubmit="return check_login_form(this); return false;">

         		<div class="register_row"><div class="login_label">Email:</div><div class="login_field_align"><input type="text" name="SigninEmail" id="SigninEmail" class="login_field">

				</div></div>

              	<div class="register_row"><div class="login_label">Password:</div><div class="login_field_align"><input type="password" name="SigninPassword" id="SigninPassword" class="login_field">

                </div></div>
				<input type="hidden" name="accounturl" value="<?php echo $accountpage; ?>" />
                <div class="register_row"><div class="login_label">&nbsp;&nbsp;&nbsp;</div><div class="login_button_align"><input type="submit" name="signin" id="signin" value="Log In" class="l4store_button"></div></div>

				<input type="hidden" name="l4_action" value="login" />

                <div class="register_row"><div class="login_label">&nbsp;&nbsp;&nbsp;</div><div class="login_field_align"><a href="<?php echo $accountpage . $permalinkdivider; ?>page=forgotpw" class="l4store_link">Forgot your Password?</a></div></div>

	        </form>

    	</div>

    </div>

    <div class="login_divider"></div>

    <div class="login_right">

    	<div class="l4store_title">Not Registered?</div>

        <div class="login_content_small">Create an account to take full advantage of this website</div>

        <div>

        	<div class="login_button_align"><a href="<?php echo $accountpage . $permalinkdivider; ?>page=register" class="l4store_button" style="color:#FFF;">Create Account</a></div>

        </div>

	</div>

</div>