<?php

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//All Code and Design is copyrighted by Level Four Storefront, LLC

//Level Four Storefront, LLC provides this code "as is" without     

//warranty of any kind, either express or implied,       

//including but not limited to the implied warranties    

//of merchantability and/or fitness for a particular     

//purpose.         

//

//Only licnesed users may use this code and storfront for live purposes.

//All other use is prohibited and may be subject to copyright violation laws.

//If you have any questions regarding proper use of this code, please

//contact Level Four Storefront, LLC prior to use.

//

//All use of this storefront is subject to our terms of agreement found on

// Level Four Storefront, LLC's official website.

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//Version 8.1.0 -  2011

require_once('../../Connections/flashdb.php'); 
$requestID = $_POST['reqID'];

$usersqlquery = sprintf("SELECT * FROM clients WHERE clients.Password = '%s' AND clients.UserLevel = 'admin' ORDER BY Email ASC", mysql_real_escape_string($requestID));
mysql_select_db($database_flashdb, $flashdb);
$userresult = mysql_query($usersqlquery, $flashdb) or die(mysql_error());
$users = mysql_fetch_assoc($userresult);

if ($users) {
	//Flash File Data
	$filename = $_FILES['Filedata']['name'];

	//delete file if exists.
	if (file_exists("../../products/".$filename)) { unlink ("../../products/".$filename); }

	// Place file on server, into the products folder
	move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../products/".$filename);

}

?>