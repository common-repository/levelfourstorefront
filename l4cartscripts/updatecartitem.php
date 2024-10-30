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

$getproduct_sql = sprintf("SELECT * FROM tempcart WHERE tempcartid = '%s'", mysql_real_escape_string($_POST['tempcartid']));
$getproduct_result = mysql_query($getproduct_sql);
$getproduct_row = mysql_fetch_assoc($getproduct_result);

$getproductquantity_sql = sprintf("SELECT Quantity FROM optionitemquantity WHERE ProductID = '%s' AND OptionItemID1 = '%s' AND OptionItemID2 = '%s' AND OptionItemID3 = '%s' AND OptionItemID4 = '%s' AND OptionItemID5 = '%s'", mysql_real_escape_string($getproduct_row['productid']), mysql_real_escape_string($getproduct_row['orderoption1']), mysql_real_escape_string($getproduct_row['orderoption2']), mysql_real_escape_string($getproduct_row['orderoption3']), mysql_real_escape_string($getproduct_row['orderoption4']), mysql_real_escape_string($getproduct_row['orderoption5']));
$getproductquantity_result = mysql_query($getproductquantity_sql);
$getproductquantity_row = mysql_fetch_assoc($getproductquantity_result);

$sqlproduct = sprintf("SELECT * FROM products WHERE ProductID = '%s'", mysql_real_escape_string($getproduct_row['productid']));
$resultproduct = mysql_query($sqlproduct);
$productadd = mysql_fetch_assoc($resultproduct);

$newquantity = $_POST['Quantity'];
$amountavailable = $getproductquantity_row['Quantity'];

if($productadd['useQuantityTracking'] == "1" && ($newquantity > $amountavailable)){
	
	if(isset($_POST['confirmorder']) && $_POST['confirmorder'] == "true"){
				
		header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=28");
	
	}else{
	
		header("location:".$cartpage . $permalinkdivider."errorcode=28");
	
	}
		
}else{

	//query the database for our settings
	
	$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";
	
	$settingsRS = mysql_query($query_settingsRS);
	
	$row_settingsRS = mysql_fetch_assoc($settingsRS);

	$temprowsql = sprintf("SELECT productid, stockquantity FROM tempcart WHERE sessionid = '%s' AND tempcartid = '%s'", mysql_real_escape_string(session_id()), mysql_real_escape_string($_POST['tempcartid']));
	
	$temprowresult = mysql_query($temprowsql);
	
	$temprownumrows = mysql_num_rows($temprowresult);
	
	if($temprownumrows > 0){
	
		$temprowrow = mysql_fetch_assoc($temprowresult);
	
		$productid = $temprowrow['productid'];
	
		$stockquantity = $temprowrow['stockquantity'];
	
		$quantitysql = sprintf("SELECT SUM(tempcart.quantity) as TotalInCart FROM tempcart WHERE tempcart.productid = '%s' AND sessionid = '%s' AND tempcartid != '%s'", mysql_real_escape_string($productid), mysql_real_escape_string(session_id()), mysql_real_escape_string($_POST['tempcartid']));
	
		$quantityresult = mysql_query($quantitysql);
	
		$quantityrow = mysql_fetch_assoc($quantityresult);
	
		if($row_settingsRS['quantitytracking'] == 1 && ($_POST['Quantity'] + $quantityrow['TotalInCart']) > $stockquantity){
	
						
			if(isset($_POST['confirmorder']) && $_POST['confirmorder'] == "true"){
				
				header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=28");
			
			}else{
			
				header("location:".$cartpage . $permalinkdivider."errorcode=28");
			
			}
	
		}else{
	
			$sql = sprintf("UPDATE tempcart SET quantity = '%s' WHERE sessionid = '%s' AND tempcartid = '%s'", mysql_real_escape_string($_POST['Quantity']), mysql_real_escape_string(session_id()), mysql_real_escape_string($_POST['tempcartid']));
	
			$result=mysql_query($sql);
	
			if(isset($_POST['jquery_version'])){
	
				echo "success";
	
			}else{
			
				if(isset($_POST['confirmorder']) && $_POST['confirmorder'] == "true"){
				
					header("location:" . $cartpage . $permalinkdivider . "confirmorder=true");
				
				}else{
				
					header("location:".$cartpage);
				
				}
	
			}
	
		}
	
	}else{
	
		if(isset($_POST['confirmorder']) && $_POST['confirmorder'] == "true"){
			
			header("location:".$cartpage.$permalinkdivider."confirmorder=true&errorcode=29");
		
		}else{
		
			header("location:".$cartpage . $permalinkdivider."errorcode=29");
		
		}
	
	}
	
}

?>