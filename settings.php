<?php 

require_once(WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/scripts/l4html/validation.php");

$validate = new Validate;

if(isset($_POST['isupdate'])){
	
	//update the data
	//$sql = sprintf("UPDATE settings SET sideMenuOnProducts = '%s', sideMenuOnProductDetails = '%s', storepage='%s', cartpage = '%s', accountpage = '%s'", mysql_real_escape_string($_POST['sideMenuOnProducts']), mysql_real_escape_string($_POST['sideMenuOnProductDetails']), mysql_real_escape_string($_POST['storepage']), mysql_real_escape_string($_POST['cartpage']), mysql_real_escape_string($_POST['accountpage']));
	//mysql_query($sql); 
	
	//update options
	update_option( 'l4_option_storepage', $_POST['l4_option_storepage'] );
	update_option( 'l4_option_cartpage', $_POST['l4_option_cartpage'] );
	update_option( 'l4_option_accountpage', $_POST['l4_option_accountpage'] );
	update_option( 'l4_option_sideMenuOnProducts', $_POST['l4_option_sideMenuOnProducts'] );
	update_option( 'l4_option_sideMenuOnProductDetails', $_POST['l4_option_sideMenuOnProductDetails'] );
	update_option( 'l4_option_stylesheettype', $_POST['l4_option_stylesheettype'] );
	update_option( 'l4_option_googleanalyticsid', $_POST['l4_option_googleanalyticsid'] );
	update_option( 'l4_option_num_prods_per_row', $_POST['l4_option_num_prods_per_row'] );
	update_option( 'l4_option_button_color1', $_POST['l4_option_button_color1'] );
	update_option( 'l4_option_button_color2', $_POST['l4_option_button_color2'] );
	update_option( 'l4_option_button_font_color', $_POST['l4_option_button_font_color'] );
	update_option( 'l4_option_button_color1_hover', $_POST['l4_option_button_color1_hover'] );
	update_option( 'l4_option_button_color2_hover', $_POST['l4_option_button_color2_hover'] );
	update_option( 'l4_option_button_font_color_hover', $_POST['l4_option_button_font_color_hover'] );
	update_option( 'l4_option_header_color1', $_POST['l4_option_header_color1'] );
	update_option( 'l4_option_header_color2', $_POST['l4_option_header_color2'] );
	update_option( 'l4_option_header_font_color', $_POST['l4_option_header_font_color'] );
	update_option( 'l4_option_title_font_color', $_POST['l4_option_title_font_color'] );
	update_option( 'l4_option_link_font_color', $_POST['l4_option_link_font_color'] );
	update_option( 'l4_option_link_font_color_hover', $_POST['l4_option_link_font_color_hover'] );
	update_option( 'l4_option_categories_title', $_POST['l4_option_categories_title'] );
	update_option( 'l4_option_manufacturers_title', $_POST['l4_option_manufacturers_title'] );
	update_option( 'l4_option_pricepoints_title', $_POST['l4_option_pricepoints_title'] );
	update_option( 'l4_option_guest_text', $_POST['l4_option_guest_text'] );
	update_option( 'l4_option_submit_order_text', $_POST['l4_option_submit_order_text'] );
	update_option( 'l4_option_xsmall_width', $_POST['l4_option_xsmall_width'] );
	update_option( 'l4_option_xsmall_height', $_POST['l4_option_xsmall_height'] );
	update_option( 'l4_option_small_width', $_POST['l4_option_small_width'] );
	update_option( 'l4_option_small_height', $_POST['l4_option_small_height'] );
	update_option( 'l4_option_medium_width', $_POST['l4_option_medium_width'] );
	update_option( 'l4_option_medium_height', $_POST['l4_option_medium_height'] );
	update_option( 'l4_option_large_width', $_POST['l4_option_large_width'] );
	update_option( 'l4_option_large_height', $_POST['l4_option_large_height'] );
	update_option( 'l4_option_swatch_small_width', $_POST['l4_option_swatch_small_width'] );
	update_option( 'l4_option_swatch_small_height', $_POST['l4_option_swatch_small_height'] );
	update_option( 'l4_option_swatch_large_width', $_POST['l4_option_swatch_large_width'] );
	update_option( 'l4_option_swatch_large_height', $_POST['l4_option_swatch_large_height'] );
	update_option( 'l4_option_use_facebook_icon', $_POST['l4_option_use_facebook_icon'] );
	update_option( 'l4_option_use_twitter_icon', $_POST['l4_option_use_twitter_icon'] );
	update_option( 'l4_option_use_delicious_icon', $_POST['l4_option_use_delicious_icon'] );
	update_option( 'l4_option_use_myspace_icon', $_POST['l4_option_use_myspace_icon'] );
	update_option( 'l4_option_use_linkedin_icon', $_POST['l4_option_use_linkedin_icon'] );
	update_option( 'l4_option_use_email_icon', $_POST['l4_option_use_email_icon'] );
	update_option( 'l4_option_use_digg_icon', $_POST['l4_option_use_digg_icon'] );
	update_option( 'l4_option_use_googleplus_icon', $_POST['l4_option_use_googleplus_icon'] );
	update_option( 'l4_option_use_pinterest_icon', $_POST['l4_option_use_pinterest_icon'] );
	update_option( 'l4_option_use_pretty_image_names', $_POST['l4_option_use_pretty_image_names'] );
	
	//Check and add a shortcode to a page (Simplifies the process!
	$storepage_data = get_page( $_POST['l4_option_storepage'] );
	if(!strstr($storepage_data, "[l4store]")){
		$storepage_data = "[l4store]" . $storepage_data;
		update_page( $_POST['l4_option_storepage'], $storepage_data);
	}
	
	$cartpage_data = get_page( $_POST['l4_option_cartpage'] );
	if(!strstr($cartpage_data, "[l4cart]")){
		$cartpage_data = "[l4cart]" . $cartpage_data;
		update_page( $_POST['l4_option_cartpage'], $cartpage_data);
	}
	
	$accountpage_data = get_page( $_POST['l4_option_accountpage'] );
	if(!strstr($accountpage_data, "[l4account]")){
		$accountpage_data = "[l4account]" . $accountpage_data;
		update_page( $_POST['l4_option_accountpage'], $accountpage_data);
	}
	
}else if(isset($_POST['isinsertdemodata'])){
	//INSERT DEMO DATA HERE
	//Put up the databse for website
	$url = plugin_dir_path(__FILE__) . '/scripts/sql/demo.sql';
	// Load and explode the sql file
	$f = fopen($url, "r+") or die("CANNOT OPEN SQL SCRIPT");
	$sqlFile = fread($f, filesize($url));
	$sqlArray = explode(';', $sqlFile);
	   
	//Process the sql file by statements
	foreach ($sqlArray as $stmt) {
	if (strlen($stmt)>3){
		$result = mysql_query($stmt);
		  if (!$result){
			 $sqlErrorCode = mysql_errno();
			 $sqlErrorText = mysql_error();
			 $sqlStmt      = $stmt;
			 break;
		  }
	   }
	} 
	
	//COPY PRODUCTS HERE
	copy("http://www.levelfourstorefront.com/downloads/wordpress/demo.zip", plugin_dir_path(__FILE__) . "/demo.zip");
	
	$zip = new ZipArchive;
	$res = $zip->open(plugin_dir_path(__FILE__) . "/demo.zip");
	if ($res === TRUE) {
		$zip->extractTo(plugin_dir_path(__FILE__) . "/");
		$zip->close();
	} else {
		echo 'Unzip Failed';
	}
	
}

//get the current settings
$sql = "SELECT * FROM settings";
$result = mysql_query($sql);
$settings = mysql_fetch_assoc($result);

?>
<style>
.l4contentwrap{
	padding-left:30px;	
}

.settings_color_swatch{
	width:15px;
	height:15px;
	border:1px solid #000;
	float:left;
	margin-right:5px;
}


.ribbon{
    text-align: center;
    position: relative;
    color: #fff; 
    font-weight:bold;   
    font-size:14px;
    margin: 0 0 15px -30px;
    padding: 10px 20px 10px 20px; 
    text-shadow: 0 1px rgba(0,0,0,.8);
    background: #119cf9;
    background-image: -ms-linear-gradient(top left, #119cf9 0%, #1376b8 100%);
    background-image: -moz-linear-gradient(#119cf9, #1376b8);
    background-image: -webkit-linear-gradient(#119cf9, #1376b8);
    background-image: -o-linear-gradient(#119cf9, #1376b8);
    background-image:  linear-gradient(#119cf9, #1376b8);
    -moz-box-shadow: 0 2px 0 rgba(0,0,0,.3);
    -webkit-box-shadow: 0 2px 0 rgba(0,0,0,.3);
    box-shadow: 0 2px 0 rgba(0,0,0,.3);
}
    
.ribbon:before{
    content: '';
    position: absolute;
    border-style: solid;
    border-color: transparent;
    bottom: -10px;
}
    
.ribbon:before{
    border-width: 0 10px 10px 0;
    border-right-color: #222;
    left: 0;
}
    
.ribbon:after{
    border-width: 0 0 10px 10px;
    border-left-color: #222;
    right: 0;
}

.ribbon a:link, .ribbon a:active, .ribbon a:visited{
    color:#EEEEEE;
}

.ribbon a:hover{
    color:#FFFFFF;
}
</style>

<div class="wrap">
<?php if(!$validate->validated($settings['regcode'])){ ?>
<div class="ribbon">This is the Level Four Storefront WordPress Shopping Cart Plugin FREE EDITION. In this edition you will need to MANUALLY BILL customers for orders. The Free Edition INCLUDES complete access to listing products, adding products to a cart, creating orders, collecting customer information, managing accounts, and much more. The Free Edition DOES NOT use any payment gateway such as PayPal, Authorize.net, Chronopay, Versapay, Eway, Paypoint, Firstdata, or Payment Express. To add payment gateway integration you will need to buy our <a href="https://levelfourstorefront.com/store/?ModelNumber=prod315" target="_blank">Standard Edition Here</a> and get a registration code from us through our <a href="http://www.levelfourdevelopment.com/support/index.php?/LevelFourStore/Tickets/Submit" target="_blank">support ticket system</a>.</div>
<?php }?>
<img src="<?php echo plugins_url('images/l4logo.png', __FILE__); ?>" />
<div class="l4contentwrap">
    <?php if(isset($_POST['isinsertdemodata'])){?>
    <p style="width:100%; background:#093; color:#FFF; padding:5px;"><b>Demo Data Installed Successfully! Some server settings prevent our demo product images from being installed correctly. If you do not see the product images on the store now, then please download product images, color swatches, and demo downloads <a href="http://www.levelfourstorefront.com/downloads/wordpress/demo.zip" target="_blank" style="color:#FFF;">here</a>. Once downloaded, manually install them in the levelfourstorefront plugin folder by replacing your existing "products" folder with the "products" folder inside demo.zip. If you have any questions visit www.levelfourstorefront.com.</b></p>
    <?php }?>
    
    <h2>Level Four Storefront Shopping Cart Settings</h2>
    
    <p>Detailed plugin installation instructions can be found here: <a href="http://www.levelfourdevelopment.com/support/index.php?/LevelFourStore/Knowledgebase/Article/View/55/1/installation-guide-for-wordpress-carts" target="_blank">Plugin Installation Guide</a></p>
    
    <p>Detailed administrative console installation instructions can be found here: <a href="http://www.levelfourdevelopment.com/support/index.php?/LevelFourStore/Knowledgebase/Article/View/56/0/installing-the-administration-console" target="_blank">Administration Installation Guide</a></p>
    
    <p><b>Steps to Install Shopping Cart:</b></p>
    <ol>
      <li>Create 3 pages: Store, Cart, and Account. The pages can have any name you would like, but you need three pages, one for each part of the store.</li>
      <li>Select the store page from the drop down menu below in the store page field</li>
      <li>Select the cart page from the drop down menu below in the cart page field</li>
      <li>Select the account page from the drop down menu below in the account page field</li>
      <li>Choose the other settings below to customize your store</li>
      <li>Save the Settings</li>
      <li>You will now see what WordPress calls a "Shortcode" on the three pages. This is essentially a place holder for the store content, cart content, and account content for the wordpress shopping cart plugin. Shortcodes appear as "[l4store]", "[l4cart]", and "[l4account]" on each of their respective pages. These codes MUST be on the page for your store to work correctly. You can, however, move the codes around and add content above or below the store, cart, and/or account pages.</li>
      <li>Download an administrative tool at <a href="http://levelfourstorefront.com/administrative-tools/" target="_blank">www.levelfourstorefront.com</a>. Store administration is done via a Level Four Storefront Administration application (available for Desktop, Mac, iPhone, iPad, and Android Devices). The most commong version to use is the desktop version. You will need to have Adobe AIR installed on your computer for this app to work correctly and can be downloaded at <a href="http://get.adobe.com/air/" target="_blank">http://get.adobe.com/air/</a>.</li>
      <li>To login for the first time to an administrative console use: email=demouser@demo.com and password=demouser</li>
      <li>Once you have logged in, feel free to add a new administrator by clicking manage users, add new user, and selecting administrator from the security drop down menu.</li>
      <li>Contact us if you have any questions or encounter any problems at all call us at 1(888)456-8830. You can also live chat with us on our website at www.levelfourstorefront.com or <a href="http://www.levelfourdevelopment.com/support/index.php?/LevelFourStore/Tickets/Submit" target="_blank">submit a support ticket here</a>.</li>
      <li>To unlock the full potential of the shopping cart, purchase a license. No need to remove or redo your work, simply get a registration code and our standard edition is yours.</ol>
    
    <p><b>Additional Notes:</b></p>
    <ol>
      <li>Add products on any page! simply add the following in any post or page (just as you would add text or images to a post or page): [l4product modelnumber="model_number_here"]</li>
      <li>Widgets for categories filter, manufactures filter, price points filter, mini-cart, menus, and product specials are all now available in the appearance->widgets section of your WordPress blog.</li> 
      <li>Please remember: If you are using the Free Version (no payment gateways) and you wish to sell through a payment gateway like PayPal or Authorize.net, you will need to <a href="https://levelfourstorefront.com/store/?ModelNumber=prod315" target="_blank">buy the Standard Version</a> and <a href="http://www.levelfourdevelopment.com/support/index.php?/LevelFourStore/Tickets/Submit" target="_blank">get a registration code</a> from us. Your work will not be lost, so feel free to design your site, add products, and get all setup; once you are ready, come back to us and get a license and start collecting money for the products you sell!</li>
    </ol>
    
    
    <form method="post" action="#" name="demodataform" id="demodataform">
    	<input type="hidden" name="isinsertdemodata" id="isinsertdemodata" value="1" />
    	<input type="submit" value="INSTALL DEMO DATA" />
    </form>
    
    <form method="post" action="options.php">
		<?php settings_fields( 'l4-settings-group' ); ?>
        <table class="form-table">
            
            <tr valign="top">
                <th scope="row" colspan="2">
                    <h2>Store Pages:</h2>
                </th>
            </tr>
            
            <tr valign="top">
                <th scope="row">Store Page:</th>
                <td>
                    <?php wp_dropdown_pages(array('name'=>'l4_option_storepage', 'selected'=>get_option('l4_option_storepage'))); ?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Cart Page:</th>
            
                <td>
                    <?php wp_dropdown_pages(array('name'=>'l4_option_cartpage', 'selected'=>get_option('l4_option_cartpage'))); ?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Account Page:</th>
           
                <td>
                    <?php wp_dropdown_pages(array('name'=>'l4_option_accountpage', 'selected'=>get_option('l4_option_accountpage'))); ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row" colspan="2">
                    <h2>Basic Store Options:</h2>
                </th>
            </tr>
            
            <tr valign="top">
                <th scope="row">Show Left Bar on Products Page (0=No, 1=Yes):</th>
            
                <td><input name="l4_option_sideMenuOnProducts" type="text" value="<?php echo get_option('l4_option_sideMenuOnProducts'); ?>" size="1" style="width:40px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Show Left Bar on Product Details Page (0=No, 1=Yes):</th>
            
                <td><input name="l4_option_sideMenuOnProductDetails" type="text" value="<?php echo get_option('l4_option_sideMenuOnProductDetails'); ?>" style="width:40px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Left Bar Categories Title (displayed as box header if show left bar used):</th>
            
                <td><input name="l4_option_categories_title" type="text" value="<?php echo get_option('l4_option_categories_title'); ?>" style="width:250px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Left Bar Manufacturers Title (displayed as box header if show left bar used):</th>
            
                <td><input name="l4_option_manufacturers_title" type="text" value="<?php echo get_option('l4_option_manufacturers_title'); ?>" style="width:250px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Left Bar Price Points Title (displayed as box header if show left bar used):</th>
            
                <td><input name="l4_option_pricepoints_title" type="text" value="<?php echo get_option('l4_option_pricepoints_title'); ?>" style="width:250px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Guest Text (appears on cart page, before a user has logged in):</th>
            
                <td><input name="l4_option_guest_text" type="text" value="<?php echo get_option('l4_option_guest_text'); ?>" style="width:550px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Submit Order Text (appears on the cart page, just before the user submits the order):</th>
            
                <td><textarea name="l4_option_submit_order_text" rows="4" style="width:550px;"><?php echo get_option('l4_option_submit_order_text'); ?></textarea></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Number of Products Per Row:</th>
            
                <td><input name="l4_option_num_prods_per_row" type="text" value="<?php echo get_option('l4_option_num_prods_per_row'); ?>" style="width:40px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Choose Base Stylesheet:</th>
            
                <td>
                    <select name="l4_option_stylesheettype">
                      <option value="1"<?php if(get_option('l4_option_stylesheettype') == "1"){ ?> selected="selected"<?php } ?>>Light Style</option>
                      <option value="2"<?php if(get_option('l4_option_stylesheettype') == "2"){ ?> selected="selected"<?php } ?>>Dark Style</option>
                    </select>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Google Analytics ID for Order Tracking:</th>
            
                <td><input name="l4_option_googleanalyticsid" type="text" value="<?php echo get_option('l4_option_googleanalyticsid'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row" colspan="2">
                    <h2>Store Color Scheme:</h2>
                </th>
            </tr>
            
            <tr valign="top">
                <th scope="row">Button Fade Colors (top to bottom, all buttons in store):</th>
            
                <td>
                	
                    <div class="settings_color_swatch" style="background-color:<?php echo get_option('l4_option_button_color1'); ?>"></div>
                	<div class="settings_color_swatch" style="background-color:<?php echo get_option('l4_option_button_color2'); ?>"></div>
                    <div class="settings_color_swatch" style="background-color:<?php echo get_option('l4_option_button_font_color'); ?>"></div>
                    
                    Top: <input name="l4_option_button_color1" type="text" value="<?php echo get_option('l4_option_button_color1'); ?>" style="width:100px;" /> - Bottom: <input name="l4_option_button_color2" type="text" value="<?php echo get_option('l4_option_button_color2'); ?>" style="width:100px;" />, Font Color: <input name="l4_option_button_font_color" type="text" value="<?php echo get_option('l4_option_button_font_color'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Button Fade Colors MOUSE OVER (top to bottom, all buttons in store):</th>
            
                <td>
                	
                    <div class="settings_color_swatch" style="background-color:<?php echo get_option('l4_option_button_color1_hover'); ?>"></div>
                	<div class="settings_color_swatch" style="background-color:<?php echo get_option('l4_option_button_color2_hover'); ?>"></div>
                    <div class="settings_color_swatch" style="background-color:<?php echo get_option('l4_option_button_font_color_hover'); ?>"></div>
                    
                    Top: <input name="l4_option_button_color1_hover" type="text" value="<?php echo get_option('l4_option_button_color1_hover'); ?>" style="width:100px;" /> - Bottom: <input name="l4_option_button_color2_hover" type="text" value="<?php echo get_option('l4_option_button_color2_hover'); ?>" style="width:100px;" />, Font Color: <input name="l4_option_button_font_color_hover" type="text" value="<?php echo get_option('l4_option_button_font_color_hover'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Header Bar Fade Colors (top to bottom, all header bars in store):</th>
            
                <td>
                	
                    <div class="settings_color_swatch" style="background-color:<?php echo get_option('l4_option_header_color1'); ?>"></div>
                	<div class="settings_color_swatch" style="background-color:<?php echo get_option('l4_option_header_color2'); ?>"></div>
                    <div class="settings_color_swatch" style="background-color:<?php echo get_option('l4_option_header_font_color'); ?>"></div>
                    
                    Top: <input name="l4_option_header_color1" type="text" value="<?php echo get_option('l4_option_header_color1'); ?>" style="width:100px;" /> - Bottom:<input name="l4_option_header_color2" type="text" value="<?php echo get_option('l4_option_header_color2'); ?>" style="width:100px;" />, Font Color: <input name="l4_option_header_font_color" type="text" value="<?php echo get_option('l4_option_header_font_color'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Page Title Font Color (in our store is a blue color and found mostly at the top of account pages):</th>
            
                <td>
                	
                    <div class="settings_color_swatch" style="background-color:<?php echo get_option('l4_option_title_font_color'); ?>"></div>
                    
                    Top: <input name="l4_option_title_font_color" type="text" value="<?php echo get_option('l4_option_title_font_color'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Page Text Links (up color and hover color):</th>
            
                <td>
                	
                    <div class="settings_color_swatch" style="background-color:<?php echo get_option('l4_option_link_font_color'); ?>"></div>
                	<div class="settings_color_swatch" style="background-color:<?php echo get_option('l4_option_link_font_color_hover'); ?>"></div>
                    
                    Link Color: <input name="l4_option_link_font_color" type="text" value="<?php echo get_option('l4_option_link_font_color'); ?>" style="width:100px;" />, Mouse Over Color (Hover): <input name="l4_option_link_font_color_hover" type="text" value="<?php echo get_option('l4_option_link_font_color_hover'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row" colspan="2">
                    <h2>Product Thumbnail Sizing:</h2>
                </th>
            </tr>
            
            <tr valign="top">
                <th scope="row">X-Small Image Size (thumbnails on product details page):</th>
            
                <td>Width: <input name="l4_option_xsmall_width" type="text" value="<?php echo get_option('l4_option_xsmall_width'); ?>" style="width:100px;" />, Height: <input name="l4_option_xsmall_height" type="text" value="<?php echo get_option('l4_option_xsmall_height'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Small Image Size (used in account and featured products):</th>
            
                <td>Width: <input name="l4_option_small_width" type="text" value="<?php echo get_option('l4_option_small_width'); ?>" style="width:100px;" />, Height: <input name="l4_option_small_height" type="text" value="<?php echo get_option('l4_option_small_height'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Medium Image Size (used in product list):</th>
            
                <td>Width: <input name="l4_option_medium_width" type="text" value="<?php echo get_option('l4_option_medium_width'); ?>" style="width:100px;" />, Height: <input name="l4_option_medium_height" type="text" value="<?php echo get_option('l4_option_medium_height'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Large Image Size (used in product details main image):</th>
            
                <td>Width: <input name="l4_option_large_width" type="text" value="<?php echo get_option('l4_option_large_width'); ?>" style="width:100px;" />, Height: <input name="l4_option_large_height" type="text" value="<?php echo get_option('l4_option_large_height'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Small Swatch Image Size (used in product list for products with a first option set using swatch icons):</th>
            
                <td>Width: <input name="l4_option_swatch_small_width" type="text" value="<?php echo get_option('l4_option_swatch_small_width'); ?>" style="width:100px;" />, Height: <input name="l4_option_swatch_small_height" type="text" value="<?php echo get_option('l4_option_swatch_small_height'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Large Swatch Image Size (used in product details for products with a first option set using swatch icons):</th>
            
                <td>Width: <input name="l4_option_swatch_large_width" type="text" value="<?php echo get_option('l4_option_swatch_large_width'); ?>" style="width:100px;" />, Height: <input name="l4_option_swatch_large_height" type="text" value="<?php echo get_option('l4_option_swatch_large_height'); ?>" style="width:100px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row" colspan="2">
                    <h2>Pretty Product Image Formatting:</h2>
                    <h3>The following section refers to how your product image is called. Using "Pretty" product images will make thumbnail images appear as, for example, "thumb_100_100_product1.jpg." Without using this option, images appear as, for example, "images.php?max_width=100&amp;max_height=100&amp;imgfile=product1.jpg". Some servers will not work correctly immediately with this option, so if you see product images fail, you will need to edit the .htaccess files in the products/pics1, products/pics2, products/pics3, products/pics4, products/pics5, and products/swatches. If the images are failing with this option, change the way it finds the images.php file in the .htaccess files to something like: "/wordpress-sub-folder/wp-content/plugins/levelfourstorefront/products/pics1/images.php". Do this for each .htaccess file, changing pics1 to the corresponding folder. Contact us if you have problems and would still like to use this option.</h3>
                </th>
            </tr>
            
            <tr valign="top">
                <th scope="row">Use "Pretty" Formatting for Product Images (0=No, 1=Yes):</th>
            
                <td><input name="l4_option_use_pretty_image_names" type="text" value="<?php echo get_option('l4_option_use_pretty_image_names'); ?>" size="1" style="width:40px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row" colspan="2">
                    <h2>Social Icon Options:</h2>
                    <h3>The following options are displayed on the product details page.</h3>
                </th>
            </tr>
            
            <tr valign="top">
                <th scope="row">Show Facebook Icon on Product Details (0=No, 1=Yes):</th>
            
                <td><input name="l4_option_use_facebook_icon" type="text" value="<?php echo get_option('l4_option_use_facebook_icon'); ?>" size="1" style="width:40px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Show Twitter Icon on Product Details (0=No, 1=Yes):</th>
            
                <td><input name="l4_option_use_twitter_icon" type="text" value="<?php echo get_option('l4_option_use_twitter_icon'); ?>" size="1" style="width:40px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Show Delicious Icon on Product Details (0=No, 1=Yes):</th>
            
                <td><input name="l4_option_use_delicious_icon" type="text" value="<?php echo get_option('l4_option_use_delicious_icon'); ?>" size="1" style="width:40px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Show MySpace Icon on Product Details (0=No, 1=Yes):</th>
            
                <td><input name="l4_option_use_myspace_icon" type="text" value="<?php echo get_option('l4_option_use_myspace_icon'); ?>" size="1" style="width:40px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Show LinkedIn Icon on Product Details (0=No, 1=Yes):</th>
            
                <td><input name="l4_option_use_linkedin_icon" type="text" value="<?php echo get_option('l4_option_use_linkedin_icon'); ?>" size="1" style="width:40px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Show Email Icon on Product Details (0=No, 1=Yes):</th>
            
                <td><input name="l4_option_use_email_icon" type="text" value="<?php echo get_option('l4_option_use_email_icon'); ?>" size="1" style="width:40px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Show Digg Icon on Product Details (0=No, 1=Yes):</th>
            
                <td><input name="l4_option_use_digg_icon" type="text" value="<?php echo get_option('l4_option_use_digg_icon'); ?>" size="1" style="width:40px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Show Google+ Icon on Product Details (0=No, 1=Yes):</th>
            
                <td><input name="l4_option_use_googleplus_icon" type="text" value="<?php echo get_option('l4_option_use_googleplus_icon'); ?>" size="1" style="width:40px;" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Show Pinterest Icon on Product Details (0=No, 1=Yes):</th>
            
                <td><input name="l4_option_use_pinterest_icon" type="text" value="<?php echo get_option('l4_option_use_pinterest_icon'); ?>" size="1" style="width:40px;" /></td>
            </tr>
            
      </table>
        
        <p class="submit">
        <input type="hidden" name="isupdate" value="1" />
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    
    </form>
    </div>
</div>