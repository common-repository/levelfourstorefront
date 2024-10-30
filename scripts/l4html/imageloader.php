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

require_once('../../Connections/flashdb.php');

if (!function_exists("GetSQLValueString")) {

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 

{

  if (PHP_VERSION < 6) {

    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  }



  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);



  switch ($theType) {

    case "text":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;    

    case "long":

    case "int":

      $theValue = ($theValue != "") ? intval($theValue) : "NULL";

      break;

    case "double":

      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";

      break;

    case "date":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;

    case "defined":

      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;

      break;

  }

  return $theValue;

}

}



$colname_imageRS = "-1";

if (isset($_GET['productid'])) {

  $colname_imageRS = (get_magic_quotes_gpc()) ? $_GET['productid'] : addslashes($_GET['productid']);

}

mysql_select_db($database_flashdb, $flashdb);

$query_imageRS = sprintf("SELECT ProductID, Image1, Image2, Image3, Image4, Image5 FROM products WHERE ProductID = %s", GetSQLValueString($colname_imageRS, "int"));

$imageRS = mysql_query($query_imageRS, $flashdb) or die(mysql_error());

$row_imageRS = mysql_fetch_assoc($imageRS);

$totalRows_imageRS = mysql_num_rows($imageRS);

?>



<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Untitled Document</title>

<style type="text/css">

body {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

}

</style>

</head>



<body>

<?php if($_GET['imagelocation'] == 1) { ?>

<img src="products/pics1/<?php echo $row_imageRS['Image1']; ?>" width="200" alt="Product Details" class="product_details_image" />

<?php } ?>

<?php if($_GET['imagelocation'] == 2) { ?>

<img src="products/pics2/<?php echo $row_imageRS['Image2']; ?>" alt="Product Details" class="product_details_image" />

<?php } ?>

<?php if($_GET['imagelocation'] == 3) { ?>

<img src="products/pics3/<?php echo $row_imageRS['Image3']; ?>" alt="Product Details" class="product_details_image" />

<?php } ?>

<?php if($_GET['imagelocation'] == 4) { ?>

<img src="products/pics4/<?php echo $row_imageRS['Image4']; ?>" alt="Product Details" class="product_details_image" />

<?php } ?>

<?php if($_GET['imagelocation'] == 5) { ?>

<img src="products/pics5/<?php echo $row_imageRS['Image5']; ?>" alt="Product Details" class="product_details_image" />

<?php } ?>





</body>

</html>

<?php

mysql_free_result($imageRS);

?>