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

<div class="checkout_form_content">

	<div class="login_complete_padding">

    	<div style="float:left; margin-left:5px;"><a href="<?php if(isset($_GET['ModelNumber'])){ echo $storepage.$permalinkdivider."ModelNumber=".$_GET['ModelNumber']; }else{ echo $storepage; } ?>" class="l4store_button">Continue Shopping</a></div><div style="float:right; margin-right:5px;"><a href="<?php echo $cartpage; ?>" class="l4store_button">Checkout</a></div>
        
        <div class="clear"></div>

    </div>

</div>