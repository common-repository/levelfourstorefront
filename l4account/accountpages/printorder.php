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



if (!session_id()) session_start();

require_once('../../Connections/flashdb.php');

require_once("../../scripts/l4html/l4store_functions.php"); 

require_once("../../scripts/l4html/l4store_cart.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<Title>Order Receipt</Title>

	

<!-- L4 Style sheets -->

<link href="../../scripts/headerstylesheet.css" rel="stylesheet" type="text/css">

<link href="../../scripts/cssmenu.css" rel="stylesheet" type="text/css">

<link href='../../scripts/mainstylesheet.css' rel='stylesheet' type='text/css'>

<link href="../../scripts/footerstylesheet.css" rel="stylesheet" type="text/css" />

<link href="../../scripts/storemenustylesheet.css" rel="stylesheet" type="text/css" />

<link href="../../scripts/storemenustylesheet3.css" rel="stylesheet" type="text/css" />

<link href="../../scripts/l4settingscss.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../scripts/l4html/jquery-1.7.1.js"></script>

<script type="text/javascript" src="../../scripts/l4html/raty/js/jquery.raty.js"></script>

<script type='text/javascript' src='../../scripts/l4html/spin.js'></script>

<script type='text/javascript' src='../../scripts/l4html/l4store_functions.js'></script>

<script type='text/javascript' src='../../scripts/l4html/l4store_cart.js'></script>

<script type='text/javascript' src='../../scripts/l4html/livevalidation_standalone.js'></script>

<script language="JavaScript">



$(document).ready(function() {

	$(".topnav").accordion({

		accordion:false,

		speed: 500,

		closedSign: '[+]',

		openedSign: '[-]'

	});

});



</script>

<body>

<div id="primary">

  <div id="content" role="main">

    <table width="1024" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>

        <td width="1024" style="vertical-align:top">



<?php

if(userloggedin()){

	

	$orderssql="SELECT orders.*, DATE_FORMAT(orders.OrderDate, '%b %d, %Y at %l:%i %p') as OrderDate FROM orders, clients WHERE " . sprintf("orders.OrderID = '%s' AND orders.ClientID = clients.ClientID AND clients.Email='%s' and clients.Password='%s'", mysql_real_escape_string($_GET['orderid']), mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']));

	$ordersresult=mysql_query($orderssql);

	$ordersrow=mysql_fetch_assoc($ordersresult);

	

	$orderdetailssql = sprintf("SELECT details.*, downloadkey.*, products.ModelNumber, optionitems1.optionitemname as option1name, optionitems1.optionitemprice as option1price, optionitems2.optionitemname as option2name, optionitems2.optionitemprice as option2price, optionitems3.optionitemname as option3name, optionitems3.optionitemprice as option3price, optionitems4.optionitemname as option4name, optionitems4.optionitemprice as option4price, optionitems5.optionitemname as option5name, optionitems5.optionitemprice as option5price FROM details LEFT JOIN optionitems as optionitems1 ON(optionitems1.optionitemID = details.orderoption1) LEFT JOIN optionitems as optionitems2 ON(optionitems2.optionitemID = details.orderoption2) LEFT JOIN optionitems as optionitems3 ON(optionitems3.optionitemID = details.orderoption3) LEFT JOIN optionitems as optionitems4 ON(optionitems4.optionitemID = details.orderoption4) LEFT JOIN optionitems as optionitems5 ON(optionitems5.optionitemID = details.orderoption5) LEFT OUTER JOIN products ON (products.ProductID = details.ProductID) LEFT OUTER JOIN downloadkey ON (details.downloadkey = downloadkey.uniqueid), clients, orders WHERE details.OrderID = '%s' AND orders.OrderID = details.OrderID AND clients.ClientID = orders.ClientID AND clients.Email = '%s' AND clients.Password = '%s'", mysql_real_escape_string($_GET['orderid']), mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']));

	$orderdetailsresult = mysql_query($orderdetailssql);

	$orderdetailsnumrows = mysql_num_rows($orderdetailsresult);

}else{

	$orderssql="SELECT orders.*, DATE_FORMAT(orders.OrderDate, '%b %d, %Y at %l:%i %p') as OrderDate FROM orders WHERE " . sprintf("orders.OrderID = '%s'", mysql_real_escape_string($_GET['orderid']));

	$ordersresult = mysql_query($orderssql);

	$ordersrow = mysql_fetch_assoc($ordersresult);

	

	if(isset($_GET['key']) && $_GET['key'] == md5($ordersrow['Email'])){

		$orderdetailssql = sprintf("SELECT details.*, downloadkey.*, products.* FROM details LEFT OUTER JOIN products ON (products.ProductID = details.ProductID) LEFT OUTER JOIN downloadkey ON (details.downloadkey = downloadkey.uniqueid), orders WHERE details.OrderID = '%s' AND orders.OrderID = details.OrderID", mysql_real_escape_string($_GET['orderid']));

		$orderdetailsresult = mysql_query($orderdetailssql);

		$orderdetailsnumrows = mysql_num_rows($orderdetailsresult);

	}else{

		header("location:index.php");	

	}

}



?>

<div class="print_header"><img src="../../images/emaillogo.jpg" alt="<?php echo $row_company['businessname']; ?>"></div><div class="print_content"><?php echo $row_company['businessname']; ?><br><?php echo $row_company['contactaddress']; ?><br><?php echo $row_company['contactcity']; ?>, <?php echo $row_company['contactstate']; ?> <?php echo $row_company['contactzip']; ?><br><?php echo $row_company['contactphone']; ?></div>

<div class="dashboard_break"></div>

<div class="dashboard_left">

	<div class="dashboard_table_header">Your Order</div>

	<div class="dashboard_table_content">

    	<div><?php echo $orderrow['OrderStatus']; ?></div>

		<?php if($orderdetailsnumrows != 0){ $subtotal = 0; ?>

        	<div class="orderdetails_header_row"><div class="orderdetails_header_wide">Product</div><div class="orderdetails_header_quantity">Quantity</div><div class="orderdetails_header_spacer"></div><div class="orderdetails_header_price">Price</div><div class="orderdetails_header_spacer"></div></div>

        	<?php while($orderdetailsrow = mysql_fetch_assoc($orderdetailsresult)){?>

            	<div class="orderdetails_row">

                	<div class="orderdetails_column_wide">

                    	<img src="../../scripts/l4html/resizer.php?src=../products/pics1/<?php echo $orderdetailsrow['Image1']; ?>&h=<?php echo $row_settingsRS['small_height']; ?>&w=<?php echo $row_settingsRS['small_width']; ?>&zc=1" alt="<?php echo $orderdetailsrow['OrderTitle']; ?>" class="orderdetails_image" /><?php echo $orderdetailsrow['OrderTitle']; ?><br /><span class="optionitems"><?php if($orderdetailsrow['orderoption1']){ echo $orderdetailsrow['orderoption1']; }?><?php if($orderdetailsrow['orderoption2']){ echo ", " . $orderdetailsrow['orderoption2']; }?><?php if($orderdetailsrow['orderoption3']){ echo ", " . $orderdetailsrow['orderoption3']; }?><?php if($orderdetailsrow['orderoption4']){ echo ", " . $orderdetailsrow['orderoption4']; }?><?php if($orderdetailsrow['orderoption5']){ echo ", " . $orderdetailsrow['orderoption5'] 	; }?></span><?php if($orderdetailsrow['orderoption1']){ echo "<br />"; } ?>Model Number: <?php echo $orderdetailsrow['ModelNumber']; ?></div>

                    <div class="orderdetails_column_quantity"><?php echo $orderdetailsrow['Quantity']; ?></div>

                    <div class="orderdetails_header_spacer"></div>

                    <div class="orderdetails_column_price"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($orderdetailsrow['OrderPrice'], 2); ?></div>

                    <div class="orderdetails_header_spacer"></div>

                </div>

				<?php $subtotal = $subtotal + ($orderdetailsrow['OrderPrice'] * $orderdetailsrow['Quantity']); ?>

            <?php }?>

            <div class="order_break"></div>

            <div class="orderdetails_price_row_holder"><div class="orderdetails_price_row"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($subtotal, 2); ?></div><div class="orderdetails_price_label_row">Subtotal:</div></div>

            <div class="orderdetails_price_row_holder"><div class="orderdetails_price_row"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($ordersrow['Shipping'], 2); ?></div><div class="orderdetails_price_label_row">Shipping:</div></div>

            <div class="orderdetails_price_row_holder"><div class="orderdetails_price_row"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($ordersrow['Tax'], 2); ?></div><div class="orderdetails_price_label_row">Tax:</div></div>

            <?php if($ordersrow['Total'] != ($subtotal + $ordersrow['Shipping'] + $ordersrow['Tax'])){ ?>

			<div class="orderdetails_price_row_holder"><div class="orderdetails_price_row">-<?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format(round(($subtotal + $ordersrow['Shipping'] + $ordersrow['Tax']) - $ordersrow['Total'], 2), 2); ?></div><div class="orderdetails_price_label_row">Discount:</div></div>

			<?php }?>	

            <div class="orderdetails_price_row_holder"><div class="orderdetails_price_row"><b><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($ordersrow['Total'], 2); ?></b></div><div class="orderdetails_price_label_row"><b>Total:</b></div></div>

        <?php }else{ ?>

        	<div>No details available.</div>

        <?php } ?>

    </div>

    <div class="dashboard_break"></div>

</div>

<div class="dashboard_right">

	<div class="dashboard_table_header">Order Information</div>

    <div class="dashboard_table_content">

        <div><b>Order Number:</b> <?php echo $ordersrow['OrderID']; ?></div>

        <div><b>Order Date:</b> <?php echo $ordersrow['OrderDate']; ?></div>

        <div><b>Order Status:</b> <?php echo $ordersrow['OrderStatus']; ?></div>

        <div><b>Shipping Type:</b> <?php echo $ordersrow['ShipMethod']; ?></div>

        <?php if($ordersrow['ShipCarrier']){?><div><b>Shipping Carrier:</b> <?php echo $ordersrow['ShipCarrier']; ?></div><?php }?>

        <?php if($ordersrow['TrackingNumber']){?><div><b>Tracking Number:</b> <?php echo $ordersrow['TrackingNumber']; ?></div><?php }?>

        <div class="dashboard_break"></div>

        <div><b>Shipping Address:</b></div>

        <div><?php echo $ordersrow['ShipName'] . " " . $ordersrow['ShipLastName']; ?></div>

        <div><?php echo $ordersrow['ShipAddress'] ?></div>

        <div><?php echo $ordersrow['ShipCity'] . ", " . $ordersrow['ShipState'] . " " . $ordersrow['ShipZip']; ?></div>

        <div><?php echo $ordersrow['ShipCountry'] ?></div>

        <div><?php echo $ordersrow['ShipPhone'] ?></div>

        <div class="dashboard_break"></div>

        <div><b>Billing Address:</b></div>

        <div><?php echo $ordersrow['BillName'] . " " . $ordersrow['BillLastName']; ?></div>

        <div><?php echo $ordersrow['BillAddress'] ?></div>

        <div><?php echo $ordersrow['BillCity'] . ", " . $ordersrow['BillState'] . " " . $ordersrow['BillZip']; ?></div>

        <div><?php echo $ordersrow['BillCountry'] ?></div>

        <div><?php echo $ordersrow['BillPhone'] ?></div>

        <div><?php echo $ordersrow['Email'] ?></div>

        <div class="dashboard_break"></div>

        <div><b>Payment Method:</b> <?php echo $ordersrow['PaymentMethod']; ?></div>

        <div class="dashboard_break"></div>

        <div><b>Order Total:</b> <?php echo $row_settingsRS['currencySymbol']; ?><?php echo $ordersrow['Total'] ?></div>

    </div>

    <div class="dashboard_break"></div>

</div>



<script type="text/javascript">

function PrintWindow(){

   window.print();            

   CheckWindowState();

}



function CheckWindowState(){

	if(document.readyState=="complete"){

		window.close(); 

	}else{           

		setTimeout("CheckWindowState()", 2000)

	}

}    



PrintWindow();

</script>

         </td>

      </tr>

    </table>

  </div>

  <!-- #content --> 

</div>

<!-- #primary -->



</body>

</html>