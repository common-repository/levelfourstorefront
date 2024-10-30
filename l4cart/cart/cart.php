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

?>

<?php

$subtotal = 0;
		
$shippable_subtotal = 0;

$discountable_subtotal = 0;

$taxable_subtotal = 0;

$totalproducts = 0;

$totalweight = 0;

$i=0;

$Cart = array();

?>

<div class="l4store_header">Cart (<?php echo $row_tempcart['totalitems']; ?> Item<?php if($row_tempcart['totalitems'] > 1){ echo "s"; } ?>)</div>

<div class="cart_header_row">

	<div class="cart_image_spacer"><div class="cart_image_text">Product</div></div>

    <div class="cart_unit_price_spacer">Unit Price</div>

    <div class="cart_quantity_spacer">Quantity</div>

    <div class="cart_total_spacer"><div class="cart_total_text">Total</div></div>

</div>

<?php $i=0; ?>

<?php while($row_cart = mysql_fetch_assoc($cart)){
	
	$thisitemprice = $row_cart['orderprice'];

	

	$subtotal = $subtotal + ($thisitemprice * $row_cart['quantity']);

	if( ($row_cart['isgiftcard'] && $row_cart['deliverymethod']) || (!$row_cart['isdownload'] && !$row_cart['isDonation'] && !$row_cart['isgiftcard']) ){

		$shippable_subtotal = $shippable_subtotal + ($thisitemprice * $row_cart['quantity']);

	}

	

	if(!$row_cart['isgiftcard'] && !$row_cart['isDonation']){

		$discountable_subtotal = $discountable_subtotal + ($thisitemprice * $row_cart['quantity']);

	}

	

	if( $row_cart['istaxable'] ){

		$taxable_subtotal = $taxable_subtotal + ($thisitemprice * $row_cart['quantity']);

	}

	$totalproducts = $totalproducts + $row_cart['quantity'];

	$totalweight = $totalweight + ( $row_cart['weight'] * $row_cart['quantity']);

	$i++;

	if($i%2 == 0){

	?>

	<div class="cart_item_row_even">

    <?php

	}else{?>

    <div class="cart_item_row_odd">

    <?php }?>

       <div class="cart_image">
			<?php if($row_cart['useoptionitemimages']){?>
            	<a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row_cart['ordermodelnumber']; ?>&catid=<?php echo $row_cart['orderoption1']; ?>">
                <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_small_width'); ?>_<?php echo get_option('l4_option_small_height'); ?>_<?php echo $row_cart['OptionItemImage1']; ?>" border="0" class="cart_image_border" />
                <?php }else{?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/images.php?max_width=<?php echo get_option('l4_option_small_width'); ?>&max_height=<?php echo get_option('l4_option_small_height'); ?>&imgfile=<?php echo $row_cart['OptionItemImage1']; ?>" border="0" class="cart_image_border" />
                <?php }?>
                </a>
			<?php }else{ ?>
             	<a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row_cart['ordermodelnumber']; ?>">
                <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_small_width'); ?>_<?php echo get_option('l4_option_small_height'); ?>_<?php echo $row_cart['image1']; ?>" border="0" class="cart_image_border" />
                <?php }else{?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/images.php?max_width=<?php echo get_option('l4_option_small_width'); ?>&max_height=<?php echo get_option('l4_option_small_height'); ?>&imgfile=<?php echo $row_cart['image1']; ?>" border="0" class="cart_image_border" />
                <?php }?>
                </a>
            <?php }?>
       </div>

       <div class="cart_info">

            <?php if($row_cart['useoptionitemimages']){?>
            	<div class="cart_title"><a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row_cart['ordermodelnumber']; ?>&catid=<?php echo $row_cart['orderoption1']; ?>" class="l4store_link"><?php echo $row_cart['ordertitle']; ?></a></div>
            <?php }else{ ?>
            	<div class="cart_title"><a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row_cart['ordermodelnumber']; ?>" class="l4store_link"><?php echo $row_cart['ordertitle']; ?></a></div>
            <?php }?>

            <?php if($row_cart['orderoption1']){?><div class="cart_option">Option 1: <?php echo $row_cart['option1name']; if($row_cart['option1price'] && $row_cart['option1price'] != "0.00"){ echo " (" . number_format($row_cart['option1price'], 2) . ")"; } ?></div><?php }?>

            <?php if($row_cart['orderoption2']){?><div class="cart_option">Option 2: <?php echo $row_cart['option2name']; if($row_cart['option2price'] && $row_cart['option2price'] != "0.00"){ echo " (" . number_format($row_cart['option2price'], 2) . ")"; } ?></div><?php }?>

            <?php if($row_cart['orderoption3']){?><div class="cart_option">Option 3: <?php echo $row_cart['option3name']; if($row_cart['option3price'] && $row_cart['option3price'] != "0.00"){ echo " (" . number_format($row_cart['option3price'], 2) . ")"; } ?></div><?php }?>

            <?php if($row_cart['orderoption4']){?><div class="cart_option">Option 4: <?php echo $row_cart['option4name']; if($row_cart['option4price'] && $row_cart['option4price'] != "0.00"){ echo " (" . number_format($row_cart['option4price'], 2) . ")"; } ?></div><?php }?>

            <?php if($row_cart['orderoption5']){?><div class="cart_option">Option 5: <?php echo $row_cart['option5name']; if($row_cart['option5price'] && $row_cart['option5price'] != "0.00"){ echo " (" . number_format($row_cart['option5price'], 2) . ")"; } ?></div><?php }?>

            <?php if($row_cart['message']){?><div class="cart_option">Message: <?php echo $row_cart['message']; ?></div><?php }?>

            <?php if($row_cart['message']){?><div class="cart_option">From: <?php echo $row_cart['fromname']; ?></div><?php }?>

            <?php if($row_cart['message']){?><div class="cart_option">To: <?php echo $row_cart['toname']; ?></div><?php }?>

            <?php if($row_cart['deliverymethod']){?><div class="cart_option">Delivery Method: <?php echo $row_cart['deliverymethod']; ?></div><?php }?>

        </div>

        <div class="cart_price"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($thisitemprice, 2); ?></div>  

		<div class="cart_quantity_info">

            <div class="cart_update">

                <form id="updateform" name="updateform" method="post" action="<?php echo $cartpage; ?>">

                    <input name="Quantity" type="text" id="Quantity_<?php echo $row_cart['tempcartid']; ?>" value="<?php echo $row_cart['quantity']; ?>" class="cart_quantity_input" />

                    <input type="hidden" name="tempcartid" id="tempcartid" value="<?php echo $row_cart['tempcartid']; ?>" />
                    
                    <input type="hidden" name="l4_action" value="updatecartitem" />
                    
                    <input type="hidden" name="confirmorder" value="<?php if(isset($_GET['confirmorder'])){ echo "true"; }else{ echo "false"; } ?>" />

                    <input type="submit" value="Update" <?php if($row_cart['isgiftcard'] == "1" || $row_cart['isdownload'] == "1"){ echo "class=\"hide_quantity\""; }else{?> class="l4store_button" style="width:100%;"<?php }?>/>

                </form>

            </div>

            <div class="cart_remove">

                <form id="removeform" name="removeform" method="post" action="<?php echo $cartpage; ?>">

                    <input type="submit" value="Remove" class="l4store_button" style="width:100%;" />
                    
                    <input type="hidden" name="l4_action" value="removecartitem" />
                    
                    <input type="hidden" name="confirmorder" value="<?php if(isset($_GET['confirmorder'])){ echo "true"; }else{ echo "false"; } ?>" />

                    <input type="hidden" name="regprice" id="regprice" value="<?php echo $row_cart['orderprice']; ?>" />

                    <input type="hidden" name="tempcartid" id="tempcartid" value="<?php echo $row_cart['tempcartid']; ?>" />

                </form>

            </div>

		</div>

        <div class="cart_total">

        	<div class="cart_total_text"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format(($row_cart['quantity']*$thisitemprice),2); ?></div>

        </div>

	</div>

