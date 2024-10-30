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

// username and password sent from form

$newemail=$_POST['EmailAddress'];

$newpassword=md5($_POST['RegisterPassword']);

$sqlcheck = sprintf("SELECT Email FROM clients WHERE Email='%s'", mysql_real_escape_string($newemail));

$resultcheck = mysql_query($sqlcheck);

$total_rows = mysql_num_rows($resultcheck);

$validate = new Validate;

if($total_rows == 0){

	if(!$validate->isFirstName($_POST['FirstName'])){

		header("location:".$accountpage.$permalinkdivider."signup=failed&reason=firstnameerror");

	}else if(!$validate->isLastName($_POST['LastName'])){

		header("location:".$accountpage.$permalinkdivider."signup=failed&reason=lastnameerror");

	}else if(!$validate->isZipCode($_POST['ZipCode'])){

		header("location:".$accountpage.$permalinkdivider."signup=failed&reason=zipcodeerror");

	}else if(!$validate->isEmail($_POST['EmailAddress'])){

		header("location:".$accountpage.$permalinkdivider."signup=failed&reason=emailerror");

	}else if(!$validate->isPassword($_POST['RegisterPassword'])){

		header("location:".$accountpage.$permalinkdivider."signup=failed&reason=passworderror");

	}else if(!$validate->isPassword($_POST['RetypePassword'])){

		header("location:".$accountpage.$permalinkdivider."signup=failed&reason=passworderror");

	}else if($_POST['RegisterPassword'] != $_POST['RetypePassword']){

		header("location:".$accountpage.$permalinkdivider."signup=failed&reason=passworderror");

	}

	

	$sql=sprintf("INSERT INTO clients(FirstName, LastName, BillZip, Email, Password, UserLevel, subscriber) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')", mysql_real_escape_string($_POST['FirstName']), mysql_real_escape_string($_POST['LastName']), mysql_real_escape_string($_POST['ZipCode']), mysql_real_escape_string($newemail), mysql_real_escape_string($newpassword), mysql_real_escape_string("shopper"), mysql_real_escape_string($_POST['Subscribe']));

	$result=mysql_query($sql);

	$_SESSION['l4username'] = $newemail;

	$_SESSION['l4password'] = $newpassword;

	$_SESSION['l4userlevel'] = "shopper";

	if($_POST['Subscribe']){

		$sql=sprintf("INSERT INTO subscribers(firstname, lastname, email) VALUES ('%s', '%s', '%s')", mysql_real_escape_string($_POST['FirstName']), mysql_real_escape_string($_POST['LastName']), mysql_real_escape_string($newemail));

		mysql_query($sql);

	}

	header("location:".$accountpage);

}else{

	header("location:".$accountpage.$permalinkdivider."signup=failed&reason=emailerror");

}

?>