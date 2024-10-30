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

if( ( isset($_POST['option1']) && $_POST['option1'] == "false" ) || ( isset($_POST['option2']) && $_POST['option2'] == "false" ) || ( isset($_POST['option3']) && $_POST['option3'] == "false" ) || ( isset($_POST['option4']) && $_POST['option4'] == "false" ) || ( isset($_POST['option5']) && $_POST['option5'] == "false" ) ){

	header("location:" .  $_SERVER["HTTP_REFERER"] . "&Error=27");	

}else{
	
	$sqlproduct = sprintf("SELECT * FROM products WHERE ProductID = '%s'", mysql_real_escape_string($_POST['ProductID']));
	
	$resultproduct = mysql_query($sqlproduct);
	
	$productadd = mysql_fetch_assoc($resultproduct);
	
	if($productadd['isDonation']){
		$Price = $_POST['Price'];
	}else{
		$Price = $productadd['Price'];
	}

	$getproduct_sql = sprintf("SELECT quantity FROM tempcart WHERE productid = '%s' AND orderoption1 = '%s' AND orderoption2 = '%s' AND orderoption3 = '%s' AND orderoption4 = '%s' AND orderoption5 = '%s' AND sessionid = '%s'", mysql_real_escape_string($_POST['ProductID']), mysql_real_escape_string($_POST['option1']), mysql_real_escape_string($_POST['option2']), mysql_real_escape_string($_POST['option3']), mysql_real_escape_string($_POST['option4']), mysql_real_escape_string($_POST['option5']), mysql_real_escape_string(session_id()));
	$getproduct_result = mysql_query($getproduct_sql);
	
	$currentlyincart = 0;
	if(mysql_num_rows($getproduct_result)){
		$getproduct_row = mysql_fetch_assoc($getproduct_result);
		$currentlyincart = $getproduct_row['quantity'];
	}
	
	$getproductquantity_sql = sprintf("SELECT Quantity FROM optionitemquantity WHERE ProductID = '%s' AND OptionItemID1 = '%s' AND OptionItemID2 = '%s' AND OptionItemID3 = '%s' AND OptionItemID4 = '%s' AND OptionItemID5 = '%s'", mysql_real_escape_string($_POST['ProductID']), mysql_real_escape_string($_POST['option1']), mysql_real_escape_string($_POST['option2']), mysql_real_escape_string($_POST['option3']), mysql_real_escape_string($_POST['option4']), mysql_real_escape_string($_POST['option5']));
	$getproductquantity_result = mysql_query($getproductquantity_sql);
	
	$amountavailable = 0;
	if(mysql_num_rows($getproductquantity_result) > 0){
		$getproductquantity_row = mysql_fetch_assoc($getproductquantity_result);
		$amountavailable = $getproductquantity_row['Quantity'];
	}
	
	$addquantity = $_POST['Quantity'];
	
	if($productadd['useQuantityTracking'] == "1" && (($addquantity + $currentlyincart) > $amountavailable)){
			
		header("location:" .  $_SERVER["HTTP_REFERER"] . "&Error=26&message=Too many in your cart.");
			
	}else{

		if($productadd['isDonation'] && $_POST['Price'] < $productadd['Price']){
			
			//Donation Too Low
			header("location:" .  $_SERVER["HTTP_REFERER"] . "&Error=30");	
		
		}else{

			//search for any existing products with same session and product ID
		
			$sqlcheck = sprintf("SELECT * FROM tempcart WHERE sessionid = '%s' AND productid = '%s'", mysql_real_escape_string(session_id()), mysql_real_escape_string($_POST['ProductID']));
		
			$resultcheck = mysql_query($sqlcheck);
		
			$totalfound = mysql_num_rows($resultcheck); 
		
			//query the database for our settings
		
			$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";
		
			$settingsRS = mysql_query($query_settingsRS);
		
			$row_settingsRS = mysql_fetch_assoc($settingsRS);
		
			//Get product information from the database
		
			$sqlproduct = sprintf("SELECT * FROM products WHERE ProductID = '%s'", mysql_real_escape_string($_POST['ProductID']));
		
			$resultproduct = mysql_query($sqlproduct);
		
			$numproducts = mysql_num_rows($resultproduct);
		
			if($numproducts > 0){
		
				$productadd = mysql_fetch_assoc($resultproduct);
		
				if($row_settingsRS['quantitytracking'] == 1 && $productadd['quantity'] < $_POST['Quantity']){
		
					header("location:" .  $_SERVER["HTTP_REFERER"] . "&Error=28");
		
				}else{
		
					$optionprice = 0;
		
					//Get option information from the database
		
					$option1sql = sprintf("SELECT * FROM optionitems WHERE optionitemID = '%s'", mysql_real_escape_string($_POST['option1']));
		
					$option1result = mysql_query($option1sql);
		
					$numoption1 = mysql_num_rows($option1result);
		
					if($numoption1 > 0){
		
						$option1set = mysql_fetch_assoc($option1result);
		
						$option1name = $option1set['optionitemname'];
		
						$optionprice = $optionprice + $option1set['optionitemprice'];
		
					} else {
		
						$option1name = "";	
		
					}
		
					//Get option information from the database
		
					$option2sql = sprintf("SELECT * FROM optionitems WHERE optionitemID = '%s'", mysql_real_escape_string($_POST['option2']));
		
					$option2result = mysql_query($option2sql);
		
					$numoption2 = mysql_num_rows($option2result);
		
					if($numoption2 > 0){
		
						$option2set = mysql_fetch_assoc($option2result);
		
						$option2name = $option2set['optionitemname'];
		
						$optionprice = $optionprice + $option2set['optionitemprice'];
		
					} else {
		
						$option2name = "";	
		
					}
		
					//Get option information from the database
		
					$option3sql = sprintf("SELECT * FROM optionitems WHERE optionitemID = '%s'", mysql_real_escape_string($_POST['option3']));
		
					$option3result = mysql_query($option3sql);
		
					$numoption3 = mysql_num_rows($option3result);
		
					if($numoption3 > 0){
		
						$option3set = mysql_fetch_assoc($option3result);
		
						$option3name = $option3set['optionitemname'];
		
						$optionprice = $optionprice + $option3set['optionitemprice'];
		
					} else {
		
						$option3name = "";	
		
					}
		
					//Get option information from the database
		
					$option4sql = sprintf("SELECT * FROM optionitems WHERE optionitemID = '%s'", mysql_real_escape_string($_POST['option4']));
		
					$option4result = mysql_query($option4sql);
		
					$numoption4 = mysql_num_rows($option4result);
		
					if($numoption4 > 0){
		
						$option4set = mysql_fetch_assoc($option4result);
		
						$option4name = $option4set['optionitemname'];
		
						$optionprice = $optionprice + $option4set['optionitemprice'];
		
					} else {
		
						$option4name = "";	
		
					}
		
					//Get option information from the database
		
					$option5sql = sprintf("SELECT * FROM optionitems WHERE optionitemID = '%s'", mysql_real_escape_string($_POST['option5']));
		
					$option5result = mysql_query($option5sql);
		
					$numoption5 = mysql_num_rows($option5result);
		
					if($numoption5 > 0){
		
						$option5set = mysql_fetch_assoc($option5result);
		
						$option5name = $option5set['optionitemname'];
		
						$optionprice = $optionprice + $option5set['optionitemprice'];
		
					} else {
		
						$option5name = "";	
		
					}
					
					if($productadd['isGiftCard'] == "1"){
		
						for($i=0; $i<$_POST['Quantity']; $i++){
		
							//this is a new item, so let's go ahead and add it
		
							$sql = sprintf("Insert into tempcart(sessionid, productid, quantity, orderoption1, orderoption2, orderoption3, orderoption4,  orderoption5, option1name, option2name, option3name, option4name, option5name, image1, orderprice, isgiftcard, ordertitle, orderdescription,  ordermodelnumber,  message, fromname, toname, deliverymethod, istaxable, isdownload, downloadid, stockquantity, weight, manufacturer) values('".mysql_real_escape_string(session_id())."', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' , '%s',  '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
		
							mysql_real_escape_string($_POST['ProductID']),
		
							mysql_real_escape_string(1),
		
							mysql_real_escape_string($_POST['option1']),
		
							mysql_real_escape_string($_POST['option2']),
		
							mysql_real_escape_string($_POST['option3']),
		
							mysql_real_escape_string($_POST['option4']),
		
							mysql_real_escape_string($_POST['option5']),
		
							mysql_real_escape_string($option1name),
		
							mysql_real_escape_string($option2name),
		
							mysql_real_escape_string($option3name),
		
							mysql_real_escape_string($option4name),
		
							mysql_real_escape_string($option5name),
		
							mysql_real_escape_string($productadd['Image1']),
		
							mysql_real_escape_string($Price + $optionprice),
		
							mysql_real_escape_string($productadd['isGiftCard']),
		
							mysql_real_escape_string($productadd['Title']),	
		
							mysql_real_escape_string($productadd['Description']),
		
							mysql_real_escape_string($productadd['ModelNumber']),
		
							mysql_real_escape_string($_POST['textmessage']),
		
							mysql_real_escape_string($_POST['fromname']),
		
							mysql_real_escape_string($_POST['toname']),
		
							mysql_real_escape_string($_POST['deliverymethod']),
		
							mysql_real_escape_string($productadd['isTaxable']),
		
							mysql_real_escape_string($productadd['isDownload']),
		
							mysql_real_escape_string($productadd['downloadID']),
		
							mysql_real_escape_string($productadd['quantity']),
		
							mysql_real_escape_string($productadd['Weight']),
		
							mysql_real_escape_string($productadd['manufacturer']));	
		
							//finished building the SQL, go ahead and make the call
		
							$result=mysql_query($sql);
		
						}
		
						//Finished adding all new giftcards and downloads
						//GOOD WORK!
		
					}else if($numproducts < 1){
		
						header("location:" .  $_SERVER["HTTP_REFERER"] . "&Error=26&message=An unknown error has occurred.");
		
					}else{
		
						///////////////////////////////////////////////////////////////////////////////////
						//nothing in the temp cart, this is a new product
						///////////////////////////////////////////////////////////////////////////////////
		
						if($totalfound == 0) { 
						
							//this is a new item, so let's go ahead and add it
		
							$sql = sprintf("Insert into tempcart(sessionid, productid, quantity, orderoption1, orderoption2, orderoption3, orderoption4,  orderoption5,  option1name, option2name, option3name, option4name, option5name, image1, orderprice, isgiftcard, ordertitle, orderdescription,  ordermodelnumber,  message, fromname, toname, deliverymethod, istaxable, isdownload, downloadid, stockquantity, weight, manufacturer) values('".mysql_real_escape_string(session_id())."', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' , '%s',  '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
		
							mysql_real_escape_string($_POST['ProductID']),
		
							mysql_real_escape_string($_POST['Quantity']),
		
							mysql_real_escape_string($_POST['option1']),
		
							mysql_real_escape_string($_POST['option2']),
		
							mysql_real_escape_string($_POST['option3']),
		
							mysql_real_escape_string($_POST['option4']),
		
							mysql_real_escape_string($_POST['option5']),
		
							mysql_real_escape_string($option1name),
		
							mysql_real_escape_string($option2name),
		
							mysql_real_escape_string($option3name),
		
							mysql_real_escape_string($option4name),
		
							mysql_real_escape_string($option5name),
		
							mysql_real_escape_string($productadd['Image1']),
		
							mysql_real_escape_string($Price + $optionprice),
		
							mysql_real_escape_string($productadd['isGiftCard']),
		
							mysql_real_escape_string($productadd['Title']),	
		
							mysql_real_escape_string($productadd['Description']),
		
							mysql_real_escape_string($productadd['ModelNumber']),
		
							mysql_real_escape_string($_POST['textmessage']),
		
							mysql_real_escape_string($_POST['fromname']),
		
							mysql_real_escape_string($_POST['toname']),
		
							mysql_real_escape_string($_POST['deliverymethod']),
		
							mysql_real_escape_string($productadd['isTaxable']),
		
							mysql_real_escape_string($productadd['isDownload']),
		
							mysql_real_escape_string($productadd['downloadID']),
		
							mysql_real_escape_string($productadd['quantity']),
		
							mysql_real_escape_string($productadd['Weight']),
		
							mysql_real_escape_string($productadd['manufacturer']));	
		
							//finished building the SQL, go ahead and make the call
		
							$result=mysql_query($sql);
		
							//if we get a good result
		
							if($result){
		
								header("location:".$cartpage.$permalinkdivider."addtocart=true&ModelNumber=".$productadd['ModelNumber']);
		
							}else{
		
								header("location:".$cartpage.$permalinkdivider."addtocart=true&ModelNumber=".$productadd['ModelNumber']);
		
							}
		
						}else{
		
								///////////////////////////////////////////////////////////////////////////////////////////
								// we found a match for the product ID, so test it against similar options, gift 
								// cards, downloads, etc.
								///////////////////////////////////////////////////////////////////////////////////////////
								//  loop through to see if you can find an existing REGULAR product with MATCHING OPTIONS, 
								// then add to the quantity, EXCEPT if they are DOWNLOAD or GIFTCARD
								///////////////////////////////////////////////////////////////////////////////////////////
		
								$quantitysql = sprintf("SELECT SUM(tempcart.quantity) as TotalInCart FROM tempcart WHERE tempcart.productid = '%s' AND tempcart.sessionid = '%s'", mysql_real_escape_string($_POST['ProductID']), mysql_real_escape_string(session_id()));
		
								$quantityresult = mysql_query($quantitysql);
		
								$quantityrow = mysql_fetch_assoc($quantityresult);
		
								if($row_settingsRS['quantitytracking'] == 1 && ($_POST['Quantity'] + $quantityrow['TotalInCart']) > $productadd['quantity']){
		
									header("location:" .  $_SERVER["HTTP_REFERER"] . "&Error=28");	
		
								}else{
		
									$matchfound = false;
		
									while ($cartitem = mysql_fetch_assoc($resultcheck)) {	
		
										if ($cartitem['productid'] == $_POST['ProductID'] && $cartitem['isdownload'] != "1" && $cartitem['isgiftcard'] != "1" && $cartitem['orderoption1'] == $_POST['option1'] && $cartitem['orderoption2'] == $_POST['option2'] && $cartitem['orderoption3'] == $_POST['option3']&& $cartitem['orderoption4'] == $_POST['option4'] && $cartitem['orderoption5'] == $_POST['option5']) {
		
											if ($matchfound == false) {
		
												$matchfound = true;
		
												if($row_settingsRS['quantitytracking'] == 1 && ($_POST['Quantity'] + $cartitem['quantity']) > $productadd['quantity']){
		
													header("location:" .  $_SERVER["HTTP_REFERER"] . "&Error=28");	
		
												}else{
		
													//this is an update, so update the tempcart
		
													if($productadd['isDonation']){
													
														$sql = sprintf("UPDATE tempcart SET orderprice = orderprice + ".$Price." WHERE sessionid = '".mysql_real_escape_string(session_id())."' and productid = '%s' and orderoption1 = '%s' and orderoption2 = '%s' and orderoption3 = '%s' and orderoption4 = '%s' and orderoption5 = '%s' and option1name = '%s' and option2name = '%s' and option3name = '%s' and option4name = '%s' and option5name = '%s'", 
		
														mysql_real_escape_string($_POST['ProductID']),
			
														mysql_real_escape_string($_POST['option1']),
			
														mysql_real_escape_string($_POST['option2']),
			
														mysql_real_escape_string($_POST['option3']),
			
														mysql_real_escape_string($_POST['option4']),
			
														mysql_real_escape_string($_POST['option5']),
			
														mysql_real_escape_string($option1name),
			
														mysql_real_escape_string($option2name),
			
														mysql_real_escape_string($option3name),
			
														mysql_real_escape_string($option4name),
			
														mysql_real_escape_string($option5name));
														
													}else{
														
														$sql = sprintf("UPDATE tempcart SET quantity = '".$_POST['Quantity']."' + '".$cartitem['quantity']."' WHERE sessionid = '".mysql_real_escape_string(session_id())."' and productid = '%s' and orderoption1 = '%s' and orderoption2 = '%s' and orderoption3 = '%s' and orderoption4 = '%s' and orderoption5 = '%s' and option1name = '%s' and option2name = '%s' and option3name = '%s' and option4name = '%s' and option5name = '%s'", 
		
														mysql_real_escape_string($_POST['ProductID']),
			
														mysql_real_escape_string($_POST['option1']),
			
														mysql_real_escape_string($_POST['option2']),
			
														mysql_real_escape_string($_POST['option3']),
			
														mysql_real_escape_string($_POST['option4']),
			
														mysql_real_escape_string($_POST['option5']),
			
														mysql_real_escape_string($option1name),
			
														mysql_real_escape_string($option2name),
			
														mysql_real_escape_string($option3name),
			
														mysql_real_escape_string($option4name),
			
														mysql_real_escape_string($option5name));
		
													}
		
													//finished building the SQL, go ahead and make the call
		
													$result=mysql_query($sql);
		
													//if we get a good result
		
													if(!mysql_error()){
		
														header("location:".$cartpage.$permalinkdivider."addtocart=true&ModelNumber=".$productadd['ModelNumber']);
		
													}else{
		
														header("location:".$cartpage.$permalinkdivider."addtocart=true&ModelNumber=".$productadd['ModelNumber']);	
		
													}
		
													break;
		
												}
		
											}
		
										}
		
									}
		
									////////////////////////////////////////////////////////////////////////////
									// loop through to see if you can find an existing REGULAR product with 
									// DIFFERENT OPTIONS, EXCEPT if they are DOWNLOAD or GIFTCARD
									///////////////////////////////////////////////////////////////////////
		
									mysql_data_seek($resultcheck,0);	
		
									while ($cartitem = mysql_fetch_assoc($resultcheck)) {	
		
										if ($cartitem['productid'] == $_POST['ProductID'] && $cartitem['isdownload'] != 1  && $cartitem['isgiftcard'] != 1 && ($cartitem['orderoption1'] != $_POST['option1'] || $cartitem['orderoption2'] != $_POST['option2'] || $cartitem['orderoption3'] != $_POST['option3'] || $cartitem['orderoption4'] != $_POST['option4'] || $cartitem['orderoption5'] != $_POST['option5'])) {
		
										if ($matchfound == false) {
		
											$matchfound = true;
		
											//this is an existing item but different options on it
		
											$sql = sprintf("Insert into tempcart(sessionid, productid, quantity, orderoption1, orderoption2, orderoption3, orderoption4,  orderoption5, option1name, option2name, option3name, option4name, option5name,  image1, orderprice, isgiftcard, ordertitle, orderdescription,  ordermodelnumber,  message, fromname, toname, deliverymethod, istaxable, isdownload, downloadid, stockquantity, weight, manufacturer) values('".mysql_real_escape_string(session_id())."', '%s', '%s', '%s', '%s', '%s', '%s', '%s',  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' , '%s',  '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
		
											mysql_real_escape_string($_POST['ProductID']),
		
											mysql_real_escape_string($_POST['Quantity']),
		
											mysql_real_escape_string($_POST['option1']),
		
											mysql_real_escape_string($_POST['option2']),
		
											mysql_real_escape_string($_POST['option3']),
		
											mysql_real_escape_string($_POST['option4']),
		
											mysql_real_escape_string($_POST['option5']),
		
											mysql_real_escape_string($option1name),
		
											mysql_real_escape_string($option2name),
		
											mysql_real_escape_string($option3name),
		
											mysql_real_escape_string($option4name),
		
											mysql_real_escape_string($option5name),
		
											mysql_real_escape_string($productadd['Image1']),
		
											mysql_real_escape_string($Price + $optionprice),
		
											mysql_real_escape_string($productadd['isGiftCard']),
		
											mysql_real_escape_string($productadd['Title']),	
		
											mysql_real_escape_string($productadd['Description']),
		
											mysql_real_escape_string($productadd['ModelNumber']),
		
											mysql_real_escape_string($_POST['textmessage']),
		
											mysql_real_escape_string($_POST['fromname']),
		
											mysql_real_escape_string($_POST['toname']),
		
											mysql_real_escape_string($_POST['deliverymethod']),
		
											mysql_real_escape_string($productadd['isTaxable']),
		
											mysql_real_escape_string($productadd['isDownload']),
		
											mysql_real_escape_string($productadd['downloadID']),
		
											mysql_real_escape_string($productadd['quantity']),
		
											mysql_real_escape_string($productadd['Weight']),
		
											mysql_real_escape_string($productadd['manufacturer']));	
		
											//finished building the SQL, go ahead and make the call
		
											$result=mysql_query($sql);
		
											//if we get a good result
		
											if($result){
		
												header("location:".$cartpage.$permalinkdivider."addtocart=true&ModelNumber=".$productadd['ModelNumber']);
		
											}else{
		
												header("location:".$cartpage.$permalinkdivider."addtocart=true&ModelNumber=".$productadd['ModelNumber']);
		
											}
		
											break;
		
										}
		
									}
		
								}
		
								///////////////////////////////////////////////////////////////////////////////////////
								///If product is a GIFT CARD, it get's it's own addition everytime as they are unique
								///////////////////////////////////////////////////////////////////////////////////////
		
								mysql_data_seek($resultcheck,0);	
		
								while ($cartitem = mysql_fetch_assoc($resultcheck)) {	
		
									if ($cartitem['isgiftcard'] == 1) {
		
										if ($matchfound == false) {
		
											$matchfound = true;
		
											//this is a new giftcard, so add it
		
											$sql = sprintf("Insert into tempcart(sessionid, productid, quantity, orderoption1, orderoption2, orderoption3, orderoption4,  orderoption5,  option1name, option2name, option3name, option4name, option5name, image1, orderprice, isgiftcard, ordertitle, orderdescription,  ordermodelnumber,  message, fromname, toname, deliverymethod, istaxable, isdownload, downloadid, stockquantity, weight, manufacturer) values('".mysql_real_escape_string(session_id())."', '%s', '%s', '%s',  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' , '%s',  '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
		
											mysql_real_escape_string($_POST['ProductID']),
		
											mysql_real_escape_string($_POST['Quantity']),
		
											mysql_real_escape_string($_POST['option1']),
		
											mysql_real_escape_string($_POST['option2']),
		
											mysql_real_escape_string($_POST['option3']),
		
											mysql_real_escape_string($_POST['option4']),
		
											mysql_real_escape_string($_POST['option5']),
		
											mysql_real_escape_string($option1name),
		
											mysql_real_escape_string($option2name),
		
											mysql_real_escape_string($option3name),
		
											mysql_real_escape_string($option4name),
		
											mysql_real_escape_string($option5name),
		
											mysql_real_escape_string($productadd['Image1']),
		
											mysql_real_escape_string($Price + $optionprice),
		
											mysql_real_escape_string($productadd['isGiftCard']),
		
											mysql_real_escape_string($productadd['Title']),	
		
											mysql_real_escape_string($productadd['Description']),
		
											mysql_real_escape_string($productadd['ModelNumber']),
		
											mysql_real_escape_string($_POST['textmessage']),
		
											mysql_real_escape_string($_POST['fromname']),
		
											mysql_real_escape_string($_POST['toname']),
		
											mysql_real_escape_string($_POST['deliverymethod']),
		
											mysql_real_escape_string($productadd['isTaxable']),
		
											mysql_real_escape_string($productadd['isDownload']),
		
											mysql_real_escape_string($productadd['downloadID']),
		
											mysql_real_escape_string($productadd['quantity']),
		
											mysql_real_escape_string($productadd['Weight']),
		
											mysql_real_escape_string($productadd['manufacturer']));	
		
											//finished building the SQL, go ahead and make the call
		
											$result=mysql_query($sql);
		
											//if we get a good result
		
											if($result){
		
												header("location:".$cartpage.$permalinkdivider."addtocart=true&ModelNumber=".$productadd['ModelNumber']);
		
											}else{

												header("location:".$cartpage.$permalinkdivider."addtocart=true&ModelNumber=".$productadd['ModelNumber']);		
											
											}
		
											break;	

										}
		
									}
		
								}
		
								//////////////////////////////////////////////////////////////////////////////////////////
								///If product is a DOWNLOAD, it gets one addition, but can not be added to the cart twice
								///////////////////////////////////////////////////////////////////////////////////////////
		
								mysql_data_seek($resultcheck,0);	
		
								while ($cartitem = mysql_fetch_assoc($resultcheck)) {		
		
									if ($cartitem['isdownload'] == 1) {
		
										header("location:".$cartpage."&addtocart=true");
		
									}
		
								}
		
							}
		
						}
		
					}
		
				}	
		
			}
		
		}
	
	}

}

?>