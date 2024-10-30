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

<?php if ($row_productRS['allowreviews'] != 0) { ?>
    
    <div id="review_success">Your review was submitted successfully. Once reviewed for content it will be posted to this page.</div>

    <div id="review_failed">We are sorry, but an error occurred while submitting your review. Please try again later.</div>
	
	<?php if($row_productRS['allowreviews']){?> <input type="button" value="Review This Product" onclick="showreview('<?php echo $row_productRS['ModelNumber'] ?>')" class="l4store_button" style="float:right;" /><?php }?>
    
    <?php if($reviews_numrows > 0){?>
    
        <?php while($reviews_row = mysql_fetch_assoc($reviews)){?>
    
            <div class="divider"></div>
    
            <p><?php echo "<b>" . $reviews_row['reviewtitle'] . "</b>"; ?></p>
    
             <div class="prod_details_stars">

			<?php if($reviews_row['rating'] > .5){?><img src="<?php echo getProtocol() . $row_settingsRS['siteURL']; ?>/images/star-on.png" /><?php }else{?><img src="<?php echo getProtocol() . $row_settingsRS['siteURL']; ?>/images/star-off.png" /><?php }?>

            <?php if($reviews_row['rating'] > 1.5){?><img src="<?php echo getProtocol() . $row_settingsRS['siteURL']; ?>/images/star-on.png" /><?php }else{?><img src="<?php echo getProtocol() . $row_settingsRS['siteURL']; ?>/images/star-off.png" /><?php }?>

            <?php if($reviews_row['rating'] > 2.5){?><img src="<?php echo getProtocol() . $row_settingsRS['siteURL']; ?>/images/star-on.png" /><?php }else{?><img src="<?php echo getProtocol() . $row_settingsRS['siteURL']; ?>/images/star-off.png" /><?php }?>

            <?php if($reviews_row['rating'] > 3.5){?><img src="<?php echo getProtocol() . $row_settingsRS['siteURL']; ?>/images/star-on.png" /><?php }else{?><img src="<?php echo getProtocol() . $row_settingsRS['siteURL']; ?>/images/star-off.png" /><?php }?>

            <?php if($reviews_row['rating'] > 4.5){?><img src="<?php echo getProtocol() . $row_settingsRS['siteURL']; ?>/images/star-on.png" /><?php }else{?><img src="<?php echo getProtocol() . $row_settingsRS['siteURL']; ?>/images/star-off.png" /><?php }?></div>

            <div class="floatleft"><?php echo nl2br($reviews_row['reviewdescription']); ?></div>
            
            <div class="clear"></div>
    
        <?php }?>
    
    <?php }else{?>
    
    <p>No Reviews Available</p>
    
    <?php }?>

<?php }?>