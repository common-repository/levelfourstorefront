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

mysql_select_db($database_flashdb, $flashdb);

$settings_sql = "SELECT max_width, max_height FROM settings";

$settings_result = mysql_query($settings_sql);

$settings_row = mysql_fetch_assoc($settings_result);

//Flash Variables

$date = $_POST['datemd5'];

$requestID = $_POST['reqID'];

$optionitemid = $_POST['optionitemid'];

$maxwidth = $settings_row['max_width'];

$maxheight = $settings_row['max_height'];

$imagequality = $_POST['imagequality'];//set this between 0 and $imagequality  for .jpg quality resizing


//Get User Information


$usersqlquery = sprintf("select * from clients WHERE clients.Password = '%s' AND clients.UserLevel = 'admin' ORDER BY Email ASC", mysql_real_escape_string($requestID));

$userresult = mysql_query($usersqlquery);

$users = mysql_fetch_assoc($userresult);


if ($users) {

	//Flash File Data

	$filename = $_FILES['Filedata']['name'];	

	$filetmpname = $_FILES['Filedata']['tmp_name'];	

	$fileType = $_FILES["Filedata"]["type"];

	$fileSizeMB = ($_FILES["Filedata"]["size"] / 1024 / 1000);

	$explodedfilename = explode(".", $filename);

	$nameoffile = $explodedfilename[0];

	$fileextension = $explodedfilename[1];

	

	include("resizer.php");


	// Place file on server, into the images folder

	move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../products/swatches/".$nameoffile."_".$date.".".$fileextension);

	//resize original max image

	$resizeObj = new resizer("../../products/swatches/".$nameoffile."_".$date.".".$fileextension);

	$resizeObj -> resize($maxwidth, $maxheight, "../../products/swatches/".$nameoffile."_".$date.".".$fileextension, $imagequality );

	
	//if we are updating, then update the db field, inserting happens later

	//Create SQL Query
		
	$sql = "Update optionitems SET optionitemicon = '".$nameoffile."_".$date.".".$fileextension."' WHERE optionitems.optionitemID = ".$optionitemid;

	//Run query on database;

	mysql_query($sql);

}

?>