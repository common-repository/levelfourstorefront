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


if(userloggedin()){

	$accountinfosql=sprintf("SELECT * FROM clients WHERE Email='%s' and Password='%s'", mysql_real_escape_string($_SESSION['hpusername']), mysql_real_escape_string($_SESSION['hppassword']));

	$accountinforesult=mysql_query($accountinfosql);

	$accountinforow = mysql_fetch_assoc($accountinforesult);

	$accountinfototalrows=mysql_num_rows($accountinforesult);

	

	$countriessql="SELECT * FROM countries ORDER BY countries.name_cnt";

	$countriesresult=mysql_query($countriessql);

	$countriesresult2=mysql_query($countriessql);

}

?>

<script type="text/javascript">

function check_password_form(f){

	var errors = 0;

	if(document.getElementById('CurrentPassword').value.length == 0){

		document.getElementById('CurrentPassword').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('CurrentPassword').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('NewPassword').value.length < 6){

		document.getElementById('NewPassword').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('NewPassword').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('RetypePassword').value.length < 6){

		document.getElementById('RetypePassword').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('RetypePassword').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('NewPassword').value != document.getElementById('RetypePassword').value && document.getElementById('NewPassword').value.length != 0 && document.getElementById('RetypePassword').value.length != 0){

		document.getElementById('NewPassword').style.border = "solid 1px #CC0000";

		document.getElementById('RetypePassword').style.border = "solid 1px #CC0000";

		errors++;

	}else if(document.getElementById('NewPassword').value.length != 0 && document.getElementById('RetypePassword').value.length != 0){

		document.getElementById('NewPassword').style.border = "solid 1px #666666";

		document.getElementById('RetypePassword').style.border = "solid 1px #666666";

	}

	

	

	if(errors == 0){	

		f.submit();

		document.getElementById('errortext2').style.display = "none";
		
		return false;

	}else{

		document.getElementById('errortext2').style.display = "block";
		
		return false;

	}

}

</script>

<div class="dashboard_header_full">

	<div id="errortext2" class="errortext_full">Please make corrections to the highlighted fields.</div>

    <div class="l4store_title">Edit Your Password</div>

    <div class="dashboard_head_content">Please note: Once you change your password you will be required to use the new password each time you log into our site.</div>

</div>

    

<div class="dashboard_full">

	<div class="register_content_small">*Required Information</div>

    <form id="registerForm" name="registerForm" method="post" action="<?php echo $accountpage; ?>" onsubmit="return check_password_form(this); return false;">

            <div class="register_row"><div class="register_label">*Your Password: </div><div class="register_field_align"><input type="password" name="CurrentPassword" id="CurrentPassword" class="login_field"></div></div>

            <div class="register_row"><div class="register_label">*New Password: </div><div class="register_field_align"><input type="password" name="NewPassword" id="NewPassword" class="login_field"></div></div>

            <div class="register_row"><div class="register_label">*Retype Password: </div><div class="register_field_align"><input type="password" name="RetypePassword" id="RetypePassword" class="login_field"></div></div>
			
			<input type="hidden" name="l4_action" value="editpassword" />

           <div class="register_label">&nbsp;&nbsp;</div><div class="register_field_align"><input type="submit" name="updateinfo" id="updateinfo" value="Update" onclick="checkform(); return false;" class="l4store_button">&nbsp;&nbsp;&nbsp;&nbsp;or <a href="<?php echo $accountpage; ?>" class="l4store_link">cancel</a></div>

        </form>

</div>