<?php


	array_push($Cart, array('Title'=>$row_cart['ordertitle'], 'Price'=>number_format($thisitemprice*$row_cart['quantity'], 2), 'manufacturer'=>$row_cart['manufacturer'], 'Weight'=>$row_cart['weight']));

}

$SubtotalPrice = $subtotal;

$ShippingPrice = 0.00;

$ShippingType = "none";

if($row_settingsRS['shippingusedynamic'] == "1"){

	$shipxmldata = calculateshipping($Cart, $shippable_subtotal, $totalweight, "0", $_SESSION['ShippingCountry'], $_SESSION['ShippingZip']);
	
	if(!isset($_GET['confirmorder'])){
		$shipxmldata = array();
	}

	for($i=0; $i<count($shipxmldata); $i++){
		
		if( $_SESSION['ShippingRate'] == $shipxmldata[$i]['ServiceName'] ){ 

			$ShippingPrice = number_format($shipxmldata[$i]['Rate'], 2);

			$ShippingType = $shipxmldata[$i]['ServiceName'];

		}

	}

}else{

	$ShippingPrice = calculateshipping($Cart, $shippable_subtotal, $totalweight, $_SESSION['ShipExpress'], $_SESSION['ShippingCountry'], $_SESSION['ShippingZip']);

}

