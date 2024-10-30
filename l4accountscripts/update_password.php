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

require_once( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/scripts/l4html/validation.php");

$validate = new Validate;

if(!$validate->isPassword($_POST['CurrentPassword'])){

	header("location:".$accountpage.$permalinkdivider."reason=currentpassworderror");

}else if(!$validate->isPassword($_POST['NewPassword'])){

	header("location:".$accountpage.$permalinkdivider."reason=newpassworderror");

}else if(!$validate->isPassword($_POST['RetypePassword'])){

	header("location:".$accountpage.$permalinkdivider."reason=retypepassworderror");

}else if($_POST['NewPassword'] != $_POST['RetypePassword']){

	header("location:".$accountpage.$permalinkdivider."reason=passwordsdonotmatcherror");

}



if(userloggedin()){

	if(md5($_POST['CurrentPassword']) == $_SESSION['l4password']){

		$sql = sprintf("UPDATE clients SET Password = '%s' WHERE clients.Email = '%s' AND clients.Password = '%s' AND clients.Password = '%s'", mysql_real_escape_string(md5($_POST['NewPassword'])), mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']), mysql_real_escape_string(md5($_POST['CurrentPassword'])));

		$result = mysql_query($sql);

		$sql2 = sprintf("SELECT clients.Email FROM clients WHERE Email = '%s' AND Password = '%s'", mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string(md5($_POST['NewPassword'])));

		$result = mysql_query($sql2);

		$numrows = mysql_num_rows($result);

		if($numrows != 0){

			$_SESSION['l4password'] = md5($_POST['NewPassword']);
			
			header("location:".$accountpage);

		}else{

			header("location:".$accountpage.$permalinkdivider."reason=updateerror");

		}

	}else{
		
		header("location:".$accountpage);
		
	}

}else{

	header("location:".$accountpage);

}

?>