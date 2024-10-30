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

<Title><?php if(isset($_GET['giftcardid'])){?>Gift Card <?php echo $_GET['giftcardid']; ?><?php }else{?>Level Four Storefront | HTML Version<?php }?>

<?php if(isset($_GET['menu'])){ echo "| " . $menu_row['menuName']; }else if(isset($_GET['submenu'])){ echo "| " . $menu_row['menuName']; }else if(isset($_GET['subsubmenu'])){ echo "| " . $menu_row['menuName']; }else if(isset($_GET['ModelNumber'])){ echo "| " . $row_productRS['Title']; }?>

</Title>

	<?php if(isset($_GET['menu'])){ ?>

		<meta name="description" content="<?php echo $menu_row['menuName']; ?>" />

		<meta name="keywords" content="<?php echo $menu_row['menuName']; ?>" />

	<?php }else if(isset($_GET['submenuid'])){ ?>

		<meta name="description" content="<?php echo $menu_row['menuName']; ?>" />

		<meta name="keywords" content="<?php echo $menu_row['menuName']; ?>" />

	<?php }else if(isset($_GET['subsubmenuid'])){ ?>

		<meta name="description" content="<?php echo $menu_row['menuName']; ?>" />

		<meta name="keywords" content="<?php echo $menu_row['menuName']; ?>" />

	<?php }else if(isset($_GET['ModelNumber'])){ ?>

		<meta name="description" content="<?php echo $row_productRS['shortDescription']; ?>" />

		<meta name="keywords" content="<?php echo $row_productRS['Keywords']; ?>" />

	<?php }else{ ?>

    	<meta name="description" content="Level Four Storefront HTML Version 1.0 Beta" />

		<meta name="keywords" content="Level Four Storefront, HTML Version, Beta" />

    <?php } ?>



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

	

	$orderdetailssql = sprintf("SELECT details.*, downloadkey.*, products.*, optionitems1.optionitemname as option1name, optionitems1.optionitemprice as option1price, optionitems2.optionitemname as option2name, optionitems2.optionitemprice as option2price, optionitems3.optionitemname as option3name, optionitems3.optionitemprice as option3price, optionitems4.optionitemname as option4name, optionitems4.optionitemprice as option4price, optionitems5.optionitemname as option5name, optionitems5.optionitemprice as option5price FROM details LEFT JOIN optionitems as optionitems1 ON(optionitems1.optionitemID = details.orderoption1) LEFT JOIN optionitems as optionitems2 ON(optionitems2.optionitemID = details.orderoption2) LEFT JOIN optionitems as optionitems3 ON(optionitems3.optionitemID = details.orderoption3) LEFT JOIN optionitems as optionitems4 ON(optionitems4.optionitemID = details.orderoption4) LEFT JOIN optionitems as optionitems5 ON(optionitems5.optionitemID = details.orderoption5) LEFT OUTER JOIN products ON (products.ProductID = details.ProductID) LEFT OUTER JOIN downloadkey ON (details.downloadkey = downloadkey.uniqueid), clients, orders WHERE details.OrderID = '%s' AND orders.OrderID = details.OrderID AND clients.ClientID = orders.ClientID AND clients.Email = '%s' and clients.Password = '%s' AND details.details_id = %s", mysql_real_escape_string($_GET['orderid']), mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']), mysql_real_escape_string($_GET['orderdetailid']));

	$orderdetailsresult = mysql_query($orderdetailssql);

	$orderdetailsnumrows = mysql_num_rows($orderdetailsresult);

	if($orderdetailsnumrows > 0){

		$orderdetailsrow = mysql_fetch_assoc($orderdetailsresult);

	}

}else{

	$orderssql="SELECT orders.*, DATE_FORMAT(orders.OrderDate, '%b %d, %Y at %l:%i %p') as OrderDate FROM orders WHERE " . sprintf("orders.OrderID = '%s'", mysql_real_escape_string($_GET['orderid']));

	$ordersresult = mysql_query($orderssql);

	$ordersrow = mysql_fetch_assoc($ordersresult);

	

	if(isset($_GET['key']) && $_GET['key'] == md5($ordersrow['Email'])){

		$orderdetailssql = sprintf("SELECT details.*, downloadkey.*, products.*, optionitems1.optionitemname as option1name, optionitems1.optionitemprice as option1price, optionitems2.optionitemname as option2name, optionitems2.optionitemprice as option2price, optionitems3.optionitemname as option3name, optionitems3.optionitemprice as option3price, optionitems4.optionitemname as option4name, optionitems4.optionitemprice as option4price, optionitems5.optionitemname as option5name, optionitems5.optionitemprice as option5price FROM details LEFT JOIN optionitems as optionitems1 ON(optionitems1.optionitemID = details.orderoption1) LEFT JOIN optionitems as optionitems2 ON(optionitems2.optionitemID = details.orderoption2) LEFT JOIN optionitems as optionitems3 ON(optionitems3.optionitemID = details.orderoption3) LEFT JOIN optionitems as optionitems4 ON(optionitems4.optionitemID = details.orderoption4) LEFT JOIN optionitems as optionitems5 ON(optionitems5.optionitemID = details.orderoption5) LEFT OUTER JOIN products ON (products.ProductID = details.ProductID) LEFT OUTER JOIN downloadkey ON (details.downloadkey = downloadkey.uniqueid), orders WHERE details.OrderID = '%s' AND orders.OrderID = details.OrderID AND details.details_id = %s", mysql_real_escape_string($_GET['orderid']), mysql_real_escape_string($_GET['orderdetailid']));

		$orderdetailsresult = mysql_query($orderdetailssql);

		$orderdetailsnumrows = mysql_num_rows($orderdetailsresult);

		if($orderdetailsnumrows > 0){

			$orderdetailsrow = mysql_fetch_assoc($orderdetailsresult);

		}

	}else{

		header("location:index.php");	

	}

}



?>

<div class="print_header"><img src="../../images/emaillogo.jpg" width="532" height="97" alt="Level Four Storefront"></div><div class="print_content"><?php echo $row_company['businessname']; ?><br><?php echo $row_company['contactaddress']; ?><br><?php echo $row_company['contactcity']; ?>, <?php echo $row_company['contactstate']; ?> <?php echo $row_company['contactzip']; ?><br><?php echo $row_company['contactphone']; ?></div>

<div class="dashboard_break"></div>

<div class="dashboard_left">

	<div class="dashboard_table_content">

    	<div><?php echo $orderrow['OrderStatus']; ?></div>

		<?php if($orderdetailsnumrows != 0){ $subtotal = 0; ?>

        		<div class="orderdetails_row">

                	<div class="orderdetails_column_wide">

                    	<img src="../../products/pics1/thumbnails/<?php $exploded = explode(".", $orderdetailsrow['Image1']); echo $exploded[0]; ?>_100x100.<?php echo $exploded[1]; ?>" alt="<?php echo $orderdetailsrow['OrderTitle']; ?>" class="orderdetails_image" />Card Number: <?php echo $orderdetailsrow['orderedItemCode']; ?><br />Recipient: <?php echo $orderdetailsrow['toname']; ?><br />From: <?php echo $orderdetailsrow['fromname']; ?><br /></div>

                    <div class="orderdetails_column_quantity"></div>

                    <div class="orderdetails_column_price"></div>

                </div>

                <div class="orderdetails_row">

                	<div class="orderdetails_column_wide"><?php echo $orderdetailsrow['message']; ?></div>

                </div>

			<div class="order_break"></div>

       <?php }else{ ?>

        	<div>No details available.</div>

        <?php } ?>

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