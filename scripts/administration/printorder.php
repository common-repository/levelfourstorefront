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

if (!function_exists("GetSQLValueString")) {

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 

{

  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;



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

      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";

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



$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);

}



$KTColParam1_orderdetails = "-1";

if (isset($_GET["OrderID"])) {

  $KTColParam1_orderdetails = (get_magic_quotes_gpc()) ? $_GET["OrderID"] : addslashes($_GET["OrderID"]);

}

mysql_select_db($database_flashdb, $flashdb);

$query_orderdetails = sprintf("SELECT details.*, orders.* FROM (orders LEFT JOIN details ON details.OrderID=orders.OrderID) WHERE orders.OrderID=%s ORDER BY details.ProductID", GetSQLValueString($KTColParam1_orderdetails, "int"));

$orderdetails = mysql_query($query_orderdetails, $flashdb) or die(mysql_error());

$row_orderdetails = mysql_fetch_assoc($orderdetails);

$totalRows_orderdetails = mysql_num_rows($orderdetails);



mysql_select_db($database_flashdb, $flashdb);

$query_rsorderstatus = "SELECT * FROM orderstatus";

$rsorderstatus = mysql_query($query_rsorderstatus, $flashdb) or die(mysql_error());

$row_rsorderstatus = mysql_fetch_assoc($rsorderstatus);

$totalRows_rsorderstatus = mysql_num_rows($rsorderstatus);



mysql_select_db($database_flashdb, $flashdb);

$query_settingsRS = "SELECT * FROM settings";

$settingsRS = mysql_query($query_settingsRS, $flashdb) or die(mysql_error());

$row_settingsRS = mysql_fetch_assoc($settingsRS);

$totalRows_settingsRS = mysql_num_rows($settingsRS);



$requestID = "-1";

if (isset($_GET['reqID'])) {

  $requestID = $_GET['reqID'];

}



$usersqlquery = sprintf("select * from clients WHERE clients.Password = '%s' AND clients.UserLevel = 'admin' ORDER BY Email ASC", mysql_real_escape_string($requestID));

mysql_select_db($database_flashdb, $flashdb);

$userresult = mysql_query($usersqlquery, $flashdb) or die(mysql_error());

$users = mysql_fetch_assoc($userresult);



if ($users) {

?>



<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<title>Print Order</title>

<style type="text/css">

<!--

.style1 {font-weight: bold}

.style2 {

	color: #FF0000;

	font-weight: bold;

}

.style3 {color: #FF0000}

.fontstyle {

	font-family: Arial, Helvetica, sans-serif;

	font-weight: normal;

}

.sizesmallfont {

	font-size: 11px;

}

.sizemediumfont {

	font-size: 14px;

}

-->

</style>

</head>

<body>







<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">

<tr class="fontstyle">

                  <td width="442" height="25" bgcolor="#CCCCCC" class="tableheadingbg">                 <div align="left">

<input name="Print Order" type="submit" class="buttontext" id="Print Order" value="Print Order" onClick="window.print()">

</div> </td>

<td width="140" bgcolor="#CCCCCC" class="tableheadingbg" style="font-weight: bold"><div align="right" class="sizemediumfont">Order Status:</div></td>

<td width="218" align="right" bgcolor="#CCCCCC" class="sizemediumfont" style="font-weight: bold"><?php echo utf8_decode($row_orderdetails['OrderStatus']); ?>&nbsp;&nbsp;</td>

  </tr>

                <tr>

                <td height="119" colspan="3"><span class="fontstyle"><!-- address billing/shipping information -->

                    </span>

                    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">

                        

                      <tr>

                        <td width="400" class="style1"><div align="left"><span class="sizemediumfont"><span class="fontstyle"><strong>&nbsp;Shipping Information </strong></span></span></div></td>

                        <td width="400" class="style1"><div align="left"><span class="sizemediumfont"><span class="fontstyle"><strong>Billing Information </strong></span></span></div></td>

                      </tr>

                      <?php 

// Show IF Conditional region8 

if (@$row_orderdetails['BillAddress'] == "" && @$row_orderdetails['BillCity'] == ""&& @$row_orderdetails['BillZip'] == "") {

?>



<tr>

	<td colspan="2">&nbsp;</td>

  </tr>



                      <?php 

// else Conditional region8

} else { ?><tr><td width="400"><span class="sizesmallfont"><span class="fontstyle">&nbsp;<?php echo utf8_decode($row_orderdetails['ShipName']); ?> <?php echo utf8_decode($row_orderdetails['ShipLastName']); ?></span></span></td>

                        <td width="400"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['BillName']); ?> <?php echo utf8_decode($row_orderdetails['BillLastName']); ?></span></span></div></td>

                      </tr>

                      <tr>

                        <td width="400"><span class="sizesmallfont"><span class="fontstyle">&nbsp;<?php echo utf8_decode($row_orderdetails['ShipAddress']); ?></span></span></td>

                        <td width="400"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['BillAddress']); ?></span></span></div></td>

                      </tr>

                      <tr>

                        <td width="400"><span class="sizesmallfont"><span class="fontstyle">&nbsp;<?php echo utf8_decode($row_orderdetails['ShipCity']); ?>, <?php echo utf8_decode($row_orderdetails['ShipState']); ?> <?php echo utf8_decode($row_orderdetails['ShipZip']); ?></span></span></td>

                        <td width="400"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['BillCity']); ?>, <?php echo utf8_decode($row_orderdetails['BillState']); ?> <?php echo utf8_decode($row_orderdetails['BillZip']); ?></span></span></div></td>

                      </tr>

                      <tr>

                        <td><span class="sizesmallfont"><span class="fontstyle">&nbsp;Country: <?php echo utf8_decode($row_orderdetails['ShipCountry']); ?></span></span></td>

                        <td><span class="sizesmallfont"><span class="fontstyle">Country: <?php echo utf8_decode($row_orderdetails['BillCountry']); ?></span></span></td>

                      </tr><?php } 

