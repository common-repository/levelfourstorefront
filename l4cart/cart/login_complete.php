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

<div class="l4store_header" style="margin-top:10px;">Account Information</div>

<div class="checkout_form_content">

	<div class="login_complete_padding">

    	<?php if($_SESSION['l4userlevel'] == "guest"){?>

        <div>You are currently checking out as a guest. To checkout with a different account, <a href="<?php echo $cartpage.$permalinkdivider; ?>l4_action=signout" class="l4store_link">click here</a>.</div>

        <?php }else{ ?>

        <div>You have already completed step one by signing in. To checkout with a different account, <a href="<?php echo $cartpage.$permalinkdivider; ?>l4_action=signout" class="l4store_link">click here</a>.</div>

		<?php }?>

    </div>

</div>