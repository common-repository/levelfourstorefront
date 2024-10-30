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

//the following sends an itemized record of the shopping experience for each order.

// retrieve the clients name and email

$sql = sprintf("Select * from clients where Email='%s'", mysql_real_escape_string($_POST['EmailAddress']));

$result1 = mysql_query($sql);

$client = mysql_fetch_assoc($result1);	

$settingsquery= mysql_query("Select * from settings where settingID = '1'");

$settings = mysql_fetch_assoc($settingsquery);



if (mysql_num_rows($result1) > 0) {

	$randomnumber = (rand()%3000);

	$email = $client['Email'];

	$Password = md5("$client[LastName]$randomnumber");

	$password_reset_sql = sprintf("UPDATE clients SET Password='%s' WHERE clients.Email = '%s'", mysql_real_escape_string($Password), mysql_real_escape_string($email));

	mysql_query($password_reset_sql);

	$message = "<p>A request has been made for this email address to retrieve the password on file.  All of our passwords are encrypted and require a reset to be issued.  below is your new account information for this email address.</p><p>We suggest that you log into your account and change your password to something you will remember as it will ensure that your account information stays safe.<br />  </p><p>Email Address: $client[Email]<br />  Password: $client[LastName]$randomnumber<br />  </p><p>If you have trouble logging in, please visit our website and contact us through our contact page.</p><p>Thanks Again,</p><p><a href='https://$settings[siteURL]' target='_blank'>https://$settings[siteURL]</a></p>";

	//Build the email message with full itemized paging

	$Text = "This email is html, please switch to this view";
	
	$message = "--==MIME_BOUNDRY_alt_main_message\n";

	$message .= "Content-Type: text/plain; charset=utf-8\n";

	$message .= "Content-Transfer-Encoding: 7bit\n\n";

	$message .= $Text . "\n\n";

	$message .= "--==MIME_BOUNDRY_alt_main_message\n";

	$message .= "Content-Type: text/html; charset=utf-8\n";

	$message .= "Content-Transfer-Encoding: 7bit\n\n";

	$message .= "<html><head><title>Password Recovery</title><style type='text/css'><!--.style20 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }.style22 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }--></style></head><body><p>A request has been made for this email address to retrieve the password on file.  All of our passwords are encrypted and require a reset to be issued.  below is your new account information for this email address.</p><p>We suggest that you log into your account and change your password to something you will remember as it will ensure that your account information stays safe.<br />  </p><p>Email Address: $client[Email]<br />  Password: $client[LastName]$randomnumber<br />  </p><p>If you have trouble logging in, please visit our website and contact us through our contact page.</p><p>Thanks Again,</p><p><a href='https://$settings[siteURL]' target='_blank'>https://$settings[siteURL]</a></p></body></html>";

	$headers = "From: " . $settings['orderfromemail'] . "\r\n";

	$headers .= "Reply-To: " . $settings['orderfromemail'] . "\r\n";

	$headers .= "X-Mailer: PHP4\n";

	$headers .= "X-Priority: 3\n";

	$headers .= "MIME-Version: 1.0\n";

	$headers .= "Return-Path: " . $settings['orderfromemail'] . "\r\n"; 

	$headers .= "Content-Type: multipart/alternative; boundary=\"==MIME_BOUNDRY_alt_main_message\"\n\n";

	mail($client['Email'], "Password Recorvery", $message, $headers);
	
	header("location:".$accountpage.$permalinkdivider."password=reset");

}else{

	header("location:".$accountpage.$permalinkdivider."password=resetfailed");

}

?>