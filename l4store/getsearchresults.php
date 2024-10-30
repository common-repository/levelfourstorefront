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

if (mysql_num_rows($result) > 0){ ?>

	<div class="search_block">

    	<div class="search_block_resultcount">

			Search Results for "<b><?php echo $_GET['s']; ?></b>"

		</div>

    </div>

	

	<?php while($row = mysql_fetch_assoc($result)){ ?>

    <div class="search_table_holder">

        <div class="search_bordertable">

            <div class="search_image">

            <a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row['ModelNumber']; ?><?php if($menulevel == 1){ echo "&amp;menuid=".$menu_row['keyfield']."&amp;menu=".sanatizeCategory($menu_row['menuName']); }else if($menulevel == 2){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2']); }else if($menulevel == 3){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;subsubmenuid=".$menu_row['keyfield3']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2'])."&amp;subsubmenu=".sanatizeCategory($menu_row['menuName3']); } ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; }?>" class="product_title_link">

                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_medium_width'); ?>_<?php echo get_option('l4_option_medium_height'); ?>_<?php echo $row['Image1']; ?>" class="product_image" alt="<?php echo $row['Title']; ?>" /></a>

            </div>

            <div class="search_info">

            	<a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row['ModelNumber']; ?><?php if($menulevel == 1){ echo "&amp;menuid=".$menu_row['keyfield']."&amp;menu=".sanatizeCategory($menu_row['menuName']); }else if($menulevel == 2){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2']); }else if($menulevel == 3){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;subsubmenuid=".$menu_row['keyfield3']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2'])."&amp;subsubmenu=".sanatizeCategory($menu_row['menuName3']); } ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; }?>" class="search_title_link"><?php echo $row['Title']; ?></a>

                <br />

				<?php if($row['ListPrice'] && $row['ListPrice'] != "0.00"){ ?>

                    <span class="oldprice">was $<?php echo $row['ListPrice']; ?></span><br />

                <?php } ?>

                $<?php echo $row['Price']; ?><br />

                <div class="star_align">

					<?php if($row['review_avg'] > .5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" /><?php }?>

                    <?php if($row['review_avg'] > 1.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" /><?php }?>

                    <?php if($row['review_avg'] > 2.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" /><?php }?>

                    <?php if($row['review_avg'] > 3.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" /><?php }?>

                    <?php if($row['review_avg'] > 4.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" /><?php }?>

                </div>

           </div>

        </div>

    </div>

	<?php } ?>

<?php }else{ ?>

  <div class="no_results">There are no results that fit your search criteria.</div>

<?php } ?>