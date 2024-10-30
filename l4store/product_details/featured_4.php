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

<?php if($row_productRS['featureproduct4'] != "0" && isset($row_featured4['Image1'])){?>

<div class="featureditemtext">

    <div class="featureditem_holder">

        <?php 
			if($row_featured4['useoptionitemimages']){
				if($row_featured4['useQuantityTracking']){
					$randimg1sql = sprintf("SELECT optionitemimages.Image1, optionitemimages.optionitemID, optionitemquantity.Quantity FROM optionitemimages, optionitemquantity WHERE optionitemimages.productID = '%s' AND optionitemquantity.OptionItemID1 = optionitemimages.optionitemID AND optionitemquantity.ProductID = optionitemimages.productID AND optionitemquantity.Quantity > 0", $row_featured4['ProductID']);
				}else{
					$randimg1sql = sprintf("SELECT optionitemimages.Image1, optionitemimages.optionitemID, 1 as Quantity FROM optionitemimages WHERE optionitemimages.productID = '%s'", $row_featured4['ProductID']);
				}
				$randimg1result = mysql_query($randimg1sql);
				$randimg1numrows = mysql_num_rows($randimg1result);
				$randimg1num = rand(1, $randimg1numrows);
				
				$i=1;
				$featuredImage1 = "";
				$featuredOptionItemID1 = "";
				
				while($randimg1 = mysql_fetch_assoc($randimg1result)){ 
					if( $i == $randimg1num ){ 
						$featuredImage1 = $randimg1['Image1']; $featuredOptionItemID1 = $randimg1['optionitemID']; 
					} 
					
					$i++; 
				}
			?>
            	<div class="floatleft">
                <a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row_featured4['ModelNumber']; ?>&catid=<?php echo $featuredOptionItemID1; ?>">
                <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_small_width'); ?>_<?php echo get_option('l4_option_small_height'); ?>_<?php echo $featuredImage1; ?>" alt="<?php echo $row_featured4['Title']; ?>" class="imgfloatleft" />
                <?php }else{?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/images.php?max_width=<?php echo get_option('l4_option_small_width'); ?>&max_height=<?php echo get_option('l4_option_small_height'); ?>&imgfile=<?php echo $featuredImage1; ?>" alt="<?php echo $row_featured4['Title']; ?>" class="imgfloatleft" />
                <?php }?>
                </a>
				</div>
				<div class="floatleft">
				<?php echo "<a href=\"".$storepage . $permalinkdivider . "ModelNumber=" . $row_featured4['ModelNumber'] . "&catid=" . $featuredOptionItemID1 . "\" class=\"l4store_link\">" . $row_featured4['Title'] . "</a>"; ?><br /><?php
			}else{ 
			?>
            	<div class="floatleft">
            	<a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row_featured4['ModelNumber']; ?>">
                <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_small_width'); ?>_<?php echo get_option('l4_option_small_height'); ?>_<?php echo $row_featured4['Image1']; ?>" alt="<?php echo $row_featured4['Title']; ?>" class="imgfloatleft" />
                <?php }else{ ?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/images.php?max_width=<?php echo get_option('l4_option_small_width'); ?>&max_height=<?php echo get_option('l4_option_small_height'); ?>&imgfile=<?php echo $row_featured4['Image1']; ?>" alt="<?php echo $row_featured4['Title']; ?>" class="imgfloatleft" />
                <?php }?>
                </a>
				</div>
				<div class="floatleft">
				<?php echo "<a href=\"".$storepage . $permalinkdivider . "ModelNumber=" . $row_featured4['ModelNumber'] . "\" class=\"l4store_link\">" . $row_featured4['Title'] . "</a>"; ?><br /><?php } ?>

        <?php echo "<b>" . $row_settingsRS['currencySymbol'] . $row_featured4['Price'] . "</b><br>"; ?>

        <div class="floatleft">
        <div class="prod_details_stars">
        <?php if($row_featured4['review_avg'] > .5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" /><?php }?>
        <?php if($row_featured4['review_avg'] > 1.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" /><?php }?>
        <?php if($row_featured4['review_avg'] > 2.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" /><?php }?>
        <?php if($row_featured4['review_avg'] > 3.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" /><?php }?>
        <?php if($row_featured4['review_avg'] > 4.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" /><?php }?></div> <div class="total_reviews">(<?php echo $row_featured4['total_reviews']; ?>)</div></div>
		
        </div>
    
    </div>

</div>

<?php }?>