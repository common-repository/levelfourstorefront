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



//Flash Variables

$requestID = $_POST['reqID'];

$imagenumber = $_POST['imagenumber'];



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

	//if this is a header image, put it with the right name here
	if ($imagenumber == '1') {

		// Place file on server, into the images folder

		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../images/emaillogo.jpg");

		return 'moved 1';

	}

	//if this is a footer image, put it with the right name here
	else if ($imagenumber == '2') {

		// Place file on server, into the images folder

		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../images/emailfooter.jpg");
		
		return 'moved 2';

	}
	
	else {
		
		return 'upgrade needed';
	}


}

?>