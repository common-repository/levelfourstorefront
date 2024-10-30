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

$simp_sql = sprintf("SELECT 

	  reviews.reviewapproved,

	  AVG(reviews.rating) AS review_avg,

	  COUNT(reviews.reviewID) AS review_count,

	  products.*,

	  statistics.views

	FROM

	  products

	  LEFT JOIN reviews ON (reviews.productID = products.ProductID AND (reviews.reviewapproved = 1 OR reviews.reviewapproved IS NULL))

	  LEFT JOIN statistics ON (statistics.ProductID = products.ProductID)

	WHERE
	
	  products.ModelNumber = '%s'", mysql_real_escape_string($simp_product_id));
	  
$simp_result = mysql_query($simp_sql);

$row = mysql_fetch_assoc($simp_result);

?>

<style>
.prod_table_holder{
	width: <?php echo $row_settingsRS['medium_width'] + 10; ?>px;
	float:left;
}
.bordertable {
	width: <?php echo $row_settingsRS['medium_width'] + 10; ?>px;
	border: none;
	font-family:Tahoma, Geneva, sans-serif;
	font-size:12px;
	text-align:center;
}
</style>

<div class="prod_table_holder">

    <div class="bordertable">

        <div class="product_image_row">

            <?php 

                if($row['useoptionitemimages']){

                    $optionitems_sql = sprintf("SELECT optionitems.*, optionitemimages.Image1 FROM optionitems, optionitemimages WHERE optionitems.optionparentID = '%s' AND optionitemimages.optionitemID = optionitems.optionitemID AND optionitemimages.productID = '%s' ORDER BY optionitems.optionorder", $row['option1'], $row['ProductID']);

                    $optionitems = mysql_query($optionitems_sql);

                    $numoptionitems = mysql_num_rows($optionitems);

                    $i=0;

                    while($optionitem = mysql_fetch_assoc($optionitems)){ 

                        if($i > 0){ echo "<div class=\"inactive\" id=\"optionitemimage_".$row['ProductID']."_".$i."\">"; }else{ echo "<div id=\"optionitemimage_".$row['ProductID']."_".$i."\">"; }

                    ?>

                        <a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row['ModelNumber']; ?>&amp;catid=<?php echo $optionitem['optionitemID']; ?><?php if($menulevel == 1){ echo "&amp;menuid=".$menu_row['keyfield']."&amp;menu=".sanatizeCategory($menu_row['menuName']); }else if($menulevel == 2){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2']); }else if($menulevel == 3){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;subsubmenuid=".$menu_row['keyfield3']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2'])."&amp;subsubmenu=".sanatizeCategory($menu_row['menuName3']); } ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; }?>" class="product_title_link">

                        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_medium_width'); ?>_<?php echo get_option('l4_option_medium_height'); ?>_<?php echo $optionitem['Image1']; ?>" class="product_image" alt="<?php echo $row['ModelNumber']; ?>" border="0" />

                        </a>

                    </div>

                    <?php

                    $i++; 

                    }

                }else{

            ?>

                    <a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row['ModelNumber']; ?><?php if($menulevel == 1){ echo "&amp;menuid=".$menu_row['keyfield']."&amp;menu=".sanatizeCategory($menu_row['menuName']); }else if($menulevel == 2){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2']); }else if($menulevel == 3){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;subsubmenuid=".$menu_row['keyfield3']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2'])."&amp;subsubmenu=".sanatizeCategory($menu_row['menuName3']); } ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; }?>" class="product_title_link">

                        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_medium_width'); ?>_<?php echo get_option('l4_option_medium_height'); ?>_<?php echo $row['Image1']; ?>" class="product_image" alt="<?php echo $row['Title']; ?>" border="0" />

                    </a>

            <?php 

                }

            ?>

        </div>

        <div class="product_text_row">

            <div class="product_title_column">

                <div class="star_align">

                    <?php if($row['review_avg'] > .5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" alt="Star" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" alt="Off" /><?php }?>

                    <?php if($row['review_avg'] > 1.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" alt="Star" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" alt="Off" /><?php }?>

                    <?php if($row['review_avg'] > 2.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" alt="Star" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" alt="Off" /><?php }?>

                    <?php if($row['review_avg'] > 3.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" alt="Star" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" alt="Off" /><?php }?>

                    <?php if($row['review_avg'] > 4.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" alt="Star" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" alt="Off" /><?php }?>

                </div>

                <div class="product_title_align">

                    <a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row['ModelNumber']; ?><?php if($menulevel == 1){ echo "&amp;menuid=".$menu_row['keyfield']."&amp;menu=".sanatizeCategory($menu_row['menuName']); }else if($menulevel == 2){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2']); }else if($menulevel == 3){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;subsubmenuid=".$menu_row['keyfield3']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2'])."&amp;subsubmenu=".sanatizeCategory($menu_row['menuName3']); } ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; }?>" class="l4store_link"><?php echo $row['Title']; ?>

                    </a>

                </div>

            </div>

            <div class="product_price_column">

                    <?php if($row['ListPrice'] && $row['ListPrice'] != "0.00"){ ?>

                        <span class="oldprice"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo $row['ListPrice']; ?></span><br />

                        <span class="newprice"><sup><?php echo $row_settingsRS['currencySymbol']; ?></sup><?php echo substr($row['Price'], 0, -3); ?><sup><?php echo substr($row['Price'], -2, 2); ?></sup></span>

                    <?php }else{?>

                        <br />

                        <span class="regularprice"><sup><?php echo $row_settingsRS['currencySymbol']; ?></sup><?php echo substr($row['Price'], 0, -3); ?><sup><?php echo substr($row['Price'], -2, 2); ?></sup></span>

                    <?php }?>

            </div>

            <?php if($row['useoptionitemimages']){ ?>

                <?php 	$optionitems_sql = sprintf("SELECT optionitems.* FROM optionitems WHERE optionitems.optionparentID = '%s' ORDER BY optionitems.optionorder", $row['option1']);

                        $optionitems = mysql_query($optionitems_sql); ?>

            <div class="product_title_column">			

                <div class="product_swatch_align">

                    <?php $i=0; $usedActive=0; $jsactivecode = ""; while($optionitem = mysql_fetch_assoc($optionitems)){?>

                        <?php 

                            $optionitemquantity_sql = sprintf("SELECT SUM(optionitemquantity.Quantity) AS Quantity FROM optionitemquantity WHERE OptionItemID1 = '%s' AND ProductID = '%s'", $optionitem['optionitemID'], $row['ProductID']); 

                            $optionitemquantity_result = mysql_query($optionitemquantity_sql);

                            $optionitemquantity_row = mysql_fetch_assoc($optionitemquantity_result);

                            $optionitemquantity = $optionitemquantity_row['Quantity'];

                        ?>

                        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/swatches/thumb_<?php echo get_option('l4_option_swatch_small_width'); ?>_<?php echo get_option('l4_option_swatch_small_height'); ?>_<?php echo $optionitem['optionitemicon']; ?>" alt="<?php echo $optionitem['optionitemname']; ?>"<?php 
                        if($row['useQuantityTracking'] && $optionitemquantity == 0){ 
                            echo " class=\"swatch_img_out_of_stock\""; 
                        }else if($usedActive == 0 && $row['useQuantityTracking'] && $optionitemquantity > 0){ 
                            $usedActive=1; 
                            $jsactivecode="swapproductimages('".$row['ProductID']."', '".$i."', '".$numoptionitems."');"; 
                            echo " class=\"swatch_img_active\"";
                        }else if(!$row['useQuantityTracking'] && $usedActive == 0){ 
                            $usedActive=1; 
                            $jsactivecode="swapproductimages('".$row['ProductID']."', '".$i."', '".$numoptionitems."');"; 
                            echo " class=\"swatch_img_active\""; 
                        }else{
                            ?>  class="swatch_img"<?php }?><?php if(!$row['useQuantityTracking'] || $optionitemquantity > 0){?> onclick="swapproductimages('<?php echo $row['ProductID']; ?>', '<?php echo $i; ?>', '<?php echo $numoptionitems; ?>');"<?php 
                        }?> id="swatch_<?php echo $row['ProductID']; ?>_<?php echo $i; ?>" />

                    <?php $i++; }?>

                </div>

            </div>

            <script>

            <?php echo $jsactivecode; ?>

            </script>

            <?php }?>

        </div>
        
  </div>

</div>