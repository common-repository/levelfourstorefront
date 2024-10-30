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

if(!$validate->isFirstName($_POST['FirstName'])){

	header("location:".$accountpage.$permalinkdivider."reason=firstnameerror");

}else if(!$validate->isLastName($_POST['LastName'])){

	header("location:".$accountpage.$permalinkdivider."reason=lastnameerror");

}else if(!$validate->isZipCode($_POST['ZipCode'])){

	header("location:".$accountpage.$permalinkdivider."reason=zipcodeerror");

}else if(!$validate->isEmail($_POST['EmailAddress'])){

	header("location:".$accountpage.$permalinkdivider."reason=emailerror");

}



if(userloggedin()){

	$sql = sprintf("UPDATE clients SET FirstName = '%s', LastName = '%s', BillZip = '%s', Email = '%s' WHERE clients.Email = '%s' AND clients.Password = '%s'", mysql_real_escape_string($_POST['FirstName']), mysql_real_escape_string($_POST['LastName']), mysql_real_escape_string($_POST['ZipCode']), mysql_real_escape_string($_POST['EmailAddress']), mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']));

	$result=mysql_query($sql);

	$_SESSION['l4username'] = $_POST['EmailAddress'];

}

header("location:".$accountpage);

?>