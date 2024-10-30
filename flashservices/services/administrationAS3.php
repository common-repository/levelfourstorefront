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

//Version 8.1.1 -  2005, 2012





	class administrationAS3

	{		

	

		function administrationAS3() {

			//load our connection settings

			require_once('../../Connections/flashdb.php');

			

			//load PEAR mail for SMTP if they exist on server

			$file1 = "Mail.php";

			$file2 = 'Mail/mime.php'; 

			$file3 = 'Mail/mail.php';

			if ( is_dir ( 'Mail/' ) )

			{

				$IncIsDir == TRUE;

			}

			

			if ( file_exists ( $file1) )

			{

				$file1exists == TRUE;

			}

			if ( file_exists ( $file2) )

			{

				$file2exists == TRUE;

			}

			if ( file_exists ( $file3) )

			{

				$file3exists == TRUE;

			}

			

			if ( $IncIsDir && $file1exists && $file2exists && $file3exists )

			{

				require_once ( $file1 );

				require_once ( $file2 );

				require_once ( $file3 );

			}



			//set our connection variables

			$dbhost = HOSTNAME;

			$dbname = DATABASE;

			$dbuser = USERNAME;

			$dbpass = PASSWORD;	

			//make a connection to our database

			$this->conn = mysql_pconnect($dbhost, $dbuser, $dbpass);

			mysql_select_db ($dbname);	



		}	

		

		//AMFPHP only security - START

		//START AUTHETNICATED SESSION DURING ACCOUNT LOGIN

		//STOP AUTHENTICATIED SESSION WHEN STOPE STARTS DURING getcompany();

		//HELPER - security access to only those functions that have access

		//beforeFilter() is called prior to any AMFPHP service calls

		function beforeFilter($function_called){

			$memberName = $function_called."Roles";

			return (@$this->$memberName) ? Authenticate::isUserInRole($this->$memberName) : true;

		}

		

		//set which functions are accessable to users who are authenticated

		

		//dashboard

		var $getdashboardordersRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getdashboardreviewsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getdashboardproductsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getdashboardmenusRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//logins

		var $getcountriesRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getstatesRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getoptionsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getmenulevel1Roles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getmenulevel2Roles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getmenulevel3Roles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getmanufacturersRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getfeaturedproductsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//orders

		var $getordersRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getorderdetailsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getorderstatusRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updateorderstatusRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updateordernotesRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updateorderviewedRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deleteorderRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updateshippingstatusRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//downloads

		var $getdownloadsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deletedownloadRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updatedownloadRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $readdownloaddirectoryRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE		

		//clients

		var $getclientsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deleteclientRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updateclientRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $addclientRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//gift cards

		var $getgiftcardsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deletegiftcardRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updategiftcardRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $addgiftcardRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//subscribers

		var $getsubscribersRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deletesubscriberRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updatesubscriberRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $addsubscriberRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//products

		var $getproductsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $duplicateproductRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deleteproductRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updateproductRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $addproductRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deleteimageRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deletefiledownloadRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//reviews

		var $getreviewsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deletereviewRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updatereviewRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//options

		var $getoptionsetsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deleteoptionRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updateoptionRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $addoptionRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//optionitems

		var $getoptionitemsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deleteoptionitemRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updateoptionitemRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $addoptionitemRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//menulevel1

		var $getmenulevel1setRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deletemenulevel1Roles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updatemenulevel1Roles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $addmenulevel1Roles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//menulevel2

		var $getmenulevel2setRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deletemenulevel2Roles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updatemenulevel2Roles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $addmenulevel2Roles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//menulevel3

		var $getmenulevel3setRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deletemenulevel3Roles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updatemenulevel3Roles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $addmenulevel3Roles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//manufacturers

		var $getmanufacturersetRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deletemanufacturerRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updatemanufacturerRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $addmanufacturerRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//coupons

		var $getcouponsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deletecouponRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updatecouponRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $addcouponRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//taxes

		var $gettaxessetRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updatetaxesRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//shipping

		var $updateexpeditedratesRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getweightshippingratesRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deleteshippingweightrateRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updateshippingweightrateRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $addshippingweightrateRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getpriceshippingratesRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deleteshippingpricerateRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updateshippingpricerateRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $addshippingpricerateRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $getshippingsettingsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updateshippingsettingsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//database

		var $restoredbRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $deletedbfileRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $logdbrestoreRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $logdbbackupRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//settings

		var $getsitesettingsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updatesitesettingsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		//countrylist
		var $updatecountryRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		var $deletecountryRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		var $addcountryRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		//statelist
		var $updatestateRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		var $deletestateRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		var $addstateRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		//perpage
		var $getperpageRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		var $updateperpageRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		var $deleteperpageRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		var $addperpageRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		//pricepoints
		var $getpricepointsRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		var $updatepricepointRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		var $deletepricepointRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE
		var $addpricepointRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//page content

		var $getpagecontentRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		var $updatepagecontentRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		//mail newsletter content

		var $mailnewsletterRoles = "client, admin"; //SECURED FUNCTION - ONLY AUTHENTICATED USERS CAN USE

		

		private function loginUser() {

			Authenticate::login('client','admin'); //Authenticate as a client shopper

		}

		

		private function logoutUser() {

			Authenticate::logout(); //remove session authentication as client shopper

		}

		//AMFPHP only security - END

		

		

		//HELPER - used to escape out SQL calls

		function escape($sql) 

		{ 

			  $args = func_get_args(); 

				foreach($args as $key => $val) 

				{ 

					$args[$key] = mysql_real_escape_string($val); 

				} 

				 

				$args[0] = $sql; 

				return call_user_func_array('sprintf', $args); 

		} 

		

		

		//dashboard functions

		function getdashboardorders() {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS orders.BillName, orders.BillLastName, orders.Total, UNIX_TIMESTAMP(orders.OrderDate) AS OrderDate, orders.Email, orders.OrderStatus, orders.OrderID FROM orders  ORDER BY orders.OrderDate DESC LIMIT 0, 6");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					 $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		

		function getdashboardmenus() {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS menulevel1.* FROM menulevel1 ORDER BY menulevel1.Clicks DESC LIMIT 0, 6");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function getdashboardreviews() {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS  products.Title, reviews.*, UNIX_TIMESTAMP(reviews.datesubmitted) AS datesubmitted  FROM reviews  LEFT JOIN products ON products.ProductID = reviews.productID ORDER BY reviews.datesubmitted DESC LIMIT 0, 6");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function getdashboardproducts() {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS products.*, statistics.* FROM products LEFT JOIN statistics ON products.ProductID = statistics.ProductID ORDER BY statistics.views DESC LIMIT 0, 6");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}



		//login functions

		function login($Email, $Password) {

			  //Create SQL Query

			  $sql = $this->escape("SELECT * FROM clients where clients.Email = '%s' AND clients.Password = '%s' AND clients.UserLevel = 'admin'", $Email, $Password);

			  // Run query on database

			  $result = mysql_query($sql);

			  //now get version

			  $versionsql = $this->escape("select settings.storeversion, settings.storetype FROM settings WHERE settings.settingID = 1");

			  $versionresult = mysql_query($versionsql); 

			  //return $versionresult;

			  if ($versionresult) {

				 $versionrow = mysql_fetch_array($versionresult); 

				 $storeversion = $versionrow[storeversion];

				 $storetype = $versionrow[storetype];

			  } else {

				 //return 'not exists';

			     $storeversion = '7.0.0';

				 $storetype = 'flash';

			  }

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($result) > 0) {

				  while ($row=mysql_fetch_object($result)) {

					  //now attach the version if it's there

					  $row->storeversion = $storeversion;

					  $row->storetype = $storetype;

					  $returnArray[] = $row;

				  }

				  $this->loginUser();  //login user to AMFPHP security module

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		

		function getversion() {

			  //Create SQL Query

			  $sql = $this->escape("SELECT * FROM countries");

			  // Run query on database

			  $result = mysql_query($sql);

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($result) > 0) {

				  while ($row=mysql_fetch_object($result)) {

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		

		function getcountries() {

			  //Create SQL Query

			  $sql = $this->escape("SELECT * FROM countries ORDER BY sortorder ASC");

			  // Run query on database

			  $result = mysql_query($sql);

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($result) > 0) {

				  while ($row=mysql_fetch_object($result)) {

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function getstates() {

			  //Create SQL Query

			  $sql = $this->escape("SELECT * FROM states ORDER BY sortorder ASC");

			  // Run query on database

			  $result = mysql_query($sql);

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($result) > 0) {

				  while ($row=mysql_fetch_object($result)) {

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function getoptions() {

			  //Create SQL Query

			  $sql = $this->escape("SELECT * FROM options ORDER BY optionName ASC");

			  // Run query on database

			  $result = mysql_query($sql);

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($result) > 0) {

				  while ($row=mysql_fetch_object($result)) {

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function getmenulevel1() {

			  //Create SQL Query

			  $sql = $this->escape("SELECT * FROM menulevel1 ORDER BY menu1order ASC");

			  // Run query on database

			  $result = mysql_query($sql);

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($result) > 0) {

				  while ($row=mysql_fetch_object($result)) {

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function getmenulevel2() {

			  //Create SQL Query

			  $sql = $this->escape("SELECT * FROM menulevel2 ORDER BY menu2order ASC");

			  // Run query on database

			  $result = mysql_query($sql);

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($result) > 0) {

				  while ($row=mysql_fetch_object($result)) {

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function getmenulevel3() {

			  //Create SQL Query

			  $sql = $this->escape("SELECT * FROM menulevel3 ORDER BY menu3order ASC");

			  // Run query on database

			  $result = mysql_query($sql);

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($result) > 0) {

				  while ($row=mysql_fetch_object($result)) {

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function getmanufacturers() {

			  //Create SQL Query

			  $sql = $this->escape("SELECT * FROM manufacturer ORDER BY manufacturername");

			  // Run query on database

			  $result = mysql_query($sql);

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($result) > 0) {

				  while ($row=mysql_fetch_object($result)) {

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function getfeaturedproducts() {

			  //Create SQL Query

			  $sql = $this->escape("SELECT products.ProductID, products.Title, products.ModelNumber FROM products ORDER BY products.Title ASC");

			  // Run query on database

			  $result = mysql_query($sql);

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($result) > 0) {

				  while ($row=mysql_fetch_object($result)) {

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		

		//orders functions

		function getorders($startrecord, $limit, $orderby, $ordertype, $filter) {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS orders.BillName, orders.BillLastName, orders.orderviewed, orders.Total, UNIX_TIMESTAMP(orders.OrderDate) AS OrderDate, orders.Email, orders.ClientID, orders.OrderStatus, orders.OrderID FROM orders WHERE orders.ClientID != -1 ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  //return $query;

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					 $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function getorderdetails($orderid) {

			  //Create SQL Query

			  $query = $this->escape("SELECT details.*, orders.*, UNIX_TIMESTAMP(orders.OrderDate) AS OrderDate, errortable.*, downloadkey.* FROM (((orders LEFT JOIN details ON details.OrderID = orders.OrderID) LEFT JOIN downloadkey ON details.downloadkey = downloadkey.uniqueid)  LEFT JOIN errortable ON errortable.OrderID = orders.OrderID) WHERE orders.OrderID = '$orderid' ORDER BY details.ProductID");

			 // return $query;

			  $ordersquery = mysql_query($query);

			 // $ordersquery = mysql_query("SELECT clients.*, details.*, orders.*, UNIX_TIMESTAMP(orders.OrderDate) AS OrderDate, errortable.*, downloadkey.* FROM ((((clients LEFT JOIN orders ON orders.ClientID = clients.ClientID) LEFT JOIN details ON details.OrderID = orders.OrderID) LEFT JOIN downloadkey ON details.downloadkey = downloadkey.uniqueid)  LEFT JOIN errortable ON errortable.OrderID = orders.OrderID) WHERE orders.OrderID = '$orderid' ORDER BY details.ProductID");



			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($ordersquery) > 0) {

				  while ($row = mysql_fetch_object($ordersquery)) {

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function getorderstatus() {

			  //Create SQL Query

			  $ordersquery = mysql_query("SELECT * FROM orderstatus");



			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($ordersquery) > 0) {

				  while ($row = mysql_fetch_object($ordersquery)) {

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updateorderstatus($orderid, $status) {

			  //Create SQL Query

			$sql = $this->escape("UPDATE orders SET OrderStatus='%s' WHERE orders.OrderID = '%s'", $status, $orderid);

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		

		}

		function updateordernotes($orderid, $notes) {

			  //Create SQL Query

			$sql = $this->escape("UPDATE orders SET ordernotes='%s' WHERE orders.OrderID = '%s'", $notes, $orderid);

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		

		}

		function updateorderviewed($orderid) {

			 //Create SQL Query

			 $sql = sprintf("UPDATE orders SET orderviewed = 1 WHERE orders.OrderID = '%s'",

				mysql_real_escape_string($orderid));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		}	

		

		function deleteorder($orderid) {

			  //Create SQL Query

			$ordersql = $this->escape("DELETE FROM orders WHERE orders.OrderID = '%s'", $orderid);

			//Run query on database;

			mysql_query($ordersql);

			

			$orderdetailssql = $this->escape("DELETE FROM details WHERE details.OrderID = '%s'", $orderid);

			//Run query on database;

			mysql_query($orderdetailssql);

			

			$downloadkeysql = $this->escape("DELETE FROM downloadkey WHERE downloadkey.orderid = '%s'", $orderid);

			//Run query on database;

			mysql_query($downloadkeysql);

			

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		}

		function updateshippingstatus($orderid, $shipcarrier, $shiptrackingcode, $sendemail, $clientemail) {

			  //Create SQL Query

			$sql = $this->escape("UPDATE orders SET orders.ShipCarrier='%s', orders.TrackingNumber='%s' WHERE orders.OrderID = '%s'", $shipcarrier, $shiptrackingcode, $orderid);

			//Run query on database;

			mysql_query($sql);



			if($sendemail == 1) {

				// retrieve the clients name and email

				$sql = sprintf("SELECT details.*, orders.* FROM (orders LEFT JOIN details ON details.OrderID=orders.OrderID) WHERE orders.OrderID='$orderid' ORDER BY details.ProductID");

				$result1 = mysql_query($sql);

				$client = mysql_fetch_assoc($result1);

				// retrieve the total and shipping from orderID

				$result2 = mysql_query("Select * from orders where OrderID='".$orderid."'");

				$order = mysql_fetch_array($result2);

				//Select details of each item for an itemized record

				$result3 = mysql_query("Select * from details  where OrderID='".$orderid."'");

				//get settings for email handling information

				$settingsquery= mysql_query("Select * from settings where settingID = '1'");

				$settings = mysql_fetch_array($settingsquery);

				//Build the email message with full itemized paging

				$Text = "This email is html, please switch to this view.";

				$salestax = number_format($order[Tax], 2);

				$shippingcost = number_format($order[Shipping], 2);



				$message = "--==MIME_BOUNDRY_alt_main_message\n";

				$message .= "Content-Type: text/plain; charset=ISO-8859-1\n";

				$message .= "Content-Transfer-Encoding: 7bit\n\n";

				$message .= $Text . "\n\n";

				$message .= "--==MIME_BOUNDRY_alt_main_message\n";

				$message .= "Content-Type: text/html; charset=ISO-8859-1\n";

				$message .= "Content-Transfer-Encoding: 7bit\n\n";

				

				$trackingnumber = $shiptrackingcode;

				$shipcarrier = $shipcarrier;

				$message .= "<html><head><title>..::Shipping Confirmation - Order Number $OrderID ::..</title><style type='text/css'><!--.style20 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }.style22 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }--></style></head><body> <table width='539' border='0' align='center'>   <tr><td colspan='4' align='left' class='style22'><img src='http://$settings[siteURL]/images/emaillogo.jpg' width='532' height='97'></td></tr><tr><td colspan='4' align='left' class='style22'><p><br> Dear $client[BillName]  $client[BillLastName]: </p><p>Your recent order  with the number <strong>$KTColParam1_orderdetails</strong> has been shipped! You should be receiving it within a short time period.<br>";

				

				if ($trackingnumber != '0' && $trackingnumber != 'Null'&& $trackingnumber != 'NULL'&& $trackingnumber != 'null'&& $trackingnumber != NULL && $trackingnumber != '') {

					$message .= "<br>  You may check the status of your order by visiting your carriers website and using the following tracking number.</p><p>Package Carrier: $shipcarrier<br>Package Tracking Number: $trackingnumber</p>";

				}

				

				$message .= "<p><br></p></td></tr><tr><td colspan='4' align='left' class='style20'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td width='47%' bgcolor='#F3F1ED' class='style20'>Billing Address</td><td width='3%'>&nbsp;</td><td width='50%' bgcolor='#F3F1ED' class='style20'>Shipping Address</td></tr><tr>   <td><span class='style22'>     $client[BillName]       $client[BillLastName]    </span></td>    <td>&nbsp;</td>   <td><span class='style22'>     $client[ShipName]       $client[ShipLastName]     </span></td> </tr><tr><td><span class='style22'> $client[BillAddress]  </span></td>   <td>&nbsp;</td><td><span class='style22'>     $client[ShipAddress]    </span></td> </tr><tr><td><span class='style22'>       $client[BillCity]        , $client[BillState]   &nbsp;  $client[BillZip]  </span></td>   <td>&nbsp;</td>   <td><span class='style22'>     $client[ShipCity]      , $client[ShipState]       &nbsp; $client[ShipZip]    </span></td> </tr><tr><td><span class='style22'>Phone:    $client[BillPhone]  </span></td>   <td>&nbsp;</td><td><span class='style22'>Phone:      $client[ShipPhone]    </span></td> </tr></table></td></tr><tr><td width='269' align='left'>&nbsp;</td><td width='80' align='center'>&nbsp;</td><td width='91' align='center'>&nbsp;</td><td align='center'>&nbsp;</td></tr><tr><td width='269' align='left' bgcolor='#F3F1ED' class='style20'>Product</td><td width='80' align='center' bgcolor='#F3F1ED' class='style20'>Qty</td><td width='91' align='center' bgcolor='#F3F1ED' class='style20'>Unit Price</td><td align='center' bgcolor='#F3F1ED' class='style20'>Ext Price</td></tr>";

					while($row=mysql_fetch_array($result3)) 

					{

						$finaltotal = number_format($row[OrderPrice]+$row[OrderGratuity], 2);

						$totalitemprice = number_format($row[Quantity]*$row[OrderPrice], 2);

						$message .= "<tr><td width='269' class='style22'>$row[OrderTitle]</td><td width='80' align='center' class='style22'>$row[Quantity]</td><td width='91' align='center' class='style22'>$$finaltotal </td><td align='center' class='style22'>$$totalitemprice</td></tr> ";				

					}

				$total = number_format($order[Total], 2);

				$message .="<tr><td width='269'>&nbsp;</td><td width='80' align='center'>&nbsp;</td><td width='91' align='center'>&nbsp;</td><td>&nbsp;</td></tr><tr><td width='269'>&nbsp;</td><td width='80' align='center' class='style22'>&nbsp;</td><td width='91' align='center' class='style22'>Sales Tax</td><td align='center' class='style22'>$$salestax</td></tr><tr><td width='269'>&nbsp;</td><td width='80' align='center' class='style22'>&nbsp;</td><td width='91' align='center' class='style22'>Shipping</td><td  align='center'  class='style22'>$$shippingcost </td></tr><tr><td width='269'>&nbsp;</td><td width='80' align='center' class='style22'>&nbsp;</td><td width='91' align='center' class='style22'><strong>Order Total</strong></td><td align='center' class='style22'><strong>$$total</strong></td></tr><tr><td colspan='4' class='style22'><p><br>Please double check your order when you receive it and let us know immediately if there are any concerns or issues. We always value your business and hope you enjoy your product.<br><br>Thank you very much!<br><br><br></p></td></tr><tr><td colspan='4'><p class='style22'><img src='http://$settings[siteURL]/images/emailfooter.jpg' width='532' height='97'></p></td></tr></table></body></html>";

				

				//headers

				$headers = "From: $settings[orderfromemail]\r\n";

				$headers .= "Reply-To: $settings[orderfromemail]\r\n";

				$headers .= "X-Mailer: PHP4\n";

				$headers .= "X-Priority: 3\n";

				$headers .= "MIME-Version: 1.0\n";

				$headers .= "Return-Path: $settings[orderfromemail]\r\n"; 

				$headers .= "Content-Type: multipart/alternative; boundary=\"==MIME_BOUNDRY_alt_main_message\"\n\n";

			

				//mail individual gift card message

				mail($clientemail, 'Order Shipped - Confirmation', $message, $headers);

			  }//close if this is an emailer

							  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		

		//download functions

		function getdownloads($startrecord, $limit, $orderby, $ordertype, $filter) {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS downloadkey.* FROM downloadkey WHERE downloadkey.uniqueid != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deletedownload($downloadid) {

			  //Create SQL Query	

			$downloadkeysql = $this->escape("DELETE FROM downloadkey WHERE downloadkey.uniqueid = '%s'", $downloadid);

			//Run query on database;

			mysql_query($downloadkeysql);

			

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		

		}

		function updatedownload($downloadid, $downloads, $downloadname) {

			  //Create SQL Query

			$sql = $this->escape("UPDATE downloadkey SET downloads='%s', productid='%s' WHERE downloadkey.uniqueid = '%s'", $downloads, $downloadname, $downloadid);

			//Run query on database;

			mysql_query($sql);

			  //Create SQL Query

			$productsql = $this->escape("UPDATE details SET downloadID = '%s' WHERE details.downloadkey = '%s'", $downloadname, $downloadid);

			//Run query on database;

			mysql_query($productsql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = mysql_error();

				return $returnArray; //return noresults if there are no results

			}

		}

		function readdownloaddirectory() { 

			  //get a list of files in the download directory

			$listDir = array(); 

			$dir = "../../products/downloads";

			if($handler = opendir($dir)) { 

				while (($sub = readdir($handler)) !== FALSE) { 

					if ($sub != "." && $sub != ".." && $sub != "Thumb.db" && $sub != "_notes" && $sub != ".htaccess") { 

						if(is_file($dir."/".$sub)) { 

							$listDir[] = $sub; 

						}

					} 

				}    

				closedir($handler); 

			} 

			return $listDir;    

		} 



		//client account functions

		function getclients($startrecord, $limit, $orderby, $ordertype, $filter) {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS clients.* FROM clients WHERE clients.ClientID != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deleteclient($clientid) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM clients WHERE clients.ClientID = '%s'", $clientid);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updateclient($clientid, $client) {

			  //Create SQL Query

			  $sql = sprintf("Replace into clients(ClientID, Email, Password, BillName, BillLastName, BillAddress, BillCity, BillState, BillCountry, BillZip, BillPhone, ShipName, ShipLastName, ShipAddress, ShipCity, ShipState, ShipCountry, ShipZip, ShipPhone, UserLevel, subscriber)

				values('".$clientid."', '%s', '%s', '%s',  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',  '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",

				mysql_real_escape_string($client['email']),

				mysql_real_escape_string($client['password']),

				mysql_real_escape_string($client['billname']),

				mysql_real_escape_string($client['billlastname']),

				mysql_real_escape_string($client['billaddress']),

				mysql_real_escape_string($client['billcity']),

				mysql_real_escape_string($client['billstate']),

				mysql_real_escape_string($client['billcountry']),

				mysql_real_escape_string($client['billzip']),

				mysql_real_escape_string($client['billphone']),

				mysql_real_escape_string($client['shipname']),

				mysql_real_escape_string($client['shiplastname']),

				mysql_real_escape_string($client['shipaddress']),

				mysql_real_escape_string($client['shipcity']),

				mysql_real_escape_string($client['shipstate']),

				mysql_real_escape_string($client['shipcountry']),

				mysql_real_escape_string($client['shipzip']),

				mysql_real_escape_string($client['shipphone']),

				mysql_real_escape_string($client['userlevel']),

				mysql_real_escape_string($client['subscriber']));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		}

		function addclient($client) {

			  //Create SQL Query

			  $sql = sprintf("Insert into clients(ClientID, Email, Password, BillName, BillLastName, BillAddress, BillCity, BillState, BillCountry, BillZip, BillPhone, ShipName, ShipLastName, ShipAddress, ShipCity, ShipState, ShipCountry, ShipZip, ShipPhone, UserLevel, subscriber)

				values(Null, '%s', '%s', '%s',  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',  '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",

				mysql_real_escape_string($client['email']),

				mysql_real_escape_string($client['password']),

				mysql_real_escape_string($client['billname']),

				mysql_real_escape_string($client['billlastname']),

				mysql_real_escape_string($client['billaddress']),

				mysql_real_escape_string($client['billcity']),

				mysql_real_escape_string($client['billstate']),

				mysql_real_escape_string($client['billcountry']),

				mysql_real_escape_string($client['billzip']),

				mysql_real_escape_string($client['billphone']),

				mysql_real_escape_string($client['shipname']),

				mysql_real_escape_string($client['shiplastname']),

				mysql_real_escape_string($client['shipaddress']),

				mysql_real_escape_string($client['shipcity']),

				mysql_real_escape_string($client['shipstate']),

				mysql_real_escape_string($client['shipcountry']),

				mysql_real_escape_string($client['shipzip']),

				mysql_real_escape_string($client['shipphone']),

				mysql_real_escape_string($client['userlevel']),

				mysql_real_escape_string($client['subscriber']));

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		

		//giftcard functions

		function getgiftcards($startrecord, $limit, $orderby, $ordertype, $filter) {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS giftcards.* FROM giftcards WHERE giftcards.giftcardid != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deletegiftcard($cardid) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM giftcards WHERE giftcards.giftcardid = '%s'", $cardid);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updategiftcard($cardid, $card) {

			  //Create SQL Query

			  $sql = sprintf("Replace into giftcards(giftcardid, giftcardamount, giftcardmessage, isgiftcard)

				values('".$cardid."', '%s', '%s', '%s')",

				mysql_real_escape_string($card['giftcardamount']),

				mysql_real_escape_string($card['giftcardmessage']),

				mysql_real_escape_string($card['isgiftcard']));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$sqlerror = mysql_error();

				$error = explode(" ", $sqlerror);

				if ($error[0] == "Duplicate") {

					$returnArray[] = "duplicate";

					return $returnArray; //return noresults if there are no results

			    } else {  

					$returnArray[] = "error";

					return $returnArray; //return noresults if there are no results

				}

			}

		}

		function addgiftcard($card) {

			  //Create SQL Query

			  $sql = sprintf("Insert into giftcards(giftcardid, giftcardamount, giftcardmessage, isgiftcard)

				values('%s', '%s', '%s', '%s')",

				mysql_real_escape_string($card['giftcardid']),

				mysql_real_escape_string($card['giftcardamount']),

				mysql_real_escape_string($card['giftcardmessage']),

				mysql_real_escape_string($card['isgiftcard']));

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $sqlerror = mysql_error();

				  $error = explode(" ", $sqlerror);

				  if ($error[0] == "Duplicate") {

					 $returnArray[] = "duplicate";

					 return $returnArray; //return noresults if there are no results

				  } else {  

				  	 $returnArray[] = "error";

					 return $returnArray; //return noresults if there are no results

				  }

			  }

		}

		

		//subscriber functions

		function getsubscribers($startrecord, $limit, $orderby, $ordertype, $filter) {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS subscribers.* FROM subscribers  WHERE subscribers.subscriberID != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deletesubscriber($subscriberid) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM subscribers WHERE subscribers.subscriberID = '%s'", $subscriberid);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updatesubscriber($subscriberid, $subscriber) {

			  //Create SQL Query

			  $sql = sprintf("Replace into subscribers(subscriberID, email, firstname, lastname)

				values('".$subscriberid."', '%s', '%s', '%s')",

				mysql_real_escape_string($subscriber['email']),

				mysql_real_escape_string($subscriber['firstname']),

				mysql_real_escape_string($subscriber['lastname']));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		}

		function addsubscriber($subscriber) {

			  //Create SQL Query

			  $sql = sprintf("Insert into subscribers(subscriberID, email, firstname, lastname)

				values(Null, '%s', '%s', '%s')",

				mysql_real_escape_string($subscriber['email']),

				mysql_real_escape_string($subscriber['firstname']),

				mysql_real_escape_string($subscriber['lastname']));

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		

		//product functions

		function getproducts($startrecord, $limit, $orderby, $ordertype, $filter) {

			//Create SQL Query
			$sql = "SELECT SQL_CALC_FOUND_ROWS products.*, statistics.views, statistics.lastUpdated FROM products LEFT JOIN statistics ON products.ProductID = statistics.ProductID WHERE products.ProductID != '' " . $filter . " ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord . ", ". $limit;
			
			$query = mysql_query($sql);
			
			NetDebug::trace($sql);
			
			$totalquery=mysql_query("SELECT FOUND_ROWS()");
			
			$totalrows = mysql_fetch_object($totalquery);
			
			
			
			//if results, convert to an array for use in flash
			
			if(mysql_num_rows($query) > 0) {
			
			  while ($row=mysql_fetch_object($query)) {
			
				  $row->totalrows=$totalrows;
			
				  $returnArray[] = $row;
			
			  }
			
			  return($returnArray); //return array results if there are some
			
			} else {
			
			  $returnArray[] = "noresults";
			
			  return $returnArray; //return noresults if there are no results
			
			}

		}
		
		function DuplicateMySQLRecord ($table, $id_field, $id) {
			// load the original record into an array
			$result = mysql_query("SELECT * FROM {$table} WHERE {$id_field}={$id}");
			$original_record = mysql_fetch_assoc($result);
			
			// insert the new record and get the new auto_increment id
			mysql_query("INSERT INTO {$table} (`{$id_field}`) VALUES (NULL)");
			$newid = mysql_insert_id();
			
			// generate the query to update the new record with the previous values
			$query = "UPDATE {$table} SET ";
			foreach ($original_record as $key => $value) {
				if ($key != $id_field) {
					$query .= '`'.$key.'` = "'.str_replace('"','\"',$value).'", ';
				}
			}
			$query = substr($query,0,strlen($query)-2); # lop off the extra trailing comma
			$query .= " WHERE {$id_field}={$newid}";
			mysql_query($query);
			
			// return the new id
			return $newid;
		}
		
		function duplicateproduct($productid) {
			
			// load the original record into an array
			$result = mysql_query(sprintf("SELECT * FROM products WHERE ProductID='%s'", mysql_real_escape_string($productid)));
			$original_record = mysql_fetch_assoc($result);
			
			$randmodel = rand(1000000, 10000000);
			
			// insert the new record and get the new auto_increment id
			mysql_query(sprintf("INSERT INTO products(ProductID, ModelNumber) VALUES (NULL, '%s')", mysql_real_escape_string($randmodel)));
			$newid = mysql_insert_id();
			
			// generate the query to update the new record with the previous values
			$query = "UPDATE products SET ";
			foreach ($original_record as $key => $value) {
				if ($key != "ProductID" && $key != "ModelNumber") {
					$query .= '`'.$key.'` = "'.str_replace('"','\"',mysql_real_escape_string($value)).'", ';
				}
			}
			$query = substr($query,0,strlen($query)-2); # lop off the extra trailing comma
			$query .= " WHERE ProductID=" . $newid;
			mysql_query($query);
		
			NetDebug::trace($query);
			
			//duplicate option image rows
			$optionimagessql = sprintf("SELECT * FROM optionitemimages WHERE productID = '%s'", mysql_real_escape_string($productid));
			$result = mysql_query($optionimagessql);
			
			while($row = mysql_fetch_assoc($result)){
				$sql = sprintf("INSERT INTO optionitemimages(optionitemID, Image1, Image2, Image3, Image4, Image5, productID) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')", mysql_real_escape_string($row['optionitemID']), mysql_real_escape_string($row['Image1']), mysql_real_escape_string($row['Image2']), mysql_real_escape_string($row['Image3']), mysql_real_escape_string($row['Image4']), mysql_real_escape_string($row['Image5']), mysql_real_escape_string($newid));
				mysql_query($sql);
			
				NetDebug::trace($sql);
			}
			
			//duplicate option quantity rows
			$optionquantitysql = sprintf("SELECT * FROM optionitemquantity WHERE ProductID = '%s'", mysql_real_escape_string($productid));
			$result = mysql_query($optionquantitysql);
			
			while($row = mysql_fetch_assoc($result)){
				$sql = sprintf("INSERT INTO optionitemquantity(OptionItemID1, OptionItemID2, OptionItemID3, OptionItemID4, OptionItemID5, Quantity, ProductID) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')", mysql_real_escape_string($row['OptionItemID1']), mysql_real_escape_string($row['OptionItemID2']), mysql_real_escape_string($row['OptionItemID3']), mysql_real_escape_string($row['OptionItemID4']), mysql_real_escape_string($row['OptionItemID5']), mysql_real_escape_string($row['Quantity']), mysql_real_escape_string($newid));
				mysql_query($sql);
			
				NetDebug::trace($sql);
			}
			
			


			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deleteproduct($productid) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM products WHERE products.ProductID = '%s'", $productid);

			  //Run query on database;

			  mysql_query($deletesql);
			  
			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM optionitemimages WHERE optionitemimages.productID = '%s'", $productid);

			  //Run query on database;

			  mysql_query($deletesql);
			  
			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM optionitemquantity WHERE optionitemquantity.ProductID = '%s'", $productid);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updateproduct($productid, $product) {

			  //Create SQL Query

			  $sql = sprintf("UPDATE products SET Price = '%s', Title = '%s', Description = '%s', ModelNumber = '%s', InStock = '%s', manufacturer = '%s', Image1 = '%s', Image2 = '%s', Image3 = '%s', Image4 = '%s', Image5 = '%s', isGiftCard = '%s', downloadID = '%s', isTaxable = '%s', isDownload = '%s', weight = '%s', quantity = '%s', featureditem = '%s', Cat1Name = '%s', Cat2Name = '%s', Cat3Name = '%s', Cat1bName = '%s', Cat2bName = '%s', Cat3bName = '%s', Cat1cName = '%s', Cat2cName = '%s', Cat3cName = '%s', option1 = '%s', option2 = '%s', option3 = '%s', option4 = '%s', option5 = '%s', featureproduct1 = '%s', featureproduct2 = '%s', featureproduct3 = '%s', featureproduct4 = '%s', shortDescription = '%s', usespecs = '%s', allowreviews = '%s', specifications = '%s', ListPrice = '%s', Keywords = '%s', isSpecial = '%s', useoptionitemimages = '%s', useQuantityTracking = '%s', isdonation = '%s' WHERE ProductID = '%s'",

				mysql_real_escape_string($product['listprice']),

				mysql_real_escape_string($product['producttitle']),

				mysql_real_escape_string($product['productdescription']),

				mysql_real_escape_string($product['modelnumber']),

				mysql_real_escape_string($product['listproduct']),

				mysql_real_escape_string($product['productmanufacturer']),

				mysql_real_escape_string($product['Image1']),

				mysql_real_escape_string($product['Image2']),

				mysql_real_escape_string($product['Image3']),

				mysql_real_escape_string($product['Image4']),

				mysql_real_escape_string($product['Image5']),

				mysql_real_escape_string($product['isgiftcard']),

				mysql_real_escape_string($product['downloadid']),

				mysql_real_escape_string($product['taxableproduct']),

				mysql_real_escape_string($product['isdownload']),

				mysql_real_escape_string($product['productweight']),

				mysql_real_escape_string($product['quantity']),

				mysql_real_escape_string($product['featuredproduct']),

				mysql_real_escape_string($product['Cat1Name']),

				mysql_real_escape_string($product['Cat2Name']),

				mysql_real_escape_string($product['Cat3Name']),

				mysql_real_escape_string($product['Cat1bName']),

				mysql_real_escape_string($product['Cat2bName']),

				mysql_real_escape_string($product['Cat3bName']),

				mysql_real_escape_string($product['Cat1cName']),

				mysql_real_escape_string($product['Cat2cName']),

				mysql_real_escape_string($product['Cat3cName']),

				mysql_real_escape_string($product['option1']),

				mysql_real_escape_string($product['option2']),

				mysql_real_escape_string($product['option3']),

				mysql_real_escape_string($product['option4']),

				mysql_real_escape_string($product['option5']),

				mysql_real_escape_string($product['featureproduct1']),

				mysql_real_escape_string($product['featureproduct2']),

				mysql_real_escape_string($product['featureproduct3']),

				mysql_real_escape_string($product['featureproduct4']),

				mysql_real_escape_string($product['seoshortdescription']),

				mysql_real_escape_string($product['usespecs']),

				mysql_real_escape_string($product['allowreviews']),

				mysql_real_escape_string($product['specifications']),

				mysql_real_escape_string($product['previousprice']),

				mysql_real_escape_string($product['seokeywords']),

				mysql_real_escape_string($product['isspecial']),

				mysql_real_escape_string($product['useoptionitemimages']),

				mysql_real_escape_string($product['usequantitytracking']),

				mysql_real_escape_string($product['isdonation']),
				
				mysql_real_escape_string($productid));



			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$sqlerror = mysql_error();

				$error = explode(" ", $sqlerror);

				if ($error[0] == "Duplicate") {

					$returnArray[] = "duplicate";

					return $returnArray; //return noresults if there are no results

			    } else {  

					$returnArray[] = "error";

					return $returnArray; //return noresults if there are no results

				}

			}

		}

		function addproduct($product) {

			  //Create SQL Query

			  $sql = sprintf("INSERT into products(Price, Title, Description, ModelNumber, InStock, manufacturer, Image1, Image2, Image3, Image4, Image5, isGiftCard, downloadID, isTaxable, isDownload, weight, quantity, featureditem, Cat1Name, Cat2Name, Cat3Name, Cat1bName, Cat2bName, Cat3bName, Cat1cName, Cat2cName, Cat3cName, option1, option2, option3, option4, option5, featureproduct1, featureproduct2, featureproduct3, featureproduct4, shortDescription, usespecs, allowreviews, specifications, ListPrice, Keywords, isSpecial, useoptionitemimages, useQuantityTracking, isDonation)

				values('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",

				mysql_real_escape_string($product['listprice']),

				mysql_real_escape_string($product['producttitle']),

				mysql_real_escape_string($product['productdescription']),

				mysql_real_escape_string($product['modelnumber']),

				mysql_real_escape_string($product['listproduct']),

				mysql_real_escape_string($product['productmanufacturer']),

				mysql_real_escape_string($product['Image1']),

				mysql_real_escape_string($product['Image2']),

				mysql_real_escape_string($product['Image3']),

				mysql_real_escape_string($product['Image4']),

				mysql_real_escape_string($product['Image5']),

				mysql_real_escape_string($product['isgiftcard']),

				mysql_real_escape_string($product['downloadid']),

				mysql_real_escape_string($product['taxableproduct']),

				mysql_real_escape_string($product['isdownload']),

				mysql_real_escape_string($product['productweight']),

				mysql_real_escape_string($product['quantity']),

				mysql_real_escape_string($product['featuredproduct']),

				mysql_real_escape_string($product['Cat1Name']),

				mysql_real_escape_string($product['Cat2Name']),

				mysql_real_escape_string($product['Cat3Name']),

				mysql_real_escape_string($product['Cat1bName']),

				mysql_real_escape_string($product['Cat2bName']),

				mysql_real_escape_string($product['Cat3bName']),

				mysql_real_escape_string($product['Cat1cName']),

				mysql_real_escape_string($product['Cat2cName']),

				mysql_real_escape_string($product['Cat3cName']),

				mysql_real_escape_string($product['option1']),

				mysql_real_escape_string($product['option2']),

				mysql_real_escape_string($product['option3']),

				mysql_real_escape_string($product['option4']),

				mysql_real_escape_string($product['option5']),

				mysql_real_escape_string($product['featureproduct1']),

				mysql_real_escape_string($product['featureproduct2']),

				mysql_real_escape_string($product['featureproduct3']),

				mysql_real_escape_string($product['featureproduct4']),

				mysql_real_escape_string($product['seoshortdescription']),

				mysql_real_escape_string($product['usespecs']),

				mysql_real_escape_string($product['allowreviews']),

				mysql_real_escape_string($product['specifications']),

				mysql_real_escape_string($product['previousprice']),

				mysql_real_escape_string($product['seokeywords']),

				mysql_real_escape_string($product['isspecial']),

				mysql_real_escape_string($product['useoptionitemimages']),

				mysql_real_escape_string($product['usequantitytracking']),

				mysql_real_escape_string($product['isdonation']));

			 	mysql_query($sql);
			
				NetDebug::trace($sql);

				//Update stats
				$statisticssql = sprintf("INSERT INTO statistics (ProductID, views, lastUpdated) VALUES ('%s', 0, NOW())", mysql_real_escape_string(mysql_insert_id()));	
				mysql_query($statisticssql);
				NetDebug::trace($statisticssql);
								
				$sql_getprodid = sprintf("SELECT ProductID from products WHERE ModelNumber = '%s'", $product['modelnumber']);
				$result_getprodid = mysql_query($sql_getprodid);
				$row_getprodid = mysql_fetch_assoc($result_getprodid);
				$newproductid = $row_getprodid['ProductID'];
				
				$updatequantities = sprintf("UPDATE optionitemquantity SET ProductID = '%s' WHERE ProductID = '%s'", $newproductid, $product['productid']);
				mysql_query($updatequantities);
			
				NetDebug::trace($updatequantities);
				
				$updateimages = sprintf("UPDATE optionitemimages SET productID = '%s' WHERE productID = '%s'", $newproductid, $product['productid']);
				mysql_query($updateimages);
			
				NetDebug::trace($updateimages);

				

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deleteimage($productid, $imagelocation, $imagename) {

			  //determine image location and then update databse and remove images and thumbnails			

			  if ($imagelocation == 1) {

					//Create SQL Query

					$sql = $this->escape("UPDATE products SET Image1='' WHERE products.ProductID = '%s'", $productid);

					if (file_exists("../../products/pics1/".$imagename)) unlink("../../products/pics1/".$imagename);

			  }

			  if ($imagelocation == 2) {

					//Create SQL Query

					$sql = $this->escape("UPDATE products SET Image2='' WHERE products.ProductID = '%s'", $productid);

					if (file_exists("../../products/pics2/".$imagename)) unlink("../../products/pics2/".$imagename);

			  }

			  if ($imagelocation == 3) {

					//Create SQL Query

					$sql = $this->escape("UPDATE products SET Image3='' WHERE products.ProductID = '%s'", $productid);

					if (file_exists("../../products/pics3/".$imagename)) unlink("../../products/pics3/".$imagename);

			  }

			  if ($imagelocation == 4) {

					//Create SQL Query

					$sql = $this->escape("UPDATE products SET Image4='' WHERE products.ProductID = '%s'",  $productid);

					if (file_exists("../../products/pics4/".$imagename)) unlink("../../products/pics4/".$imagename);

			  }

			  if ($imagelocation == 5) {

					//Create SQL Query

					$sql = $this->escape("UPDATE products SET Image5='' WHERE products.ProductID = '%s'", $productid);

					if (file_exists("../../products/pics5/".$imagename)) unlink("../../products/pics5/".$imagename);

			  }


			  //Run query on database;

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $sqlerror = mysql_error();

				  $error = explode(" ", $sqlerror);

				  if ($error[0] == "Duplicate") {

					  $returnArray[] = "duplicate";

					  return $returnArray; //return noresults if there are no results

				  } else {  

					  $returnArray[] = "error";

					  return $returnArray; //return noresults if there are no results

				  }

			  }

		}
		
		
		function deleteoptionitemimage($productid, $optionitemid, $imagelocation, $imagename) {

			  //determine image location and then update databse and remove images and thumbnails			

			  if ($imagelocation == 1) {

					//Create SQL Query

					$sql = $this->escape("UPDATE optionitemimages SET Image1='' WHERE optionitemimages.productID = '%s' AND optionitemimages.optionitemID = '%s'", $productid, $optionitemid);

					if (file_exists("../../products/pics1/".$imagename)) unlink("../../products/pics1/".$imagename);

			  }

			  if ($imagelocation == 2) {

					//Create SQL Query

					$sql = $this->escape("UPDATE optionitemimages SET Image2='' WHERE optionitemimages.productID = '%s' AND optionitemimages.optionitemID = '%s'", $productid, $optionitemid);

					if (file_exists("../../products/pics2/".$imagename)) unlink("../../products/pics2/".$imagename);

			  }

			  if ($imagelocation == 3) {

					//Create SQL Query

					$sql = $this->escape("UPDATE optionitemimages SET Image3='' WHERE optionitemimages.productID = '%s' AND optionitemimages.optionitemID = '%s'", $productid, $optionitemid);

					if (file_exists("../../products/pics3/".$imagename)) unlink("../../products/pics3/".$imagename);

			  }

			  if ($imagelocation == 4) {

					//Create SQL Query

					$sql = $this->escape("UPDATE optionitemimages SET Image4='' WHERE optionitemimages.productID = '%s' AND optionitemimages.optionitemID = '%s'", $productid, $optionitemid);

					if (file_exists("../../products/pics4/".$imagename)) unlink("../../products/pics4/".$imagename);

			  }

			  if ($imagelocation == 5) {

					//Create SQL Query

					$sql = $this->escape("UPDATE optionitemimages SET Image5='' WHERE optionitemimages.productID = '%s' AND optionitemimages.optionitemID = '%s'", $productid, $optionitemid);

					if (file_exists("../../products/pics5/".$imagename)) unlink("../../products/pics5/".$imagename);

			  }


			  //Run query on database;

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $sqlerror = mysql_error();

				  $error = explode(" ", $sqlerror);

				  if ($error[0] == "Duplicate") {

					  $returnArray[] = "duplicate";

					  return $returnArray; //return noresults if there are no results

				  } else {  

					  $returnArray[] = "error";

					  return $returnArray; //return noresults if there are no results

				  }

			  }

		}

		function deletefiledownload($productid, $filename) {

			  //Create SQL Query

			  $sql = $this->escape("UPDATE products SET downloadID='' WHERE products.ProductID = '%s'", $productid);

			  if (file_exists("../../products/downloads/".$filename)) unlink("../../products/downloads/".$filename);

			  //Run query on database;

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $sqlerror = mysql_error();

				  $error = explode(" ", $sqlerror);

				  if ($error[0] == "Duplicate") {

					  $returnArray[] = "duplicate";

					  return $returnArray; //return noresults if there are no results

				  } else {  

					  $returnArray[] = "error";

					  return $returnArray; //return noresults if there are no results

				  }

			  }

		}



		//review functions

		function getreviews($startrecord, $limit, $orderby, $ordertype, $filter) {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS  reviews.*, UNIX_TIMESTAMP(reviews.datesubmitted) AS datesubmitted  FROM reviews  WHERE reviews.reviewID != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deletereview($reviewid) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM reviews WHERE reviews.reviewID = '%s'", $reviewid);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updatereview($reviewid, $review) {

			  //Create SQL Query

			   $sql = $this->escape("UPDATE reviews SET reviewapproved='%s', reviewtitle='%s', reviewdescription='%s', rating='%s' WHERE reviews.reviewID = '%s'", $review['approved'], $review['reviewtitle'],$review['reviewdescription'],$review['rating'],$reviewid);



			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		}

	

		//option functions

		function getoptionsets($startrecord, $limit, $orderby, $ordertype, $filter) {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS options.* FROM options  WHERE options.optionID != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deleteoption($optionid) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM options WHERE options.optionID = '%s'", $optionid);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updateoption($optionid, $option) {

			  //Create SQL Query

			  $sql = sprintf("Replace into options(optionID, optionName, optionLabel)

				values('".$optionid."', '%s', '%s')",

				mysql_real_escape_string($option['optionname']),

				mysql_real_escape_string($option['optionlabel']));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		}

		function addoption($option) {

			  //Create SQL Query

			  $sql = sprintf("Insert into options(optionID, optionName, optionLabel)

				values(Null, '%s', '%s')",

				mysql_real_escape_string($option['optionname']),

				mysql_real_escape_string($option['optionlabel']));

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		

		//option items function

		function getoptionitems($startrecord, $limit, $orderby, $ordertype, $filter, $parentid) {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS optionitems.* FROM optionitems  WHERE optionitems.optionitemID != '' AND optionitems.optionparentID = ".$parentid." ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deleteoptionitem($optionitemid) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM optionitems WHERE optionitems.optionitemID = '%s'", $optionitemid);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updateoptionitem($optionitemid, $optionitem) {

			  //Create SQL Query

			  $sql = sprintf("Replace into optionitems(optionitemID, optionparentID, optionitemname, optionitemprice, optionorder, optionitemicon)

				values('".$optionitemid."', '%s', '%s', '%s', '%s', '%s')",

				mysql_real_escape_string($optionitem['optionparentID']),

				mysql_real_escape_string($optionitem['optionitemname']),

				mysql_real_escape_string($optionitem['optionitemprice']),

				mysql_real_escape_string($optionitem['optionorder']),

				mysql_real_escape_string($optionitem['optionitemicon']));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		}

		function addoptionitem($optionitem) {

			  //Create SQL Query

			  $sql = sprintf("Insert into optionitems(optionitemID, optionparentID, optionitemname, optionitemprice, optionorder, optionitemicon)

				values(Null,  '%s', '%s', '%s', '%s', '%s')",

				mysql_real_escape_string($optionitem['optionparentID']),

				mysql_real_escape_string($optionitem['optionitemname']),

				mysql_real_escape_string($optionitem['optionitemprice']),

				mysql_real_escape_string($optionitem['optionorder']),

				mysql_real_escape_string($optionitem['optionitemicon']));

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		

		//menulevel1 functions

		function getmenulevel1set($startrecord, $limit, $orderby, $ordertype, $filter) {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS menulevel1.* FROM menulevel1  WHERE menulevel1.keyfield != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deletemenulevel1($keyfield) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM menulevel1 WHERE menulevel1.keyfield = '%s'", $keyfield);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updatemenulevel1($keyfield, $menulevel1) {

			  //Create SQL Query

			  $sql = sprintf("Replace into menulevel1(keyfield, menuName, Clicks, menu1order)

				values('".$keyfield."', '%s', '%s', '%s')",

				mysql_real_escape_string($menulevel1['menuname']),

				mysql_real_escape_string($menulevel1['clicks']),

				mysql_real_escape_string($menulevel1['menu1order']));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		}

		function addmenulevel1($menulevel1) {

			  //Create SQL Query

			  $sql = sprintf("Insert into menulevel1(keyfield, menuName, Clicks, menu1order)

				values(Null, '%s', '%s', '%s')",

				mysql_real_escape_string($menulevel1['menuname']),

				mysql_real_escape_string($menulevel1['clicks']),

				mysql_real_escape_string($menulevel1['menu1order']));

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}



		//menulevel2 functions

		function getmenulevel2set($startrecord, $limit, $orderby, $ordertype, $filter, $menuparentid) {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS menulevel2.* FROM menulevel2  WHERE menulevel2.keyfield != '' AND menulevel2.menuParentID=".$menuparentid." ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deletemenulevel2($keyfield) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM menulevel2 WHERE menulevel2.keyfield = '%s'", $keyfield);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updatemenulevel2($keyfield, $menulevel2) {

			  //Create SQL Query

			  $sql = sprintf("Replace into menulevel2(keyfield, menuParentID, menuName, Clicks, menu2order)

				values('".$keyfield."', '%s', '%s', '%s', '%s')",

				mysql_real_escape_string($menulevel2['menuparentid']),

				mysql_real_escape_string($menulevel2['menuname']),

				mysql_real_escape_string($menulevel2['clicks']),

				mysql_real_escape_string($menulevel2['menu2order']));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		}

		function addmenulevel2($menulevel2) {

			  //Create SQL Query

			  $sql = sprintf("Insert into menulevel2(keyfield, menuParentID, menuName, Clicks, menu2order)

				values(Null, '%s', '%s', '%s', '%s')",

				mysql_real_escape_string($menulevel2['menuparentid']),

				mysql_real_escape_string($menulevel2['menuname']),

				mysql_real_escape_string($menulevel2['clicks']),

				mysql_real_escape_string($menulevel2['menu2order']));

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		

		//menulevel3 functions

		function getmenulevel3set($startrecord, $limit, $orderby, $ordertype, $filter, $menuparentid) {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS menulevel3.* FROM menulevel3  WHERE menulevel3.keyfield != '' AND menulevel3.menuParentID=".$menuparentid." ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deletemenulevel3($keyfield) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM menulevel3 WHERE menulevel3.keyfield = '%s'", $keyfield);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updatemenulevel3($keyfield, $menulevel3) {

			  //Create SQL Query

			  $sql = sprintf("Replace into menulevel3(keyfield, menuParentID, menuName, Clicks, menu3order)

				values('".$keyfield."', '%s', '%s', '%s', '%s')",

				mysql_real_escape_string($menulevel3['menuparentid']),

				mysql_real_escape_string($menulevel3['menuname']),

				mysql_real_escape_string($menulevel3['clicks']),

				mysql_real_escape_string($menulevel3['menu3order']));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		}

		function addmenulevel3($menulevel3) {

			  //Create SQL Query

			  $sql = sprintf("Insert into menulevel3(keyfield, menuParentID, menuName, Clicks, menu3order)

				values(Null,  '%s', '%s', '%s', '%s')",

				mysql_real_escape_string($menulevel3['menuparentid']),

				mysql_real_escape_string($menulevel3['menuname']),

				mysql_real_escape_string($menulevel3['clicks']),

				mysql_real_escape_string($menulevel3['menu3order']));

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

				

		//manufacturer functions

		function getmanufacturerset($startrecord, $limit, $orderby, $ordertype, $filter) {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS manufacturer.* FROM manufacturer  WHERE manufacturer.manufacturerID != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deletemanufacturer($manufacturerid) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM manufacturer WHERE manufacturer.manufacturerID = '%s'", $manufacturerid);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updatemanufacturer($manufacturerid, $manufacturer) {

			  //Create SQL Query

			  $sql = sprintf("Replace into manufacturer(manufacturerID, manufacturername, Clicks)

				values('".$manufacturerid."', '%s', '%s')",

				mysql_real_escape_string($manufacturer['manufacturername']),

				mysql_real_escape_string($manufacturer['clicks']));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		}

		function addmanufacturer($manufacturer) {

			  //Create SQL Query

			  $sql = sprintf("Insert into manufacturer(manufacturerID, manufacturername, Clicks)

				values(Null, '%s', '%s')",

				mysql_real_escape_string($manufacturer['manufacturername']),

				mysql_real_escape_string($manufacturer['clicks']));

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		

		//coupon functions

		function getcoupons($startrecord, $limit, $orderby, $ordertype, $filter) {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS promocodes.* FROM promocodes  WHERE promocodes.promoID != '' ".$filter." ORDER BY ".  $orderby ." ".  $ordertype . " LIMIT ".  $startrecord .", ".  $limit."");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deletecoupon($promocodesid) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM promocodes WHERE promocodes.promoID = '%s'", $promocodesid);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updatecoupon($promocodesid, $promocodes) {

			  //Create SQL Query

			  $sql = sprintf("Replace into promocodes(promoID, promodollar, dollarbased, promopercentage, percentagebased, promoshipping, shippingbased, promofreeitem, freeitembased,  promomessage, manufacturer, productname, bymanufacturer, byproductname, byallproducts)

				values('".$promocodesid."', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",

				mysql_real_escape_string($promocodes['dollaramount']),

				mysql_real_escape_string($promocodes['usedollar']),

				mysql_real_escape_string($promocodes['percentageamount']),

				mysql_real_escape_string($promocodes['usepercentage']),

				mysql_real_escape_string($promocodes['shippingamount']),

				mysql_real_escape_string($promocodes['useshipping']),

				mysql_real_escape_string('0.00'),

				mysql_real_escape_string($promocodes['usefreeitem']),

				mysql_real_escape_string($promocodes['promodescription']),

				mysql_real_escape_string($promocodes['manufacturers']),

				mysql_real_escape_string($promocodes['products']),

				mysql_real_escape_string($promocodes['attachmanufacturer']),

				mysql_real_escape_string($promocodes['attachproduct']),

				mysql_real_escape_string($promocodes['attachall']));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$sqlerror = mysql_error();

				$error = explode(" ", $sqlerror);

				if ($error[0] == "Duplicate") {

					$returnArray[] = "duplicate";

					return $returnArray; //return noresults if there are no results

			    } else {  

					$returnArray[] = "error";

					return mysql_error(); //return noresults if there are no results

				}

			}

		}

		function addcoupon($promocodes) {

			  //Create SQL Query

			  $sql = sprintf("Insert into promocodes(promoID, promodollar, dollarbased, promopercentage, percentagebased, promoshipping, shippingbased, promofreeitem, freeitembased,  promomessage, manufacturer, productname, bymanufacturer, byproductname, byallproducts)

				values('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",

				mysql_real_escape_string($promocodes['promoid']),

				mysql_real_escape_string($promocodes['dollaramount']),

				mysql_real_escape_string($promocodes['usedollar']),

				mysql_real_escape_string($promocodes['percentageamount']),

				mysql_real_escape_string($promocodes['usepercentage']),

				mysql_real_escape_string($promocodes['shippingamount']),

				mysql_real_escape_string($promocodes['useshipping']),

				mysql_real_escape_string('0.00'),

				mysql_real_escape_string($promocodes['usefreeitem']),

				mysql_real_escape_string($promocodes['promodescription']),

				mysql_real_escape_string($promocodes['manufacturers']),

				mysql_real_escape_string($promocodes['products']),

				mysql_real_escape_string($promocodes['attachmanufacturer']),

				mysql_real_escape_string($promocodes['attachproduct']),

				mysql_real_escape_string($promocodes['attachall']));

			//Run query on database;

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$sqlerror = mysql_error();

				$error = explode(" ", $sqlerror);

				if ($error[0] == "Duplicate") {

					$returnArray[] = "duplicate";

					return $returnArray; //return noresults if there are no results

			    } else {  

					$returnArray[] = mysql_error();

					return $returnArray; //return noresults if there are no results

				}

			}

		}



		//tax functions

		function gettaxes() {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS taxrate.* FROM taxrate  WHERE taxrate.taxID = 1");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updatetaxes($taxrates) {

			  //Create SQL Query

			  $sql = sprintf("Replace into taxrate(taxID, taxrate, taxstateID, taxcountryID, taxcountryrate, taxallrate, taxstateenable, taxallenable, taxcountryenable)

				values('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",

				mysql_real_escape_string($taxrates['taxid']),

				mysql_real_escape_string($taxrates['taxrate']),

				mysql_real_escape_string($taxrates['taxstateid']),

				mysql_real_escape_string($taxrates['taxcountryid']),

				mysql_real_escape_string($taxrates['taxcountryrate']),

				mysql_real_escape_string($taxrates['taxallrate']),

				mysql_real_escape_string($taxrates['taxstateenable']),

				mysql_real_escape_string($taxrates['taxallenable']),

				mysql_real_escape_string($taxrates['taxcountryenable']));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$sqlerror = mysql_error();

				$error = explode(" ", $sqlerror);

				if ($error[0] == "Duplicate") {

					$returnArray[] = "duplicate";

					return $returnArray; //return noresults if there are no results

			    } else {  

					$returnArray[] = "error";

					return $returnArray; //return noresults if there are no results

				}

			}

		}		

		

		//shipping functions

		function updateexpeditedrates($rate, $message) {

			  //Create SQL Query

			  $sql = sprintf("Replace into shippingratesexpedite(IDfield, expediteamount, expeditemessage)

				values(1, '%s', '%s')",

				mysql_real_escape_string($rate),

				mysql_real_escape_string($message));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$sqlerror = mysql_error();

				$error = explode(" ", $sqlerror);

				if ($error[0] == "Duplicate") {

					$returnArray[] = "duplicate";

					return $returnArray; //return noresults if there are no results

			    } else {  

					$returnArray[] = "error";

					return $returnArray; //return noresults if there are no results

				}

			}

		}

		function getweightshippingrates() {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS shippingweightrates.* FROM shippingweightrates ORDER BY shippingweightrates.triggerrate ASC");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function deleteshippingweightrate($keyfield) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM shippingweightrates WHERE shippingweightrates.keyfield = '%s'", $keyfield);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updateshippingweightrate($keyfield, $rate) {

			  //Create SQL Query

			  $sql = sprintf("Replace into shippingweightrates(keyfield, triggerrate, shippingrate)

				values('".$keyfield."', '%s', '%s')",

				mysql_real_escape_string($rate['triggerrate']),

				mysql_real_escape_string($rate['shippingrate']));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$sqlerror = mysql_error();

				$error = explode(" ", $sqlerror);

				if ($error[0] == "Duplicate") {

					$returnArray[] = "duplicate";

					return $returnArray; //return noresults if there are no results

			    } else {  

					$returnArray[] = "error";

					return $returnArray; //return noresults if there are no results

				}

			}

		}

		function addshippingweightrate($rate) {

			  //Create SQL Query

			  $sql = sprintf("Insert into shippingweightrates(keyfield, triggerrate, shippingrate)

				values(null, '%s', '%s')",

				mysql_real_escape_string($rate['triggerrate']),

				mysql_real_escape_string($rate['shippingrate']));

			//Run query on database;

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$sqlerror = mysql_error();

				$error = explode(" ", $sqlerror);

				if ($error[0] == "Duplicate") {

					$returnArray[] = "duplicate";

					return $returnArray; //return noresults if there are no results

			    } else {  

					$returnArray[] = mysql_error();

					return $returnArray; //return noresults if there are no results

				}

			}

		}

		function getpriceshippingrates() {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS shippingrates.* FROM shippingrates ORDER BY shippingrates.triggerrate ASC");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		

		function deleteshippingpricerate($keyfield) {

			  //Create SQL Query	

			  $deletesql = $this->escape("DELETE FROM shippingrates WHERE shippingrates.keyfield = '%s'", $keyfield);

			  //Run query on database;

			  mysql_query($deletesql);

			  

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				  $returnArray[] ="success";

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "error";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updateshippingpricerate($keyfield, $rate) {

			  //Create SQL Query

			  $sql = sprintf("Replace into shippingrates(keyfield, triggerrate, shippingrate)

				values('".$keyfield."', '%s', '%s')",

				mysql_real_escape_string($rate['triggerrate']),

				mysql_real_escape_string($rate['shippingrate']));

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$sqlerror = mysql_error();

				$error = explode(" ", $sqlerror);

				if ($error[0] == "Duplicate") {

					$returnArray[] = "duplicate";

					return $returnArray; //return noresults if there are no results

			    } else {  

					$returnArray[] = "error";

					return $returnArray; //return noresults if there are no results

				}

			}

		}

		function addshippingpricerate($rate) {

			  //Create SQL Query

			  $sql = sprintf("Insert into shippingrates(keyfield, triggerrate, shippingrate)

				values(null, '%s', '%s')",

				mysql_real_escape_string($rate['triggerrate']),

				mysql_real_escape_string($rate['shippingrate']));

			//Run query on database;

			  mysql_query($sql);

			  //if no errors, return their current Client ID

			  //if results, convert to an array for use in flash

			  if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$sqlerror = mysql_error();

				$error = explode(" ", $sqlerror);

				if ($error[0] == "Duplicate") {

					$returnArray[] = "duplicate";

					return $returnArray; //return noresults if there are no results

			    } else {  

					$returnArray[] = mysql_error();

					return $returnArray; //return noresults if there are no results

				}

			}

		}

		function getshippingsettings() {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS settings.shippinguseweighttriggers, settings.shippingusetriggers, settings.shippingusedynamic, settings.shippingdynamicuserid, settings.shippingdynamicziporigin, shippingratesexpedite.expediteamount, shippingratesexpedite.expeditemessage FROM settings, shippingratesexpedite  WHERE settings.settingID = 1 AND shippingratesexpedite.IDfield = 1");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updateshippingsettings($useweighttriggers, $usepricetriggers, $usedynamics, $dynamicziporigin, $dynamicuserid) {

			  //Create SQL Query

			  $sql = $this->escape("UPDATE settings SET shippinguseweighttriggers='%s',  shippingusetriggers='%s', shippingusedynamic='%s', shippingdynamicuserid='%s', shippingdynamicziporigin='%s' WHERE settings.settingID = 1", $useweighttriggers, $usepricetriggers, $usedynamics,  $dynamicuserid, $dynamicziporigin);

			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$sqlerror = mysql_error();

				$error = explode(" ", $sqlerror);

				if ($error[0] == "Duplicate") {

					$returnArray[] = "duplicate";

					return $returnArray; //return noresults if there are no results

			    } else {  

					$returnArray[] = "error";

					return $returnArray; //return noresults if there are no results

				}

			}

		}				

		

		//database  functions

		function restoredb($dbfilename) {

			// Get file data

			$data = file("../../products/".$dbfilename);

			//echo $data;

			// Temporary variable, used to store current query

			$templine = '';

			// Read in entire file

			$lines = $data;

			// Loop through each line

			foreach ($lines as $line_num => $line) {

			  // Only continue if it's not a comment

			  if (substr($line, 0, 2) != '/*' && $line != '') {

				// Add this line to the current segment

				$templine .= $line;

				

				// If it has a semicolon at the end, it's the end of the query

				if (substr(trim($line), -1, 1) == ';') {

				   // Perform the query

				    mysql_query($templine); 

					 // Reset temp variable to empty

				  $templine = '';

				}

			  }

			}

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

					  

		}

		

		function deletedbfile($dbfilename) {

			if (unlink("../../products/".$dbfilename)) {

				return "success";

			} else {

				return "error";

			}

		}

		

		function logdbrestore() {

			//insert into db backup log an entry

			//Create SQL Query

			$sql = sprintf("INSERT INTO dblog(logentrydate, logentrytype) values(NOW(), 'restore')");

			//Run query on database;

			mysql_query($sql);

		}

		function logdbbackup() {

			//insert into db backup log an entry

			//Create SQL Query

			$sql = sprintf("INSERT INTO dblog(logentrydate, logentrytype) values(NOW(), 'backup')");

			//Run query on database;

			mysql_query($sql);

		}

		

		//site settings functions

		function getsitesettings() {

			  //Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS settings.* FROM settings  WHERE settings.settingID = 1");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updatesitesettings($settings) {

			  //Create SQL Query

			  $sql = sprintf("UPDATE settings SET siteURL='%s', regcode='%s', quantitytracking='%s', coupontracking='%s', adminemail='%s', orderfromemail='%s', passwordrecoveryemail='%s', useauthorize='%s', authorizeloginid='%s', authorizetrankey='%s', authorizetestmode='%s', authorizedeveloperaccount='%s', usepaypal='%s', usepaypalflash='%s', usepaypalsandbox='%s', paypalemail='%s', paypalcurcode='%s', paypallc='%s', usechronopay='%s', chronosharedsecret='%s', chronoproductid='%s', chronocurrency='%s', useversapay='%s', versapayID='%s', versapayPassword='%s', useeway='%s', ewaytestmode='%s', ewaycustid='%s', usepaypoint='%s', paypointtestmode='%s', paypointmerchantid='%s', paypointvpnpassword='%s',  usefirstdata='%s', firstdataloginid='%s', firstdatatestmode='%s', paymentexpressusername='%s', paymentexpresspassword='%s', paymentexpresscurrency='%s', usepaymentexpress='%s',ccvisa='%s', ccmastercard='%s', ccdiscover='%s', ccamex='%s', ccdiners='%s', ccjbc='%s', enabledownloads='%s', maxdownloads='%s', maxdownloadtime='%s', usestate='%s', usecountry='%s', currencySymbol='%s'  WHERE settings.settingID = 1",

				mysql_real_escape_string($settings['siteURL']),

				mysql_real_escape_string($settings['regcode']),

				mysql_real_escape_string($settings['quantitytracking']),

				mysql_real_escape_string($settings['coupontracking']),

				mysql_real_escape_string($settings['adminemail']),

				mysql_real_escape_string($settings['orderfromemail']),

				mysql_real_escape_string($settings['passwordrecoveryemail']),

				mysql_real_escape_string($settings['useauthorize']),

				mysql_real_escape_string($settings['authorizeloginid']),

				mysql_real_escape_string($settings['authorizetrankey']),

				mysql_real_escape_string($settings['authorizetestmode']),

				mysql_real_escape_string($settings['authorizedeveloperaccount']),

				mysql_real_escape_string($settings['usepaypal']),

				mysql_real_escape_string($settings['usepaypalflash']),

				mysql_real_escape_string($settings['usepaypalsandbox']),

				mysql_real_escape_string($settings['paypalemail']),

				mysql_real_escape_string($settings['paypalcurcode']),

				mysql_real_escape_string($settings['paypallc']),

				mysql_real_escape_string($settings['usechronopay']),

				mysql_real_escape_string($settings['chronosharedsecret']),

				mysql_real_escape_string($settings['chronoproductid']),

				mysql_real_escape_string($settings['chronocurrency']),

				mysql_real_escape_string($settings['useversapay']),

				mysql_real_escape_string($settings['versapayID']),

				mysql_real_escape_string($settings['versapayPassword']),

				mysql_real_escape_string($settings['useeway']),

				mysql_real_escape_string($settings['ewaytestmode']),

				mysql_real_escape_string($settings['ewaycustid']),

				mysql_real_escape_string($settings['usepaypoint']),

				mysql_real_escape_string($settings['paypointtestmode']),

				mysql_real_escape_string($settings['paypointmerchantid']),

				mysql_real_escape_string($settings['paypointvpnpassword']),

				mysql_real_escape_string($settings['usefirstdata']),

				mysql_real_escape_string($settings['firstdataloginid']),

				mysql_real_escape_string($settings['firstdatatestmode']),

				mysql_real_escape_string($settings['paymentexpressusername']),

				mysql_real_escape_string($settings['paymentexpresspassword']),

				mysql_real_escape_string($settings['paymentexpresscurrency']),

				mysql_real_escape_string($settings['usepaymentexpress']),

				mysql_real_escape_string($settings['ccvisa']),

				mysql_real_escape_string($settings['ccmastercard']),

				mysql_real_escape_string($settings['ccdiscover']),

				mysql_real_escape_string($settings['ccamex']),

				mysql_real_escape_string($settings['ccdiners']),

				mysql_real_escape_string($settings['ccjbc']),

				mysql_real_escape_string($settings['enabledownloads']),

				mysql_real_escape_string($settings['maxdownloads']),

				mysql_real_escape_string($settings['maxdownloadtime']),

				mysql_real_escape_string($settings['usestate']),

				mysql_real_escape_string($settings['usecountry']),

				mysql_real_escape_string($settings['currencySymbol']));

				



  



			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$sqlerror = mysql_error();

				$error = explode(" ", $sqlerror);

				if ($error[0] == "Duplicate") {

					$returnArray[] = "duplicate";

					return $returnArray; //return noresults if there are no results

			    } else {  

					$returnArray[] = "error";

					return $returnArray; //return noresults if there are no results

				}

			}

		}		

		function clearmenustatistics() {

			//Create SQL Query

			$sql = sprintf("UPDATE menulevel1, menulevel2, menulevel3 SET menulevel1.Clicks = 0, menulevel2.Clicks = 0, menulevel3.Clicks = 0");



			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		}	

		function clearproductstatistics() {

			//Create SQL Query

			$sql = sprintf("DELETE FROM statistics");



			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$returnArray[] = "error";

				return $returnArray; //return noresults if there are no results

			}

		}	

		





		//page content functions

		function getpagecontent() {

				//Create SQL Query

			  $query= mysql_query("SELECT SQL_CALC_FOUND_ROWS company.* FROM company  WHERE company.companyID = 1");

			  $totalquery=mysql_query("SELECT FOUND_ROWS()");

			  $totalrows = mysql_fetch_object($totalquery);

			  

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($query) > 0) {

				  while ($row=mysql_fetch_object($query)) {

					  $row->totalrows=$totalrows;

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}

		function updatepagecontent($content) {

			  //Create SQL Query

			  $sql = sprintf("UPDATE company SET description='%s', services='%s', businessname='%s', contactname='%s', contactaddress='%s', contactcity='%s', contactstate='%s', contactzip='%s', contactphone='%s', contactfax='%s', contactinfo='%s', contactemail='%s', aboutus='%s', terms='%s', privacypolicy='%s', homekeywords='%s', homeshortdescription='%s' WHERE company.companyID = 1",

				mysql_real_escape_string($content['homedescription']),

				mysql_real_escape_string($content['services']),

				mysql_real_escape_string($content['businessname']),

				mysql_real_escape_string($content['contactname']),

				mysql_real_escape_string($content['contactaddress']),

				mysql_real_escape_string($content['contactcity']),

				mysql_real_escape_string($content['contactstate']),

				mysql_real_escape_string($content['contactzip']),

				mysql_real_escape_string($content['contactphone']),

				mysql_real_escape_string($content['contactfax']),

				mysql_real_escape_string($content['contactinfo']),

				mysql_real_escape_string($content['contactemail']),

				mysql_real_escape_string($content['aboutus']),

				mysql_real_escape_string($content['terms']),

				mysql_real_escape_string($content['privacypolicy']),

				mysql_real_escape_string($content['homekeywords']),

				mysql_real_escape_string($content['homeshortdescription']));

				



			//Run query on database;

			mysql_query($sql);

			//if no errors, return their current Client ID

			//if results, convert to an array for use in flash

			if(!mysql_error()) {

				$returnArray[] ="success";

				return($returnArray); //return array results if there are some

			} else {

				$sqlerror = mysql_error();

				$error = explode(" ", $sqlerror);

				if ($error[0] == "Duplicate") {

					$returnArray[] = "duplicate";

					return $returnArray; //return noresults if there are no results

			    } else {  

					$returnArray[] = mysql_error();

					return $returnArray; //return noresults if there are no results

				}

			}

		}		



		//mail functions functions

		function mailnewsletter($sendtype, $fromemail, $subject, $themessage, $smtphost, $smptport, $smtpusername, $smtppassword) {

			//Create SQL Query

			$subquery = mysql_query("SELECT subscribers.* FROM subscribers");

			//get settings for email handling information

			$settingsquery= mysql_query("Select * from settings where settingID = '1'");

			$settings = mysql_fetch_array($settingsquery);

			$sentnum = 0;

			$mailresult = "error";

			$error = "";

			while($subscribers = mysql_fetch_array($subquery)){

				

				//build the message here

				$text = "This message is in HTML and requires an html viewer, please switch to that view.";

				$phpmailmessage = "--==MIME_BOUNDRY_alt_main_message\n";

				$phpmailmessage .= "Content-Type: text/plain; charset=ISO-8859-1\n";

				$phpmailmessage .= "Content-Transfer-Encoding: 7bit\n\n";

				$phpmailmessage .= $text . "\n\n";

				$phpmailmessage .= "--==MIME_BOUNDRY_alt_main_message\n";

				$phpmailmessage .= "Content-Type: text/html; charset=ISO-8859-1\n";

				$phpmailmessage .= "Content-Transfer-Encoding: 7bit\n\n";

				//add the main message the user types in

				$phpmailmessage .= $themessage;

				//now add the unsubscribe portion

				$unsubscribemessage = "<br><br><br><br><center style='font-family: Arial, Helvetica, sans-serif; font-size: 9px;'>----------------------------------------------------------------------<br>Please click on the link below and you will be removed from this list.<br><a href=http://$settings[siteURL]/scripts/administration/unsubscribe.php?email=$subscribers[email] style='color: #000; font-weight: bold; font-size: 10px;'>UNSUBSCRIBE</a><br>----------------------------------------------------------------------</center>";

				

				$message = $phpmailmessage . $unsubscribemessage;

				

				if ($sendtype == 'phpmail') {

					//headers

					$headers = "From: $fromemail\r\n";

					$headers .= "Reply-To: $fromemail\r\n";

					$headers .= "X-Mailer: PHP4\n";

					$headers .= "X-Priority: 3\n";

					$headers .= "MIME-Version: 1.0\n";

					$headers .= "Return-Path: $fromemail\r\n"; 

					$headers .= "Content-Type: multipart/alternative; boundary=\"==MIME_BOUNDRY_alt_main_message\"\n\n";

					//mail individual newsletter

					$mailresult = mail($subscribers[email], $subject, $message, $headers);

					if ($mailresult === true) {

						//do nothing

					}

					else {

						$error =  "There was a problem sending your newsletter.  PHP Mail may not be allowed from your server, so please check with your host.";

					}

					//send mail using php mail

				} else if ($sendtype == 'smtpmail') {

					

					//headers

					$headers["From"] = $fromemail;

					$headers["To"] = $subscribers[email];

					$headers["Subject"] = $subject;

					//mime email settings

					$crlf = "\n"; 

					$mime = new Mail_mime($crlf); 

					$mime->setTXTBody($text); 

					$mime->setHTMLBody($themessage . $unsubscribemessage); 



					$mimemessage = $mime->get(); 

					$headers = $mime->headers($headers); 



					//smtp information

					$smtpinfo["host"] = $smtphost;

					$smtpinfo["port"] = $smtpport;

					$smtpinfo["auth"] = true;

					$smtpinfo["username"] = $smtpusername;

					$smtpinfo["password"] = $smtppassword;

					//create mail object

					$mail_object =& Mail::factory("smtp", $smtpinfo);

					//mail individual newsletter

				

					$mailresult = $mail_object->send($subscribers[email], $headers, $mimemessage);	

					if ($mailresult === true) {

						//do nothing

					}

					else {

						preg_match('/(\d+)/', $mailresult->getMessage(), $match);

						$error =  "There was a problem sending your newsletter. \n\nError Code: $match[0]\n" .

							"Message: {$mailresult->getMessage()}\n";

					}



				}

				$sentnum += 1;

			}

			if ($mailresult == 1 && $error == "") {

				return "success";

			} else {

				if ($error == "") {

					return "There was a general problem sending your newsletter.  Please try an alternative method for sending your newsletter and/or check with your host for settings and whether they allow email newsletter blasts to be sent from your hosting environment.";

				} else {

					return $error;

				}

			}

		}

		//country list functions
		//get countries is handled above
		function updatecountry($id, $name, $iso2, $iso3, $sortorder) {
			//Create SQL Query
			  $sql = $this->escape("UPDATE countries SET  name_cnt='%s', iso2_cnt='%s', iso3_cnt='%s', sortorder='%s' WHERE countries.id_cnt = '%s'", $name, $iso2, $iso3, $sortorder, $id);

			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}	
		function deletecountry($id) {
			//Create SQL Query
			$sql = sprintf("DELETE FROM countries WHERE countries.id_cnt = $id");

			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}	
		function addcountry($name, $iso2, $iso3, $sortorder) {
			//Create SQL Query
			  $sql = sprintf("Insert into countries(id_cnt, name_cnt, iso2_cnt, iso3_cnt, sortorder)
				values(null, '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($name),
				mysql_real_escape_string($iso2),
				mysql_real_escape_string($iso3),
				mysql_real_escape_string($sortorder));

			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}	
		
		
		//state list functions
		//get state list is handled above

		function updatestate($id, $countryid, $iso2, $name, $sortorder) {
			//Create SQL Query
			  $sql = $this->escape("UPDATE states SET  name_sta='%s', code_sta='%s', idcnt_sta='%s', sortorder='%s' WHERE states.id_sta = '%s'", $name, $iso2, $countryid, $sortorder,  $id);

			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}	
		function deletestate($id) {
			//Create SQL Query
			$sql = sprintf("DELETE FROM states WHERE states.id_sta = $id");

			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}	
		function addstate($countryid, $iso2, $name, $sortorder) {
			//Create SQL Query
			  $sql = sprintf("Insert into states(id_sta, name_sta, code_sta, idcnt_sta, sortorder)
				values(null, '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($name),
				mysql_real_escape_string($iso2),
				mysql_real_escape_string($countryid),
				mysql_real_escape_string($sortorder));

			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}
		
		//////////////////////////
		//per page functions
		//////////////////////////
		function getperpage() {

			//Create SQL Query
			$sql = "SELECT * FROM perpage ORDER BY perpage ASC";
			
			$result = mysql_query($sql);

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($result) > 0) {

				  while ($row=mysql_fetch_object($result)) {

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}
		
		function updateperpage($id, $perpage) {
			//Create SQL Query
			  $sql = $this->escape("UPDATE perpage SET perpage='%s' WHERE perpageid = '%s'", $perpage, $id);

			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}	
		function deleteperpage($id) {
			//Create SQL Query
			$sql = $this->escape("DELETE FROM perpage WHERE perpageid = %s", $id);

			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}	
		function addperpage($perpage) {
			//Create SQL Query
			$sql = sprintf("Insert into perpage(perpageid, perpage)
				values(null, '%s')",
				mysql_real_escape_string($perpage));

			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}
		
		//////END PER PAGE/////
		
		
		//////////////////////////
		//price point functions
		//////////////////////////
		function getpricepoints() {

			//Create SQL Query
			$sql = "SELECT * FROM pricepoints ORDER BY pricepointorder ASC";
			
			$result = mysql_query($sql);

			  //if results, convert to an array for use in flash

			  if(mysql_num_rows($result) > 0) {

				  while ($row=mysql_fetch_object($result)) {

					  $returnArray[] = $row;

				  }

				  return($returnArray); //return array results if there are some

			  } else {

				  $returnArray[] = "noresults";

				  return $returnArray; //return noresults if there are no results

			  }

		}
		
		function updatepricepoint($id, $pricepoint) {
			//Create SQL Query
			  $sql = $this->escape("UPDATE pricepoints SET lessthan = '%s', greaterthan = '%s', lowpoint = '%s', highpoint = '%s', pricepointorder = '%s' WHERE pricepointID = '%s'", $pricepoint['lessthan'], $pricepoint['greaterthan'], $pricepoint['lowpoint'], $pricepoint['highpoint'], $pricepoint['pricepointorder'], $id);

			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}	
		function deletepricepoint($id) {
			//Create SQL Query
			$sql = $this->escape("DELETE FROM pricepoints WHERE pricepointID = %s", $id);

			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}	
		function addpricepoint($pricepoint) {
			//Create SQL Query
			$sql = sprintf("Insert into pricepoints(pricepointiD, lessthan, greaterthan, lowpoint, highpoint, pricepointorder)
				values(null, '%s', '%s', '%s', '%s', '%s')",
				mysql_real_escape_string($pricepoint['lessthan']),
				mysql_real_escape_string($pricepoint['greaterthan']),
				mysql_real_escape_string($pricepoint['lowpoint']),
				mysql_real_escape_string($pricepoint['highpoint']),
				mysql_real_escape_string($pricepoint['pricepointorder']));

			//Run query on database;
			mysql_query($sql);
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			} else {
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			}
		}
		
		//////END PRICE POINTS/////
		
		function getproductoptionitems($optionnum){
			$sql = sprintf("SELECT optionitems.*, options.optionName FROM optionitems, options WHERE optionitems.optionparentID = '%s' AND options.optionID = optionitems.optionparentID", mysql_real_escape_string($optionnum));
			// Run query on database

			$result = mysql_query($sql);
			
			//if results, convert to an array for use in flash
			
			if(mysql_num_rows($result) > 0) {
			
			  while ($row=mysql_fetch_object($result)) {
			
				  $returnArray[] = $row;
			
			  }
			
			  return($returnArray); //return array results if there are some
			
			} else {
			
			  $returnArray[] = "noresults";
			
			  return $returnArray; //return noresults if there are no results
			
			}
		}
		
		function getproductimages($ProductID, $OptionItemID){
			$sql = sprintf("SELECT * FROM optionitemimages WHERE productID = '%s' AND optionitemID = '%s'", mysql_real_escape_string($ProductID), mysql_real_escape_string($OptionItemID));
			// Run query on database

			$result = mysql_query($sql);
			
			//if results, convert to an array for use in flash
			
			if(mysql_num_rows($result) > 0) {
			
			  while ($row=mysql_fetch_object($result)) {
			
				  $returnArray[] = $row;
			
			  }
			
			  return($returnArray); //return array results if there are some
			
			} else {
			
			  $returnArray[] = "noresults";
			
			  return $returnArray; //return noresults if there are no results
			
			}
		}
		
		function getoptionitemquantities($productid, $option1, $option2, $option3, $option4, $option5){
			$sql = "";
			if($option1 != 0){
				$sql .= sprintf("
					SELECT * FROM (
						SELECT 
							optionitemname AS optname1,
    						optionitemID as optid1
						FROM optionitems
						WHERE optionparentID = %s
					) as optionitems1 ", mysql_real_escape_string($option1));
			}
			
			if($option2 != 0){
				$sql .= sprintf("
					JOIN (
						SELECT 
							optionitemname AS optname2,
    						optionitemID as optid2
						FROM optionitems
						WHERE optionparentID = %s
					) as optionitems2 ON (1=1) ", mysql_real_escape_string($option2));
			}
			
			if($option3 != 0){
				$sql .= sprintf("
					JOIN (
						SELECT 
							optionitemname AS optname3,
    						optionitemID as optid3
						FROM optionitems
						WHERE optionparentID = %s
					) as optionitems3 ON (1=1) ", mysql_real_escape_string($option3));
			}
			
			if($option4 != 0){
				$sql .= sprintf("
					JOIN (
						SELECT 
							optionitemname AS optname4,
    						optionitemID as optid4
						FROM optionitems
						WHERE optionparentID = %s
					) as optionitems4 ON (1=1) ", mysql_real_escape_string($option4));
			}
			
			if($option5 != 0){
				$sql .= sprintf("
					JOIN (
						SELECT 
							optionitemname AS optname5,
    						optionitemID as optid5
						FROM optionitems
						WHERE optionparentID = %s
					) as optionitems5 ON (1=1) ", mysql_real_escape_string($option5));
			}
			
			$sql .= "LEFT JOIN optionitemquantity ON (1=1";
			
			if($option1 != 0){
				$sql .= " AND OptionItemID1 = optid1";
			}
			
			if($option2 != 0){
				$sql .= " AND OptionItemID2 = optid2";
			}
			
			if($option3 != 0){
				$sql .= " AND OptionItemID3 = optid3";
			}
			
			if($option4 != 0){
				$sql .= " AND OptionItemID4 = optid4";
			}
			
			if($option5 != 0){
				$sql .= " AND OptionItemID5 = optid5";
			}
			
			$sql .= sprintf(" AND ProductID = %s)", mysql_real_escape_string($productid));
			
			$sql .= " ORDER BY optname1";
			
			NetDebug::trace($sql);
			
			$result = mysql_query($sql);
			
			//if results, convert to an array for use in flash
			
			if(mysql_num_rows($result) > 0) {
			
			  while ($row=mysql_fetch_object($result)) {
			
				  $returnArray[] = $row;
			
			  }
			
			  return($returnArray); //return array results if there are some
			
			} else {
			
			  $returnArray[] = "noresults";
			
			  return $returnArray; //return noresults if there are no results
			
			}
			
		}
		
		function saveoptionitemquantities($optionitems){
			$numitems = count($optionitems);
			
			for($i=0;$i<$numitems;$i++){
			
				if($optionitems[$i]['optionitemquantityid']){
				
					$sql = sprintf("UPDATE optionitemquantity SET OptionItemID1 = '%s', OptionItemID2 = '%s', OptionItemID3 = '%s', OptionItemID4 = '%s', OptionItemID5 = '%s', ProductID = '%s', Quantity = '%s' WHERE OptionItemQuantityID = '%s'", $optionitems[$i]['optid1'], $optionitems[$i]['optid2'], $optionitems[$i]['optid3'], $optionitems[$i]['optid4'], $optionitems[$i]['optid5'], $optionitems[$i]['productid'], $optionitems[$i]['quantity'], $optionitems[$i]['optionitemquantityid']);
					
				}else{
					$sql = sprintf("INSERT INTO optionitemquantity(OptionItemID1, OptionItemID2, OptionItemID3, OptionItemID4, OptionItemID5, ProductID, Quantity) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')", $optionitems[$i]['optid1'], $optionitems[$i]['optid2'], $optionitems[$i]['optid3'], $optionitems[$i]['optid4'], $optionitems[$i]['optid5'], $optionitems[$i]['productid'], $optionitems[$i]['quantity']); 
				}
						
				NetDebug::trace($sql);
				//Run query on database;
				mysql_query($sql);
				
			}
			
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {			
				$returnArray[] = "success";
				return($returnArray); //return array results if there are some
			} else {
			
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			
			}
						
		}
		
		function removeAllOptionItemQuantities($productid){
			
			$sql = 	sprintf("DELETE FROM optionitemquantity WHERE ProductID = %s", mysql_real_escape_string($productid));
			
			NetDebug::trace($sql);
			
			//Run query on database;
			mysql_query($sql);
			
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			
			} else {
			
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			
			}
		
		}
		
		function updateOptionValues($productid, $option1, $option2, $option3, $option4, $option5){
			
			$sql = sprintf("UPDATE products SET option1 = '%s', option2 = '%s' ,option3 = '%s', option4 = '%s', option5 = '%s' WHERE ProductID = '%s'", mysql_real_escape_string($option1), mysql_real_escape_string($option2), mysql_real_escape_string($option3), mysql_real_escape_string($option4), mysql_real_escape_string($option5), mysql_real_escape_string($productid));
			
			NetDebug::trace($sql);
			
			//Run query on database;
			mysql_query($sql);
			
			//if no errors, return their current Client ID
			//if results, convert to an array for use in flash
			if(!mysql_error()) {
				
				$returnArray[] ="success";
				return($returnArray); //return array results if there are some
			
			} else {
			
				$returnArray[] = "error";
				return $returnArray; //return noresults if there are no results
			
			}
			
		}

	}//close class

?>