// endif Conditional region8

?>

                      <tr>

                        <td width="400"><span class="sizesmallfont"><span class="fontstyle"><strong>&nbsp;Phone:</strong> <?php echo utf8_decode($row_orderdetails['ShipPhone']); ?></span></span></td>

                        <td width="400"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><strong>Email:</strong>&nbsp; <a href="mailto:<?php echo utf8_decode($row_orderdetails['Email']); ?>"><?php echo utf8_decode($row_orderdetails['Email']); ?></a></span></span></div></td>

                      </tr>

                    </table></td>

                </tr>

                <tr>

                  <td height="34" colspan="3" valign="top"><span class="fontstyle"><!-- order comments section table -->

                    </span>

                    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">

                      <tr>

                        <td width="121" class="sizemediumfont"><span class="fontstyle"><strong>&nbsp;Order Number:</strong> </span></td>

                        <td width="134" class="sizesmallfont"><div align="left"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['OrderID']); ?></span></div></td>

                        <td width="148" class="sizesmallfont">&nbsp;</td>

                        <td width="126" class="sizemediumfont"><div align="left"><span class="fontstyle"><strong>Order Date: </strong></span></div></td>

                        <td width="271" class="sizesmallfont"><div align="left"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['UpdateDate']); ?></span></div>

                            <div align="left"></div></td>

                      </tr>

                      <tr>

                        <td class="sizemediumfont"><span class="fontstyle"><strong>&nbsp;Coupon  Code:</strong></span></td>

                        <td colspan="2" class="sizesmallfont"><span class="fontstyle"><?php 

							// Show IF Conditional region22 

							if ($row_orderdetails['PromoCode'] != '0') {

							?>

													 <?php echo utf8_decode($row_orderdetails['PromoCode']); ?> 

						  <?php 

							// else Conditional region22

							} else { ?>

													  NO COUPON CODE USED

						  <?php } 

							// endif Conditional region22

							?>                          

                          </span></td>

                        <td class="sizemediumfont"><span class="fontstyle"><strong>Total Weight:</strong></span></td>

                        <td class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['TotalWeight']); ?></span></td>

                      </tr>

                      <tr>

                        <td colspan="5">&nbsp;</td>

                      </tr>

                  </table></td>

                </tr>

                <tr>

                  <td colspan="3"><span class="fontstyle"><!--Shipping table -->

                    </span>

                    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="tableheadingbg">

                      <tr>

                        <td width="180" bgcolor="#CCCCCC"><div align="left"><span class="sizemediumfont"><span class="fontstyle"><strong>&nbsp;ORDER DETAILS </strong></span></span></div></td>

                        <td width="368" align="right" bgcolor="#CCCCCC"><div class="style2"></div>

                            <span class="sizemediumfont"><span class="fontstyle">                          Shipping Carrier:<br>

                          Tracking Number:<br>

                        Shipping Method:</span></span></td>

                        <td width="252" align="right" bgcolor="#CCCCCC"><span class="sizemediumfont"><span class="fontstyle">

                        <div class="style2">

                        <?php echo utf8_decode($row_orderdetails['ShipCarrier']); ?>&nbsp;&nbsp;<br>

