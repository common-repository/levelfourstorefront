	<?php 

$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";
	
$settingsRS = mysql_query($query_settingsRS);

$row_settingsRS = mysql_fetch_assoc($settingsRS);

$storepageid = get_option('l4_option_storepage');
	
$cartpageid = get_option('l4_option_cartpage');

$accountpageid = get_option('l4_option_accountpage');

$storepage = get_permalink( $storepageid );

$cartpage = get_permalink( $cartpageid );

$accountpage = get_permalink( $accountpageid );

if(substr_count($storepage, '?')){

	$permalinkdivider = "&";

}else{

	$permalinkdivider = "?";

}

include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/scripts/l4html/l4store_cart.php");

require_once( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/scripts/shipping/ShipRateAPI.inc");

include( WP_PLUGIN_DIR . "/" . L4_PLUGIN_DIRECTORY . '/scripts/l4html/l4store_error_codes.php' );

if(userloggedin()){

	$accountinfosql=sprintf("SELECT * FROM clients WHERE Email='%s' and Password='%s'", mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']));

	$accountinforesult=mysql_query($accountinfosql);

	$accountinforow = mysql_fetch_assoc($accountinforesult);
	
	$accountinfototalrows=mysql_num_rows($accountinforesult);


	$countriessql="SELECT * FROM countries ORDER BY countries.name_cnt";

	$countriesresult=mysql_query($countriessql);

	$countriesresult2=mysql_query($countriessql);


	$statessql="SELECT * FROM states WHERE idcnt_sta = '223' ORDER BY states.name_sta";

	$statesresult=mysql_query($statessql);

	$statesresult2=mysql_query($statessql);

}

$query_tempcart = sprintf("SELECT SUM(tempcart.quantity) as totalitems, SUM(tempcart.orderprice * tempcart.quantity) as subtotal FROM tempcart WHERE sessionid = '%s'", mysql_real_escape_string(session_id()));	

$tempcart = mysql_query($query_tempcart);	

$row_tempcart = mysql_fetch_assoc($tempcart);

?>

<div id="cart_content_holder">

	<?php if(isset($_GET['confirmorder']) && $_GET['confirmorder'] == "true"){?>

        <div id="checkout_errors"><?php include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/errors.php"); ?></div>

        <div id="errortext" class="errortext_full">Please make corrections to the highlighted fields.</div>

        <?php if($cart_numrows != 0){ ?>

        	<div id="cart"><?php include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/cart.php"); ?></div>

            <?php 

            $shippingRate = 0;

            $shippingType = "None";

            if($_POST['usedynamic'] == "1"){

                $shipxmldata = calculateshipping($Cart, $shippable_subtotal, $totalweight, "0", $_SESSION['ShippingCountry'], $_SESSION['ShippingZip']);

                for($i=0; $i<count($shipxmldata); $i++){

                    if( $_POST['shippingRate'] == $shipxmldata[$i]['ServiceName'] ){ 

                        $shippingRate = $shipxmldata[$i]['Rate'];

                        $shippingType = $shipxmldata[$i]['ServiceName'];

                    }

                }

            }
			
			include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/pricing_details.php"); ?>

            <form id="order_form" name="order_form" method="post" action="<?php echo $cartpage; ?>">
            
            	<input type="hidden" value="<?php echo $ShippingMethod; ?>" name="ShippingRate" />

                <?php include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/review_step.php"); ?>

                <?php include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/payment_information.php"); ?>

                <?php include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/contact_information.php"); ?>

                <?php if($_SESSION['l4userlevel'] == "guest"){ ?>	

                    <?php include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/create_account.php"); ?>

                <?php }?>

                <?php include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/submit_order.php"); ?>

            </form>

        <?php }else{?>

            <div>Your Cart is Empty</div>

        <?php }?>

	<?php }else{ ?>

		<?php if(isset($_GET['errorcode'])){?>

        <div class="error"><?php echo $L4ErrorCodes[$_GET['errorcode']]; ?></div>

		<?php }?>

        <?php if($cart_numrows != 0){ ?>
        
        	<?php if(isset($_GET['addtocart']) && $_GET['addtocart'] == "true"){ ?>
            
            	<div id="cart"><?php include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/cart.php"); ?></div>	
				
				<?php include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/continue_shopping.php"); ?>
            
			<?php }else{?>

                <div id="cart"><?php include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/cart.php"); ?></div>
    
                <div id="errortext" class="errortext_full">Please make corrections to the highlighted fields.</div>
    
                <?php if(!userloggedin()){?>
    
                    <?php include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/login.php"); ?>
    
                <?php }else{ ?>
    
                    <form id="order_form" name="order_form" method="post" action="<?php echo $cartpage . $permalinkdivider; ?>confirmorder=true">
                    
                        <input type="hidden" name="l4_action" value="confirmorder" />
    
                        <input type="hidden" name="AcceptedCouponCode" id="AcceptedCouponCode" value="<?php echo $_SESSION['currcouponcode']; ?>" />
    
                        <?php 
    
                        include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/login_complete.php");  
    
                        include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/billing_shipping_container.php");
    
                        include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/shipping_method.php");
    
                        include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/coupon_code.php");
    
                        include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/gift_card.php");
    
                        include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4cart/cart/continue_checkout.php"); ?>
    
                    </form>
    
                <?php }?>
                
            <?php }?>

        <?php }else{?>

            <div class="no_results">Your Cart is Empty</div><div class="push"></div>

        <?php }?>

	<?php } ?>

</div>