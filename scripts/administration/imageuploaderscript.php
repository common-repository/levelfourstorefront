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

$settings_sql = "SELECT xsmall_width, xsmall_height, small_width, small_height, medium_width, medium_height, large_width, large_height, max_width, max_height FROM settings";

$settings_result = mysql_query($settings_sql);

$settings_row = mysql_fetch_assoc($settings_result);

//Flash Variables

$date = $_POST['datemd5'];

$requestID = $_POST['reqID'];

$imagenumber = $_POST['imagenumber'];

$insertupdate = $_POST['insertupdate'];

$productid = $_POST['productid'];

$optionitemid = $_POST['optionitemid'];

$useoptionitemimages = $_POST['useoptionitemimages'];


$xsmallwidth = $settings_row['xsmall_width'];

$xsmallheight = $settings_row['xsmall_height'];

$smallwidth = $settings_row['small_width'];

$smallheight = $settings_row['small_height'];

$mediumwidth = $settings_row['medium_width'];

$mediumheight = $settings_row['medium_height'];

$largewidth = $settings_row['large_width'];

$largeheight = $settings_row['large_height'];

$maxwidth = $settings_row['max_width'];

$maxheight = $settings_row['max_height'];

$imagequality = $_POST['imagequality'];//set this between 0 and $imagequality  for .jpg quality resizing

//If using option item quantity tracking, we need to insert a row for images with productid/optionitemid combo if no in already.

if($useoptionitemimages){

	$sql = sprintf("SELECT COUNT(optionitemimagesID) as numrows FROM optionitemimages WHERE optionitemID = '%s' AND productID = '%s'", mysql_real_escape_string($optionitemid), mysql_real_escape_string($productid));
	
	$result = mysql_query($sql);
	
	$row = mysql_fetch_assoc($result);
	
	$numresults = $row['numrows'];
	
	if($numresults == 0){
		
		$sql = sprintf("INSERT INTO optionitemimages(optionitemID, productID) VALUES('%s', '%s')", mysql_real_escape_string($optionitemid), mysql_real_escape_string($productid));
		
		mysql_query($sql);
			
	}

}

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

	if ($imagenumber == '1') {

		// Place file on server, into the images folder

		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../products/pics1/".$nameoffile."_".$date.".".$fileextension);

		//resize original max image

		$resizeObj = new resizer("../../products/pics1/".$nameoffile."_".$date.".".$fileextension);

		$resizeObj -> resize($maxwidth, $maxheight, "../../products/pics1/".$nameoffile."_".$date.".".$fileextension, $imagequality );

		
		//if we are updating, then update the db field, inserting happens later

		if($useoptionitemimages){
	
			$sql = "UPDATE optionitemimages SET Image1 = '".$nameoffile."_".$date.".".$fileextension."' WHERE productID = '".$productid."' AND optionitemID = '".$optionitemid."'";
			
			mysql_query($sql);

		}else{
			
			if ($insertupdate == 'update') {
				
				$sql = "Update products SET Image1 = '".$nameoffile."_".$date.".".$fileextension."' WHERE products.ProductID = ".$productid;
				
				mysql_query($sql);

			}

		}

	}

	

	if ($imagenumber == '2') {

		// Place file on server, into the images folder

		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../products/pics2/".$nameoffile."_".$date.".".$fileextension);

		//resize original max image

		$resizeObj = new resizer("../../products/pics2/".$nameoffile."_".$date.".".$fileextension);

		$resizeObj -> resize($maxwidth, $maxheight, "../../products/pics2/".$nameoffile."_".$date.".".$fileextension, $imagequality );


		if($useoptionitemimages){
	
			$sql = "UPDATE optionitemimages SET Image2 = '".$nameoffile."_".$date.".".$fileextension."' WHERE productID = '".$productid."' AND optionitemID = '".$optionitemid."'";
			
			mysql_query($sql);

		}else{
			
			if ($insertupdate == 'update') {
				
				$sql = "Update products SET Image2 = '".$nameoffile."_".$date.".".$fileextension."' WHERE products.ProductID = ".$productid;
				
				mysql_query($sql);

			}
			
		}

	}

	if ($imagenumber == '3') {

		// Place file on server, into the images folder

		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../products/pics3/".$nameoffile."_".$date.".".$fileextension);

		//resize original max image

		$resizeObj = new resizer("../../products/pics3/".$nameoffile."_".$date.".".$fileextension);

		$resizeObj -> resize($maxwidth, $maxheight, "../../products/pics3/".$nameoffile."_".$date.".".$fileextension, $imagequality );
		

		if($useoptionitemimages){
	
			$sql = "UPDATE optionitemimages SET Image3 = '".$nameoffile."_".$date.".".$fileextension."' WHERE productID = '".$productid."' AND optionitemID = '".$optionitemid."'";
			
			mysql_query($sql);
	
		}else{
		
			if ($insertupdate == 'update') {
				
				$sql = "Update products SET Image3 = '".$nameoffile."_".$date.".".$fileextension."' WHERE products.ProductID = ".$productid;
				
				mysql_query($sql);

			}

		}

	}

	if ($imagenumber == '4') {

		// Place file on server, into the images folder

		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../products/pics4/".$nameoffile."_".$date.".".$fileextension);

		//resize original max image

		$resizeObj = new resizer("../../products/pics4/".$nameoffile."_".$date.".".$fileextension);

		$resizeObj -> resize($maxwidth, $maxheight, "../../products/pics4/".$nameoffile."_".$date.".".$fileextension, $imagequality );


		if($useoptionitemimages){
	
			$sql = "UPDATE optionitemimages SET Image4 = '".$nameoffile."_".$date.".".$fileextension."' WHERE productID = '".$productid."' AND optionitemID = '".$optionitemid."'";
			
			mysql_query($sql);
	
		}else{

			if ($insertupdate == 'update') {

				$sql = "Update products SET Image4 = '".$nameoffile."_".$date.".".$fileextension."' WHERE products.ProductID = ".$productid;
				
				mysql_query($sql);

			}

		}

	}

	if ($imagenumber == '5') {

		// Place file on server, into the images folder

		move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../products/pics5/".$nameoffile."_".$date.".".$fileextension);

		//resize original max image

		$resizeObj = new resizer("../../products/pics5/".$nameoffile."_".$date.".".$fileextension);

		$resizeObj -> resize($maxwidth, $maxheight, "../../products/pics5/".$nameoffile."_".$date.".".$fileextension, $imagequality );
		

		if($useoptionitemimages){
	
			$sql = "UPDATE optionitemimages SET Image5 = '".$nameoffile."_".$date.".".$fileextension."' WHERE productID = '".$productid."' AND optionitemID = '".$optionitemid."'";
			
			mysql_query($sql);

		}else{
		
			if ($insertupdate == 'update') {

				$sql = "Update products SET Image5 = '".$nameoffile."_".$date.".".$fileextension."' WHERE products.ProductID = ".$productid;
				
				mysql_query($sql);

			}

		}

	}

}

?>