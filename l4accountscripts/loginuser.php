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

// username and password sent from form

$l4username=$_POST['SigninEmail'];

$l4password=md5($_POST['SigninPassword']);

// To protect MySQL injection (more detail about MySQL injection)

$l4username = stripslashes($l4username);

$l4password = stripslashes($l4password);

$l4username = mysql_real_escape_string($l4username);

$l4password = mysql_real_escape_string($l4password);



$sql = sprintf("SELECT UserLevel FROM clients WHERE Email='%s' and Password='%s'", $l4username, $l4password);

$result = mysql_query($sql);

$row = mysql_fetch_assoc($result);



// Mysql_num_row is counting table row

$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row



if($count==1){

	// Register $myusername, $mypassword and redirect to file "login_success.php"

	$_SESSION['l4username'] = $l4username;

	$_SESSION['l4password'] = $l4password;

	$_SESSION['l4userlevel'] = $row['UserLevel'];

	$_SESSION['currcouponcode'] = "";

	header("location:".$accountpage.$permalinkdivider."login=success");

}else{

	header("location:".$accountpage.$permalinkdivider."login=failed");

}

?>