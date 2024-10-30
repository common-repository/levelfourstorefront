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

if ((isset($_GET['email'])) && ($_GET['email'] != "")) {

  $deleteSQL = sprintf("DELETE FROM subscribers WHERE subscribers.email = '%s'", mysql_real_escape_string($_GET['email']));

  mysql_select_db($database_flashdb, $flashdb);

  $Result1 = mysql_query($deleteSQL, $flashdb) or die(mysql_error());

  $deleteGoTo = "successfullydeleted.php";

  if (isset($_SERVER['QUERY_STRING'])) {

    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";

    $deleteGoTo .= $_SERVER['QUERY_STRING'];

  }

  header(sprintf("Location: %s", $deleteGoTo));

}

?>