<?php echo utf8_decode($row_orderdetails['TrackingNumber']); ?>&nbsp;&nbsp;<br>



                        </span>

                        </span>

                          <div align="right"></div>

                          <div align="right" class="style2">

                            <span class="sizemediumfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['ShipMethod']); ?>&nbsp;&nbsp;

                             

                        </span></span></div></td>

                      </tr>

                    </table>

                    <span class="fontstyle">

                    <!--table headings -->

                    </span>

                    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">

            <tr>

              <td width="120"><div align="center"><span class="sizemediumfont"><span class="fontstyle"><strong>Quantity</strong></span></span></div></td>

              <td width="385"><span class="sizemediumfont"><span class="fontstyle"><strong>Item</strong></span></span></td>

              <td width="100"><div align="left"><span class="sizemediumfont"><span class="fontstyle"><strong>Model/SKU</strong></span></span></div></td>

              <td width="100"><div align="left"><span class="sizemediumfont"><span class="fontstyle"><strong>Ind. Price </strong></span></span></div></td>

              <td width="100"><div align="right"><span class="sizemediumfont"><span class="fontstyle"><strong>Total Price</strong></span></span></div></td>

            </tr>

          </table></td>

                </tr>

                <tr>

                  <td colspan="3" valign="bottom"><span class="fontstyle">

                  <?php

$rows_orderdetails = 2;

$cols_orderdetails = ceil($totalRows_orderdetails/ 2);

for ($i=0; $i<$rows_orderdetails; $i++) {

	for ($j=0; $j<$cols_orderdetails; $j++) {

		$currentIndex_orderdetails = $i + $rows_orderdetails * $j;

		if (@mysql_data_seek($orderdetails, $currentIndex_orderdetails)) {

			$row_orderdetails = mysql_fetch_assoc($orderdetails); ?>

                    <!-- order details if statements -->

                    </span>

                    <table border="0" cellpadding="0" cellspacing="0" class="KT_tngtable">

                      <tr>

                        <td height="30" width="120" valign="top" class="style1"><div align="center"><span class="sizesmallfont"><span class="fontstyle"><b><?php echo utf8_decode($row_orderdetails['Quantity']); ?></b></span></span></div></td>

                        <td width="385" valign="top" class="style1"><span class="sizesmallfont"><span class="fontstyle"><b><?php echo utf8_decode($row_orderdetails['OrderTitle']); ?></b><br>

                          </span>

                          </span>

                          <table width="240" border="0" align="center" cellpadding="0" cellspacing="0">

                            <?php 

// Show IF Conditional option1area 

if (@$row_orderdetails['isGiftCard'] == 1 ) {

?>

                            <tr>

                                  <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Gift Card Delivery: </em></span></span></div></td>

                                  <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['deliverymethod']); ?></span></span></td>

                                </tr>

                                <tr>

                                  <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Gift Card To: </em></span></span></div></td>

                                  <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['toname']); ?></span></span></td>

                                </tr>

                                <tr>

                                  <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Gift Card From: </em></span></span></div></td>

                                  <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['fromname']); ?></span></span></td>

                                </tr>

                                <tr>

                                  <td width="125" valign="top" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Gift Card Message: </em></span></span></div></td>

                                  <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['message']); ?></span></span></td>

                                </tr>

                            <?php }

// endif Conditional option1area

?>

                            <?php 

// Show IF Conditional option1area 

$emptyvalue = '';

$zerovalue = '0';

if (@$row_orderdetails['orderoption1'] != $emptyvalue && @$row_orderdetails['orderoption1'] != $zerovalue) {

?>

                            <tr>

                              <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Option 1: </em></span></span></div></td>

                              <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['orderoption1']); ?></span></span></td>

                            </tr>

                            <?php } 

// endif Conditional option1area

?>

                            <?php 

// Show IF Conditional region2 

$emptyvalue = '';

$zerovalue = '0';

if (@$row_orderdetails['orderoption2'] != $emptyvalue && @$row_orderdetails['orderoption2'] != $zerovalue) {

?>

                            <tr>

                              <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Option 2: </em></span></span></div></td>

                              <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['orderoption2']); ?></span></span></td>

                            </tr>

                            <?php } 

// endif Conditional region2

?>

                            <?php 

