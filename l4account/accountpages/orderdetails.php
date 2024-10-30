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

if(userloggedin()){
	$orderssql="SELECT orders.*, DATE_FORMAT(orders.OrderDate, '%b %d, %Y at %l:%i %p') as OrderDate FROM orders, clients WHERE " . sprintf("orders.OrderID = '%s' AND orders.ClientID = clients.ClientID AND clients.Email='%s' and clients.Password='%s'", mysql_real_escape_string($_GET['orderid']), mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']));
	$ordersresult = mysql_query($orderssql);
	$ordersrow = mysql_fetch_assoc($ordersresult);
	
	$orderdetailssql = sprintf("SELECT details.*, downloadkey.*, products.ModelNumber FROM details LEFT OUTER JOIN products ON (products.ProductID = details.ProductID) LEFT OUTER JOIN downloadkey ON (details.downloadkey = downloadkey.uniqueid), clients, orders WHERE details.OrderID = '%s' AND orders.OrderID = details.OrderID AND clients.ClientID = orders.ClientID AND clients.Email = '%s' and clients.Password = '%s'", mysql_real_escape_string($_GET['orderid']), mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']));
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
		//header("location:index.php");	
	}
}
?>
<?php if(isset($_GET['ordersuccess']) && $_GET['ordersuccess'] == "success"){?>

<div class="loginsuccess cartrow floatleft">Your Order Has Been Submitted Successfully!</div>
<?php }?>
<?php if(userloggedin()){?>
<div class="orderdetails_content">Return to <a href="<?php echo $accountpage . $permalinkdivider; ?>page=pastorders" class="l4store_link">Your Orders</a>
  <div class="floatright"><a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4account/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/l4account/accountpages/printorder.php?orderid=<?php echo $_GET['orderid']; ?><?php if(isset($_GET['key'])){ echo "&key=".$_GET['key']; } ?>" class="l4store_link" target="_blank"><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4account/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/print_icon.gif" alt="Print Order" /></a></div>
</div>
<?php }?>
<div class="dashboard_break"></div>
<div class="l4store_title">Order Details</div>
<div class="dashboard_break"></div>
<div class="dashboard_left">
  <div class="dashboard_table_header">Your Order</div>
  <div class="dashboard_table_content">
    <div><?php echo $orderrow['OrderStatus']; ?></div>
    <?php if($orderdetailsnumrows != 0){ $subtotal = 0; ?>
    <div class="orderdetails_header_row">
      <div class="orderdetails_header_wide">Product</div>
      <div class="orderdetails_header_quantity">Quantity</div>
      <div class="orderdetails_header_spacer"></div>
      <div class="orderdetails_header_price">Price</div>
      <div class="orderdetails_header_spacer"></div>
    </div>
    <?php while($orderdetailsrow = mysql_fetch_assoc($orderdetailsresult)){?>
    <div class="orderdetails_row">
      <div class="orderdetails_column_wide">
        <?php if($row_cart['useoptionitemimages']){?>
        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4account/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_small_width'); ?>_<?php echo get_option('l4_option_small_height'); ?>_<?php echo $orderdetailsrow['Image1']; ?>" alt="<?php echo $orderdetailsrow['OrderTitle']; ?>" class="orderdetails_image" />
        <?php }else{?>
        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4account/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/images.php?max_width=<?php echo get_option('l4_option_small_width'); ?>&max_height=<?php echo get_option('l4_option_small_height'); ?>&imgfile=<?php echo $orderdetailsrow['Image1']; ?>" alt="<?php echo $orderdetailsrow['OrderTitle']; ?>" class="orderdetails_image" />
        <?php }?>
        <a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $orderdetailsrow['ModelNumber']; ?>" class="l4store_link"><?php echo $orderdetailsrow['OrderTitle']; ?></a><br />
        <span class="optionitems">
        <?php if($orderdetailsrow['orderoption1']){ echo $orderdetailsrow['orderoption1']; }?>
        <?php if($orderdetailsrow['orderoption2']){ echo ", " . $orderdetailsrow['orderoption2']; }?>
        <?php if($orderdetailsrow['orderoption3']){ echo ", " . $orderdetailsrow['orderoption3']; }?>
        <?php if($orderdetailsrow['orderoption4']){ echo ", " . $orderdetailsrow['orderoption4']; }?>
        <?php if($orderdetailsrow['orderoption5']){ echo ", " . $orderdetailsrow['orderoption5'] 	; }?>
        </span>
        <?php if($orderdetailsrow['orderoption1']){ echo "<br />"; } ?>
        <?php if($orderdetailsrow['isGiftCard'] && ($ordersrow['OrderStatus'] == 'Card Approved' || $ordersrow['OrderStatus'] == 'Order Confirmed' || $ordersrow['OrderStatus'] == 'Order Shipped' || $ordersrow['OrderStatus'] == 'PayPal Approved') ){ ?>
        <a href="<?php echo getProtocol() . str_replace("www.", "", $row_settingsRS['siteURL']); ?>/l4account/accountpages/giftcard.php?orderid=<?php echo $_GET['orderid']; ?>&orderdetailid=<?php echo $orderdetailsrow['details_id']; ?>&giftcardid=<?php echo $orderdetailsrow['orderedItemCode']; ?><?php if(isset($_GET['key'])){ echo "&key=".$_GET['key']; } ?>" class="l4store_link" target="_blank">Print Gift Card</a>
        <?php }else if($orderdetailsrow['isDownload'] && ($ordersrow['OrderStatus'] == 'Card Approved' || $ordersrow['OrderStatus'] == 'Order Confirmed' || $ordersrow['OrderStatus'] == 'Order Shipped' || $ordersrow['OrderStatus'] == 'PayPal Approved')){?>
        <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4account/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/scripts/downloads/download.php?downloadkey=<?php echo $orderdetailsrow['downloadkey']; ?><?php if(isset($_GET['key'])){ echo "&key=".$_GET['key']; } ?>" class="l4store_link" target="_blank">Download</a>
        <?php }else if ($orderdetailsrow['ModelNumber']){ ?>
        Model Number: <?php echo $orderdetailsrow['ModelNumber']; ?>
        <?php }?>
      </div>
      <div class="orderdetails_column_quantity"><?php echo $orderdetailsrow['Quantity']; ?></div>
      <div class="orderdetails_header_spacer"></div>
      <div class="orderdetails_column_price"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($orderdetailsrow['OrderPrice'], 2); ?></div>
      <div class="orderdetails_header_spacer"></div>
    </div>
    <?php $subtotal = $subtotal + ($orderdetailsrow['OrderPrice'] * $orderdetailsrow['Quantity']); ?>
    <?php }?>
    <div class="order_break"></div>
    <div class="orderdetails_price_row_holder">
      <div class="orderdetails_price_row"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($subtotal, 2); ?></div>
      <div class="orderdetails_price_label_row">Subtotal:</div>
    </div>
    <div class="orderdetails_price_row_holder">
      <div class="orderdetails_price_row"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($ordersrow['Shipping'], 2); ?></div>
      <div class="orderdetails_price_label_row">Shipping:</div>
    </div>
    <div class="orderdetails_price_row_holder">
      <div class="orderdetails_price_row"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($ordersrow['Tax'], 2); ?></div>
      <div class="orderdetails_price_label_row">Tax:</div>
    </div>
    <?php if($ordersrow['Total'] != ($subtotal + $ordersrow['Shipping'] + $ordersrow['Tax'])){ ?>
    <div class="orderdetails_price_row_holder">
      <div class="orderdetails_price_row">-<?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format(round(($subtotal + $ordersrow['Shipping'] + $ordersrow['Tax']) - $ordersrow['Total'], 2), 2); ?></div>
      <div class="orderdetails_price_label_row">Discount:</div>
    </div>
    <?php }?>
    <div class="orderdetails_price_row_holder">
      <div class="orderdetails_price_row"><b><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($ordersrow['Total'], 2); ?></b></div>
      <div class="orderdetails_price_label_row"><b>Total:</b></div>
    </div>
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
    <?php if($ordersrow['ShipCarrier']){?>
    <div><b>Shipping Carrier:</b> <?php echo $ordersrow['ShipCarrier']; ?></div>
    <?php }?>
    <?php if($ordersrow['TrackingNumber']){?>
    <div><b>Tracking Number:</b> <?php echo $ordersrow['TrackingNumber']; ?></div>
    <?php }?>
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
