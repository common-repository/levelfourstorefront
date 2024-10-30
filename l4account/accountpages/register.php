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

function check_register_form(f){

	var errors = 0;

	if(document.getElementById('FirstName').value.length == 0){

		document.getElementById('FirstName').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('FirstName').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('LastName').value.length == 0){

		document.getElementById('LastName').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('LastName').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('ZipCode').value.length == 0){

		document.getElementById('ZipCode').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('ZipCode').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('EmailAddress').value.length == 0){

		document.getElementById('EmailAddress').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('EmailAddress').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('RegisterPassword').value.length < 6){

		document.getElementById('RegisterPassword').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('RegisterPassword').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('RetypePassword').value.length < 6){

		document.getElementById('RetypePassword').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('RetypePassword').style.border = "solid 1px #666666";

	}
	
	
	if(document.getElementById('RegisterPassword').value.length != 0 && document.getElementById('RetypePassword').value.length != 0 && document.getElementById('RegisterPassword').value != document.getElementById('RetypePassword').value){

		document.getElementById('RegisterPassword').style.border = "solid 1px #CC0000";
		
		document.getElementById('RetypePassword').style.border = "solid 1px #CC0000";

		errors++;

	}else if(document.getElementById('RegisterPassword').value.length != 0 && document.getElementById('RetypePassword').value.length != 0){

		document.getElementById('RegisterPassword').style.border = "solid 1px #666666";
		
		document.getElementById('RetypePassword').style.border = "solid 1px #666666";

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

<div class="register_main">

    <div class="l4store_header">Create a New Account</div>

    <div class="register_content_small">*Required Information</div>

    <form id="registerForm" name="registerForm" method="post" action="<?php echo $accountpage; ?>" onsubmit="return check_register_form(); return false;">

        <div class="register_row"><div class="register_label">First Name:*</div><div class="register_field_align"><input type="text" name="FirstName" id="FirstName" class="login_field"></div></div>

        <div class="register_row"><div class="register_label">Last Name:* </div><div class="register_field_align"><input type="text" name="LastName" id="LastName" class="login_field"></div></div>

        <div class="register_row"><div class="register_label">Zip/Postal Code:* </div><div class="register_field_align"><input type="text" name="ZipCode" id="ZipCode" class="login_field"></div></div>

        <div class="register_row"><div class="register_label">Email Address:*</div><div class="register_field_align"><input type="text" name="EmailAddress" id="EmailAddress" class="login_field"></div></div>

        <div class="register_row"><div class="register_label">Password:*</div><div class="register_field_align"><input type="password" name="RegisterPassword" id="RegisterPassword" class="login_field"></div></div>

        <div class="register_row"><div class="register_label">Re-type Password:*</div><div class="register_field_align"><input type="password" name="RetypePassword" id="RetypePassword" class="login_field"></div></div>

        <div class="register_row"><div class="register_label">&nbsp;&nbsp;&nbsp;</div><div class="register_field_align"><input type="checkbox" name="Subscribe" id="Subscribe" value="1">&nbsp;&nbsp;Yes, I'd like to be notified of news, offers and events. </div></div>

		<input type="hidden" name="l4_action" value="register" />

        <div class="register_row"><div class="register_label">&nbsp;&nbsp;&nbsp;</div><div class="register_field_align"><input type="submit" name="signin" id="signin" value="Register" class="l4store_button">&nbsp;&nbsp;&nbsp;&nbsp;or <a href="<?php echo $accountpage; ?>" class="l4store_link">cancel</a></div></div>

    </form>

</div>