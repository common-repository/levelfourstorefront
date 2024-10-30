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

<div class="l4store_header">Contact Information</div>

<div class="checkout_review_content">

	<div class="checkout_form_padding">

    	<div class="form_row l4inactive" id="CreateAccountEmailError">

        	<div class="checkout_form_paypal_message errorcolor">This email address is already associated with an account, please <a href="../l4cartscripts/signout.php" class="checkout_review_link">login here</a> to continue with this email address.</div>

        </div>

        <div class="form_row">

	    	<div class="checkout_form_label">Email:</div>

        	<div class="checkout_form_input">

            	<input type="text" name="EmailNew" id="EmailNew" class="checkout_form_email_input" value="<?php if($_SESSION['l4username'] != "guest_checkout" && $_SESSION['l4username'] != ""){ echo $_SESSION['l4username']; } ?>" onchange="update_show_account_form();" />

            </div>

        </div>

        <div class="form_row">

	    	<div class="checkout_form_label">Retype Email:</div>

        	<div class="checkout_form_input">

            	<input type="text" name="EmailNewRetype" id="EmailNewRetype" class="checkout_form_email_input" autocomplete="off" <?php if($_SESSION['l4username'] != "guest_checkout" && $_SESSION['l4username'] != ""){ echo "value=\"".$_SESSION['l4username']."\" "; } ?>/>

            </div>

        </div>

	</div>

</div>