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

	$orderssql="SELECT orders.OrderID, DATE_FORMAT(orders.OrderDate, '%b %d, %Y at %l:%i %p') as OrderDate, orders.Total, orders.OrderStatus FROM orders, clients WHERE orders.ClientID = clients.ClientID AND " . sprintf("clients.Email='%s' and clients.Password='%s'", mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password'])) . " ORDER BY orders.OrderDate DESC";

	$ordersresult=mysql_query($orderssql);

	$numorders = mysql_num_rows($ordersresult);

}

?>

<script type="text/javascript">

function showdashboard(){

	window.location = "index.php";

}

</script>



<div class="l4store_title	">Past Orders</div>

<div class="dashboard_head_content">Only orders placed while signed into this account will be displayed. If you do not see your order, please contact us. Thank you.</div>



<div class="dashboard_left">

	<div class="dashboard_table_header">Your Order History</div>

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

        	<div>You have not placed any orders with us.</div>

        <?php } ?>
        
        <div class="clear"></div>

    </div>

</div>

<div class="dashboard_right">

	<div class="dashboard_table_header">Other Useful Links</div>

    <div class="dashboard_table_content">

        <div><a href="<?php echo $accountpage; ?>" class="l4store_link">Account Dashboard</a></div>

        <div><a href="<?php echo $accountpage . $permalinkdivider; ?>page=personal_info" class="l4store_link">Edit Basic Information</a></div>

        <div><a href="<?php echo $accountpage . $permalinkdivider; ?>page=editpassword" class="l4store_link">Edit Password</a></div>

        <div><a href="<?php echo $accountpage.$permalinkdivider; ?>l4_action=signout" class="l4store_link">Sign Out</a></div>

    </div>

</div>