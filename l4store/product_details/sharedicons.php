<?php 
	if(get_option('l4_option_use_facebook_icon')){?>
    <a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(str_replace(" ", "%20", $storepage . $permalinkdivider . "ModelNumber=" . $row_productRS['ModelNumber'])); ?>" target="_blank"><img src="<?php echo str_replace("l4store/", "", str_replace("levelfourstorefront/", "", plugin_dir_url(__DIR__))); ?>levelfourstorefront/images/facebook_20x20.png" alt="Facebook" class="product_details_shared_icon" title="Facebook" /></a> 
<?php }?>
    
<?php if(get_option('l4_option_use_twitter_icon')){?>
    <a href="http://twitter.com/intent/tweet?original_referer=<?php echo urlencode(str_replace(" ", "%20", $storepage . $permalinkdivider . "ModelNumber=" . $row_productRS['ModelNumber'])); ?>&source=tweetbutton&text=<?php echo urlencode($row_productRS['Title']); ?>&url=<?php echo urlencode(str_replace(" ", "%20", $storepage . $permalinkdivider . "ModelNumber=" . $row_productRS['ModelNumber'])); ?>" target="_blank"><img src="<?php echo str_replace("l4store/", "", str_replace("levelfourstorefront/", "", plugin_dir_url(__DIR__))); ?>levelfourstorefront/images/twitter_20x20.png" alt="Twitter" class="product_details_shared_icon" title="Twitter" /></a> 
<?php }?>

<?php if(get_option('l4_option_use_delicious_icon')){?>
    <a href="https://delicious.com/login?lo_action=save&amp;next=http%3A%2F%2Fdelicious.com%2Fpost%3Furl%3D<?php echo urlencode(str_replace(" ", "%20", $storepage . $permalinkdivider . "ModelNumber=" . $row_productRS['ModelNumber'])); ?>%3Flog%3Dout%26url%3D<?php echo urlencode(str_replace(" ", "%20", $storepage . $permalinkdivider . "ModelNumber=" . $row_productRS['ModelNumber'])); ?>" target="_blank"><img src="<?php echo str_replace("l4store/", "", str_replace("levelfourstorefront/", "", plugin_dir_url(__DIR__))); ?>levelfourstorefront/images/delicious_20x20.png" alt="Delicious" class="product_details_shared_icon" title="Delicious" /></a> 
<?php }?>

<?php if(get_option('l4_option_use_myspace_icon')){?>
    <a href="http://www.myspace.com/auth/loginform?dest=http%3a%2f%2fwww.myspace.com%2fModules%2fPostTo%2fPages%2fdefault.aspx%3fl%3d3%26u%3d<?php echo urlencode(str_replace(" ", "%20", $storepage . $permalinkdivider . "ModelNumber=" . $row_productRS['ModelNumber'])); ?>" target="_blank"><img src="<?php echo str_replace("l4store/", "", str_replace("levelfourstorefront/", "", plugin_dir_url(__DIR__))); ?>levelfourstorefront/images/myspace_20x20.png" alt="Myspace" class="product_details_shared_icon" title="Myspace" /></a> 
<?php }?>

<?php if(get_option('l4_option_use_linkedin_icon')){?>
    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(str_replace(" ", "%20", $storepage . $permalinkdivider . "ModelNumber=" . $row_productRS['ModelNumber'])); ?>" target="_blank"><img src="<?php echo str_replace("l4store/", "", str_replace("levelfourstorefront/", "", plugin_dir_url(__DIR__))); ?>levelfourstorefront/images/linkedin_20x20.png" alt="Linked In" class="product_details_shared_icon" title="Linkedin" /></a>  
<?php }?>

<?php if(get_option('l4_option_use_email_icon')){?>
    <a href="mailto:?subject=<?php echo str_replace(" ", "%20", ucwords($row_companyRS['businessname'])); ?>,%20Product%20<?php echo urlencode(str_replace(" ", "%20", $row_productRS['ModelNumber'])); ?>&amp;body=<a%20href='<?php echo urlencode(str_replace(" ", "%20", $storepage . $permalinkdivider . "ModelNumber=" . $row_productRS['ModelNumber'])); ?>'><?php echo htmlspecialchars($row_productRS['Title']); ?></a>"><img src="<?php echo str_replace("l4store/", "", str_replace("levelfourstorefront/", "", plugin_dir_url(__DIR__))); ?>levelfourstorefront/images/email_20x20.png" alt="Email" class="product_details_shared_icon" title="Email" /></a>  
<?php }?>

<?php if(get_option('l4_option_use_digg_icon')){?>
    <a href="http://digg.com/submit?phase=2&amp;url=<?php echo urlencode(str_replace(" ", "%20", $storepage . $permalinkdivider . "ModelNumber=" . $row_productRS['ModelNumber'])); ?>" target="_blank"><img src="<?php echo str_replace("l4store/", "", str_replace("levelfourstorefront/", "", plugin_dir_url(__DIR__))); ?>levelfourstorefront/images/Digg_20x20.png" alt="Digg" class="product_details_shared_icon" title="Digg" /></a> 
<?php }?>

<?php if(get_option('l4_option_use_googleplus_icon')){?>
    <a href="https://plus.google.com/share?url=<?php echo urlencode(str_replace(" ", "%20", $storepage . $permalinkdivider . "ModelNumber=" . $row_productRS['ModelNumber'])); ?>" target="_blank"><img src="<?php echo str_replace("l4store/", "", str_replace("levelfourstorefront/", "", plugin_dir_url(__DIR__))); ?>levelfourstorefront/images/google_plus_20x20.png" alt="Google Plus" class="product_details_shared_icon" title="Google Plus" /></a> 
<?php } ?>

<?php if(get_option('l4_option_use_pinterest_icon')){?>
    <a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(str_replace(" ", "%20", $storepage . $permalinkdivider . "ModelNumber=" . $row_productRS['ModelNumber'])); ?>" target="_blank"><img src="<?php echo str_replace("l4store/", "", str_replace("levelfourstorefront/", "", plugin_dir_url(__DIR__))); ?>levelfourstorefront/images/pinterest_20x20.png" alt="Google Plus" class="product_details_shared_icon" title="Pinterest" /></a> 
<?php } ?>