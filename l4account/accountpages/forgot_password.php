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

function checkform(){

	var errors = 0;

	

	if(document.getElementById('Email').value.length == 0){

		document.getElementById('Email').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('Email').style.border = "solid 1px #666666";

	}

	

	if(errors == 0){	

		document.forms["form2"].submit();

	}	

}

</script>


<div class="forgotpw_main">	

	<div class="l4store_title">Retrieve Your Password</div>

    <form name="form2" method="post" action="<?php echo $accountpage; ?>">

       <div class="register_row"><div class="register_label">Email:</div><div class="register_field_align"><input type="text" name="EmailAddress" id="EmailAddress" class="forgotpw_field"></div></div>

       <div class="register_row"><div class="register_label">&nbsp;&nbsp;</div><div class="register_field_align"><input type="submit" name="button2" id="button2" value="Retrieve Password" onclick="checkform(); return false;" class="l4store_button">&nbsp;&nbsp;&nbsp;&nbsp;or <a href="<?php echo $accountpage; ?>" class="l4store_link">cancel</a></div></div>

		<input type="hidden" name="l4_action" value="forgotpassword" />
        
    </form>

</div>