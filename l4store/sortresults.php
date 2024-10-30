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

<div style="width:185px">

    <div class="sort_products_header"><?php echo get_option('l4_option_categories_title'); ?></div>
    
    <div class="sort_products_content" id="sort_categories">
    
        <?php include "getsortcategories.php"; ?>
    
    </div>
    
    <div class="sort_products_header"><?php echo get_option('l4_option_manufacturers_title'); ?></div>
    
    <div class="sort_products_content" id="sort_manufacturers">
    
        <?php include "getsortmanufacturers.php"; ?>
    
    </div>
    
    <div class="sort_products_header"><?php echo get_option('l4_option_pricepoints_title'); ?></div>
    
    <div class="sort_products_content" id="sort_pricepoints">
    
        <?php include "getsortpricepoints.php"; ?>
    
    </div>
</div>