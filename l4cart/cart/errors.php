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

<?php 

if(isset($_GET['login']) && $_GET['login'] == "failed"){

	if(isset($_GET['reason']) && $_GET['reason'] == "emailerror"){?>

		<div class="loginfailed">The email you entered is already in use.</div>

<?php 

	}else{?>

		<div class="loginfailed">The user name and password you entered was incorrect.</div>

<?php 

	}

}?>

<?php 

if(isset($_GET['errorcode']) && $_GET['errorcode'] == "failed"){?>

	<div class="loginfailed">An error occurred while processing your credit card. Please re-enter your credit card information and try again.</div>

<?php 

}else if(isset($_GET['errorcode'])){?>

	<div class="loginfailed"><?php echo $L4ErrorCodes[$_GET['errorcode']]; ?></div>

<?php 

}?>