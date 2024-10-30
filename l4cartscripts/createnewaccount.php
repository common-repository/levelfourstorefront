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

require_once('../Connections/flashdb.php');

mysql_select_db($database_flashdb, $flashdb);

session_start();



// username and password sent from form

$newemail=$_POST['EmailNew'];

$newpassword=md5($_POST['PasswordNew']);

$newpassword2=md5($_POST['RetypePasswordNew']);



if($newpassword != $newpassword2){

	header("location:/cart/?login=failed&reason=passworderror");

}



$sqlcheck = sprintf("SELECT Email FROM clients WHERE Email='%s'", mysql_real_escape_string($newemail));

$resultcheck = mysql_query($sqlcheck);

if(mysql_num_rows($resultcheck) <= 0){

	$sql=sprintf("INSERT INTO clients(Email, Password, UserLevel) VALUES ('%s', '%s', '%s')", mysql_real_escape_string($newemail), mysql_real_escape_string($newpassword), mysql_real_escape_string("shopper"));

	$result=mysql_query($sql);

	

	$_SESSION['l4username'] = $newemail;

	$_SESSION['l4password'] = $newpassword;

	$_SESSION['l4userlevel'] = "shopper";

	

	header("location:/cart/?login=success");



}else{

	header("location:/cart/?login=failed&reason=emailerror");

}

?>