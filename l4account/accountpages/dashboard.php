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

	$dashboardsql=sprintf("SELECT * FROM clients WHERE Email='%s' and Password='%s'", mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']));

	$dashboardresult=mysql_query($dashboardsql);

	$dashboardrow = mysql_fetch_assoc($dashboardresult);

	$dashboardtotalrows=mysql_num_rows($dashboardresult);

	

	$orderssql = "SELECT orders.OrderID, DATE_FORMAT(orders.OrderDate, '%b %d, %Y at %l:%i %p') as OrderDate, orders.Total, orders.OrderStatus FROM orders, clients WHERE orders.ClientID = clients.ClientID AND " . sprintf("clients.Email='%s' AND clients.Password='%s' AND orders.OrderDate > DATE_SUB(NOW(), INTERVAL 31 DAY)", mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password'])) . "ORDER BY orders.OrderDate DESC LIMIT 10 ";

	$ordersresult=mysql_query($orderssql);

	$numorders = mysql_num_rows($ordersresult);

}



?>



<div class="l4store_title">Your Account</div>

<div class="dashboard_head_content">You are logged in as <?php echo $dashboardrow['Email']; ?>. You can use your account to check, view, and print orders.</div>

<div class="dashboard_left">

	<div class="dashboard_table_header">Your Recent Orders</div>

    <div class="dashboard_table_content">

    	<?php if($numorders != 0){ ?>

        	<?php $i=0;?>

        	<div class="order_header_row"><div class="order_header_one">Order Date</div><div class="order_header_two">Order Number</div><div class="order_header_three">View Order</div></div>

        	<?php while($orderrow = mysql_fetch_assoc($ordersresult)){?>

            	<div class="order_row<?php if($i%2){echo "_odd"; }else{echo "_even";}?>">
                	<div class="order_column_one">
                    	<a href="<?php echo $accountpage . $permalinkdivider; ?>page=orderdetails&orderid=<?php echo $orderrow['OrderID']; ?>" class="l4store_link"><?php echo $orderrow['OrderDate']; ?></a>
                    </div>
                    <div class="order_column_two"><?php echo $orderrow['OrderID']; ?></div>
                    <div class="order_column_three">
                    	<a href="<?php echo $accountpage . $permalinkdivider; ?>page=orderdetails&orderid=<?php echo $orderrow['OrderID']; ?>" class="l4store_link">View Order</a>
                    </div>
                </div>
				
				<?php $i++; ?>

            <?php }?>

            
            

        <?php }else{ ?>

        	<div>You have no recent orders.</div>

        <?php } ?>
        
        <div class="viewallordersalign"><a href="<?php echo $accountpage . $permalinkdivider; ?>page=pastorders" class="l4store_link">View All Orders</a></div>

    	<div class="clear"></div>

    </div>

    <div class="dashboard_break"></div>

    <div class="dashboard_table_header">Account Preferences</div>

    <div class="dashboard_table_content">    

        <div class="dashboard_mini_header">Your Primary Email</div>

        <div><?php echo $dashboardrow['Email']; ?></div>

        <div><a href="<?php echo $accountpage . $permalinkdivider; ?>page=personal_info" class="l4store_link">Edit</a> (This is used to log in)</div>

        <div class="dashboard_break"></div>

        <div class="dashboard_mini_header">Billing Address</div>

        <?php if($dashboardrow['BillName']){?>

            <div><?php echo $dashboardrow['BillName'] . " " . $dashboardrow['BillLastName']; ?><br />

                 <?php echo $dashboardrow['BillAddress']; ?><br />

                 <?php echo $dashboardrow['BillCity'] . ", " . $dashboardrow['BillState'] . " " . $dashboardrow['BillZip']; ?><br />

                 <?php echo $dashboardrow['BillCountry']; ?><br />

                 <?php echo $dashboardrow['BillPhone']; ?>

            </div>

            <div><a href="<?php echo $accountpage . $permalinkdivider; ?>page=billinginfo" class="l4store_link">Edit Billing Address</a></div>

        <?php }else{ ?>

	        <div>(You have not added a billing address yet.)</div>

            <div><a href="<?php echo $accountpage . $permalinkdivider; ?>page=billinginfo" class="dashboardlink">Add Billing Address</a></div>

        <?php }?>

        <div class="dashboard_break"></div>

        <div class="dashboard_mini_header">Shipping Address</div>

        <?php if($dashboardrow['ShipName']){?>

            <div><?php echo $dashboardrow['ShipName'] . " " . $dashboardrow['ShipLastName']; ?><br />

                 <?php echo $dashboardrow['ShipAddress']; ?><br />

                 <?php echo $dashboardrow['ShipCity'] . ", " . $dashboardrow['ShipState'] . " " . $dashboardrow['ShipZip']; ?><br />

                 <?php echo $dashboardrow['ShipCountry']; ?><br />

                 <?php echo $dashboardrow['ShipPhone']; ?>

            </div>

            <div><a href="<?php echo $accountpage . $permalinkdivider; ?>page=shippinginfo" class="l4store_link">Edit Shipping Address</a></div>

        <?php }else{?>

	        <div>(You have not added a shipping address yet.)</div>

            <div><a href="<?php echo $accountpage . $permalinkdivider; ?>page=shippinginfo" class="l4store_link">Add Shipping Address</a></div>

        <?php }?>

    </div>

</div>

<div class="dashboard_right">

	<div class="dashboard_table_header">Other Useful Links</div>

    <div class="dashboard_table_content">

        <div><a href="<?php echo $accountpage . $permalinkdivider; ?>page=personal_info" class="l4store_link">Edit Basic Information</a></div>

        <div><a href="<?php echo $accountpage . $permalinkdivider; ?>page=editpassword" class="l4store_link">Edit Password</a></div>

        <div><a href="<?php echo $accountpage.$permalinkdivider; ?>l4_action=signout" class="l4store_link">Sign Out</a></div>

    </div>

</div>