if($ShippingType != "none"){

	$ShippingMethod = $ShippingType;

}else if($_SESSION['ShipExpress']){

	$ShippingMethod = "Expedited Air Service";

}else{

	$ShippingMethod = "Standard Shipping";

}

//Get Coupon Discount
$couponDiscount = calculatecoupon($_SESSION['CouponCode'], $subtotal, $ShippingPrice, $Cart);

$isShipBasedCoupon = isShipBased($_SESSION['CouponCode']);

//Get Gift Card Discount
$giftCardDiscount = calculategiftcard($_SESSION['GiftCard'], $subtotal - $couponDiscount + $taxRate + $ShippingPrice);

//Add up discounts
$DiscountsPrice = $couponDiscount + $giftCardDiscount;

//Change taxable total to match discounts. If discount is applied to shipping, then we must tax on the order, 
//but if the discount is applied to the order then we must subtract that discount and then tax.
if($isShipBasedCoupon){
	$taxable_subtotal = $taxable_subtotal - $giftCardDiscount;
}else{
	$taxable_subtotal = $taxable_subtotal - $DiscountsPrice;
}

if($taxable_subtotal < 0){
	$taxable_subtotal = 0;
}

$TaxPrice = calculatetax($_SESSION['ShippingState'], $_SESSION['ShippingCountry'], $taxable_subtotal);

$GrandTotalPrice = $subtotal + $ShippingPrice + $TaxPrice - $DiscountsPrice;

?>

<?php if(isvalidcoupon($_SESSION['CouponCode'])){ ?>

<div class="cart_price_row">

	<div class="cart_message_spacer"><?php echo getcouponmessage($_SESSION['CouponCode']); ?></div>

</div>

<?php }else if(isset($_SESSION['CouponCode']) && $_SESSION['CouponCode'] != ""){?>

<div class="cart_price_row">

	<div class="cart_message_spacer">Coupon Code (<?php echo $_SESSION['CouponCode']; ?>) is Invalid</div>

</div>

<?php }?>

<?php if(isvalidgiftcard($_SESSION['GiftCard'])){ ?>

<div class="cart_price_row">

	<div class="cart_message_spacer"><?php echo getgiftcardmessage($_SESSION['GiftCard']); ?></div>

</div>

<?php }else if(isset($_SESSION['GiftCard']) && $_SESSION['GiftCard'] != ""){?>

<div class="cart_price_row">

	<div class="cart_message_spacer">Gift Card Code (<?php echo $_SESSION['GiftCard']; ?>) is Invalid</div>

</div>

<?php }?>

<div class="cart_price_row">

	<div class="cart_long_spacer">Subtotal:</div>

    <div class="cart_price_spacer"><div class="cart_total_text"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo number_format($SubtotalPrice, 2); ?></div></div>

</div>