// Show IF Conditional region3 

$emptyvalue = '';

$zerovalue = '0';

if (@$row_orderdetails['orderoption3'] != $emptyvalue && @$row_orderdetails['orderoption3'] != $zerovalue) {

?>

                            <tr>

                              <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Option 3: </em></span></span></div></td>

                              <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['orderoption3']); ?></span></span></td>

                            </tr>

                            <?php } 

// endif Conditional region3

?>

                            <?php 

// Show IF Conditional region4 

$emptyvalue = '';

$zerovalue = '0';

if (@$row_orderdetails['orderoption4'] != $emptyvalue && @$row_orderdetails['orderoption4'] != $zerovalue) {

?>

                            <tr>

                              <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Option 4: </em></span></span></div></td>

                              <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['orderoption4']); ?></span></span></td>

                            </tr>

                            <?php } 

// endif Conditional region4

?>

                            <?php 

// Show IF Conditional region5 

$emptyvalue = '';

$zerovalue = '0';

if (@$row_orderdetails['orderoption5'] != $emptyvalue && @$row_orderdetails['orderoption5'] != $zerovalue) {

?>

                            <tr>

                              <td width="125" style="text-align: left"><div align="left"><span class="sizesmallfont"><span class="fontstyle"><em>Option 5: </em></span></span></div></td>

                              <td><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['orderoption5']); ?></span></span></td>

                            </tr>

                            <?php } 

// endif Conditional region5

?>

                          </table></td>

                        <td width="100" valign="top"><div align="center"><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode($row_orderdetails['OrderModelNumber']); ?>&nbsp;</span></span></div></td>

                        <td width="100" valign="top"><div align="center"><span class="sizesmallfont"><span class="fontstyle"><?php echo utf8_decode(number_format($row_orderdetails['OrderPrice'], 2)); ?></span></span></div></td>

                        <td width="100" valign="top"><div align="right"> <span class="sizesmallfont"><span class="fontstyle"><b><?php echo utf8_decode(number_format($row_orderdetails['OrderPrice'] * $row_orderdetails['Quantity'], 2)); ?> </b></span></span></div></td>



                      </tr>

                    </table>

                      <span class="fontstyle">

                      <?php

		} else {

			echo '<td>&nbsp;</td>';

		} // end if;

	} //end for 2

	if ($i != $rows_orderdetails-1) {

		echo "";

	}

} // end for 1

?>                  

                  &nbsp;</span></td>

                </tr>

                <tr>

                  <td colspan="3" align="right"><span class="fontstyle"><!--totals, shipping, taxes table -->

                  </span>

                    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">

                      <tr>

                        <td align="right" class="total"><div align="right"><span class="sizemediumfont"><span class="fontstyle"><strong>Sales Tax:</strong>&nbsp;</span></span></div></td>

                        <td width="100" class="total"><div align="right"><span class="sizemediumfont"><span class="fontstyle"><?php echo utf8_decode(number_format($row_orderdetails['Tax'], 2)); ?></span></span></div></td>

                      </tr>

                      <tr>

                        <td align="right" class="total"><span class="sizemediumfont"><span class="fontstyle"><strong>Shipping:</strong>&nbsp;</span></span></td>

                        <td width="100" class="total"><div align="right"><span class="sizemediumfont"><span class="fontstyle"><?php echo utf8_decode(number_format($row_orderdetails['Shipping'], 2)); ?></span></span></div></td>

                      </tr>

                      <tr>

                        <td align="right" class="total"><div align="left">

                            <div align="right"><span class="sizemediumfont"><span class="fontstyle"><strong>Order Total:</strong>&nbsp;</span></span></div>

                        </div></td>

                        <td width="100" class="total"><div align="right"><span class="sizemediumfont"><span class="fontstyle"><?php echo utf8_decode(number_format($row_orderdetails['Total'], 2)); ?></span></span></div></td>

                      </tr>
                      <tr>
                        <td align="right" class="total">&nbsp;</td>
                        <td class="total">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2" align="left" class="fontstyle"><span class="style1">Notes:</span></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="left" class="fontstyle"><span class="sizemediumfont"><?php echo $row_orderdetails['ordernotes']; ?></span></td>
                      </tr>

                    </table></td>

                </tr>

            </table>

</body>

</html>

<?php

} else {

	echo "Not Authorized...";

}

mysql_free_result($orderdetails);



mysql_free_result($rsorderstatus);



mysql_free_result($settingsRS);

?>