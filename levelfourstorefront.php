<?php
/**
 * Plugin Name: WordPress Shopping Cart
 * Plugin URI: http://levelfourstorefront.com/wordpress-shopping-cart/
 * Description: Simple install into new or existing WordPress blogs. Customers purchase directly from your store! Get a full E-Commerce platform in WordPress! Sell products, downloadable goods, gift cards, clothing and more! Now with WordPress, the powerful features are still very easy to administrate! If you have any questions, please drop us a line or call, our current contact information is available at www.levelfourstorefront.com.
 * Version: 8.1.17
 * Author: Level Four Storefront
 * Author URI: http://www.levelfourstorefront.com
 *
 * This program is free to download and install, but requires the purchase of our shopping cart software and database.
 * Each site requires a license for live use and must be purchased through the Level Four Storefront website.
 *
 * @package levelfourstorefront
 * @version 8.1.17
 * @author Level Four Storefront <matt@levelfourstorefront.com>
 * @copyright Copyright (c) 2012, Level Four Storefront LLC
 * @link http://www.levelfourstorefront.com
 */
 
define( 'L4_PUGIN_NAME', 'WordPress Shopping Cart');
define( 'L4_PLUGIN_DIRECTORY', 'levelfourstorefront');
define( 'L4_CURRENT_VERSION', '8.1.17' );

//Helper Function, Get URL
function url(){
  $protocol = $_SERVER['HTTPS'] ? "https" : "http";
  $baseurl = "://" . $_SERVER['HTTP_HOST'];
  $strip = explode("/wp-admin", $_SERVER['REQUEST_URI']);
  $folder = $strip[0];
  return $protocol .  $baseurl . $folder;
}

function l4_activate(){
	$flashdb_php = '<?php
					# FileName="Connection_php_mysql.htm"
					# Type="MYSQL"
					# HTTP="true"
					$hostname_flashdb = "' . DB_HOST . '";  //usually localhost will work
					$database_flashdb = "' . DB_NAME . '";
					$username_flashdb = "' . DB_USER . '";
					$password_flashdb = "' . DB_PASSWORD . '";
					$url_htmlstore = "' . url() . '"; //http://for unsecured, https://for secured stores with certificates
					
					define ("HOSTNAME",$hostname_flashdb); 	
					define ("DATABASE",$database_flashdb); 		
					define ("USERNAME",$username_flashdb); 	
					define ("PASSWORD",$password_flashdb); 	
					define ("HTMLURL", $url_htmlstore);
					define ("DEBUG", "false");
					
					
					$flashdb = mysql_pconnect($hostname_flashdb, $username_flashdb, $password_flashdb) or trigger_error(mysql_error(),E_USER_ERROR); 

				?>';
				
		
	//Write the flashdb.php
	$flashdb_filename = WP_PLUGIN_DIR . "/" . L4_PLUGIN_DIRECTORY . "/Connections/flashdb.php";
	$flashdb_filehandler = fopen($flashdb_filename, 'w');
	fwrite($flashdb_filehandler, $flashdb_php);
	fclose($flashdb_filehandler);
	
	//Open connection to db
	require_once(WP_PLUGIN_DIR . "/" . L4_PLUGIN_DIRECTORY . '/Connections/flashdb.php' );
	mysql_select_db($database_flashdb, $flashdb);
	
	//Put up the databse for website
	$url = WP_PLUGIN_DIR . "/" . L4_PLUGIN_DIRECTORY . '/scripts/sql/install.sql';
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
	
	//Update the db settings to current site
	$site = explode("://", url());
	$site = $site[1];
	$sql = sprintf("UPDATE settings SET siteURL = '%s'", mysql_real_escape_string($site));
	mysql_query($sql);
	
	//register options
	add_option( 'l4_option_storepage', '' );
	add_option( 'l4_option_cartpage', '' );
	add_option( 'l4_option_accountpage', '' );
	add_option( 'l4_option_sideMenuOnProducts', '0' );
	add_option( 'l4_option_sideMenuOnProductDetails', '0' );
	add_option( 'l4_option_stylesheettype', '1' );
	add_option( 'l4_option_googleanalyticsid', 'UA-XXXXXXX-X' );
	add_option( 'l4_option_num_prods_per_row', '3' );
	add_option( 'l4_option_button_color1', '#52baff' );
	add_option( 'l4_option_button_color2', '#119ffe' );
	add_option( 'l4_option_button_font_color', '#FFFFFF' );
	add_option( 'l4_option_button_color1_hover', '#7fccff' );
	add_option( 'l4_option_button_color2_hover', '#4db8ff' );
	add_option( 'l4_option_button_font_color_hover', '#FFFFFF' );
	add_option( 'l4_option_header_color1', '#52baff' );
	add_option( 'l4_option_header_color2', '#119ffe' );
	add_option( 'l4_option_header_font_color', '#FFFFFF' );
	add_option( 'l4_option_title_font_color', '#52baff' );
	add_option( 'l4_option_link_font_color', '#119ffe' );
	add_option( 'l4_option_link_font_color_hover', '#52baff' );
	add_option( 'l4_option_categories_title', 'Categories' );
	add_option( 'l4_option_manufacturers_title', 'Manufacturers' );
	add_option( 'l4_option_pricepoints_title', 'Prices' );
	add_option( 'l4_option_guest_text', 'Please proceed as a guest if you do not have an account. You will be given the chance to create an account during checkout.' );
	add_option( 'l4_option_submit_order_text', 'Once you click "Submit Order," our order fulfillment process begins and no changes can be made to your order. Thanks for shopping with us! Remember: Our 100% satisfaction guarantee ensures that every item you purchase from us meets your high standards—or you can return it for a replacement or refund. Purchases can be returned at any store as well as through mail order.' );
	add_option( 'l4_option_xsmall_width', '50' );
	add_option( 'l4_option_xsmall_height', '50' );
	add_option( 'l4_option_small_width', '100' );
	add_option( 'l4_option_small_height', '100' );
	add_option( 'l4_option_medium_width', '175' );
	add_option( 'l4_option_medium_height', '175' );
	add_option( 'l4_option_large_width', '400' );
	add_option( 'l4_option_large_height', '400' );
	add_option( 'l4_option_swatch_small_width', '15' );
	add_option( 'l4_option_swatch_small_height', '15' );
	add_option( 'l4_option_swatch_large_width', '25' );
	add_option( 'l4_option_swatch_large_height', '25' );
	add_option( 'l4_option_use_facebook_icon', '1' );
	add_option( 'l4_option_use_twitter_icon', '1' );
	add_option( 'l4_option_use_delicious_icon', '1' );
	add_option( 'l4_option_use_myspace_icon', '1' );
	add_option( 'l4_option_use_linkedin_icon', '1' );
	add_option( 'l4_option_use_email_icon', '1' );
	add_option( 'l4_option_use_digg_icon', '1' );
	add_option( 'l4_option_use_googleplus_icon', '1' );
	add_option( 'l4_option_use_pinterest_icon', '1' );
	add_option( 'l4_option_use_pretty_image_names', '0' );
}

function l4_uninstall(){
	//Open connection to db
	require_once(WP_PLUGIN_DIR . "/" . L4_PLUGIN_DIRECTORY . '/Connections/flashdb.php' );
	mysql_select_db($database_flashdb, $flashdb);
	
	//Put up the databse for website
	$url = WP_PLUGIN_DIR . "/" . L4_PLUGIN_DIRECTORY . '/scripts/sql/uninstall.sql';
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
	
	//remove options
	delete_option( 'l4_option_storepage' );
	delete_option( 'l4_option_cartpage' );
	delete_option( 'l4_option_accountpage' );
	delete_option( 'l4_option_sideMenuOnProducts' );
	delete_option( 'l4_option_sideMenuOnProductDetails' );
	delete_option( 'l4_option_stylesheettype' );
	delete_option( 'l4_option_googleanalyticsid' );
	delete_option( 'l4_option_num_prods_per_row' );
	delete_option( 'l4_option_button_color1' );
	delete_option( 'l4_option_button_color2' );
	delete_option( 'l4_option_button_font_color' );
	delete_option( 'l4_option_button_color1_hover' );
	delete_option( 'l4_option_button_color2_hover' );
	delete_option( 'l4_option_button_font_color_hover' );
	delete_option( 'l4_option_header_color1' );
	delete_option( 'l4_option_header_color2' );
	delete_option( 'l4_option_header_font_color' );
	delete_option( 'l4_option_title_font_color' );
	delete_option( 'l4_option_link_font_color' );
	delete_option( 'l4_option_link_font_color_hover' );
	delete_option( 'l4_option_categories_title' );
	delete_option( 'l4_option_manufacturers_title' );
	delete_option( 'l4_option_pricepoints_title' );
	delete_option( 'l4_option_guest_text' );
	delete_option( 'l4_option_submit_order_text' );
	delete_option( 'l4_option_xsmall_width' );
	delete_option( 'l4_option_xsmall_height' );
	delete_option( 'l4_option_small_width' );
	delete_option( 'l4_option_small_height' );
	delete_option( 'l4_option_medium_width' );
	delete_option( 'l4_option_medium_height' );
	delete_option( 'l4_option_large_width' );
	delete_option( 'l4_option_large_height' );
	delete_option( 'l4_option_swatch_small_width' );
	delete_option( 'l4_option_swatch_small_height' );
	delete_option( 'l4_option_swatch_large_width' );
	delete_option( 'l4_option_swatch_large_height' );
	delete_option( 'l4_option_use_facebook_icon' );
	delete_option( 'l4_option_use_twitter_icon' );
	delete_option( 'l4_option_use_delicious_icon' );
	delete_option( 'l4_option_use_myspace_icon' );
	delete_option( 'l4_option_use_linkedin_icon' );
	delete_option( 'l4_option_use_email_icon' );
	delete_option( 'l4_option_use_digg_icon' );
	delete_option( 'l4_option_use_googleplus_icon' );
	delete_option( 'l4_option_use_pinterest_icon' );
	delete_option( 'l4_option_use_pretty_image_names' );
}

register_activation_hook( __FILE__, 'l4_activate' );
register_uninstall_hook( __FILE__, 'l4_uninstall' );

function load_l4_pre(){
	
	session_start();
	
	require_once( WP_PLUGIN_DIR . "/" . L4_PLUGIN_DIRECTORY . '/Connections/flashdb.php' );

	require_once( WP_PLUGIN_DIR . "/" . L4_PLUGIN_DIRECTORY . '/scripts/l4html/l4store_functions.php' );
	
	mysql_select_db($database_flashdb, $flashdb);
	
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
	
	if($_SERVER['HTTPS']){
		$currentpageid = url_to_postid( "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] );
	}else{
		$currentpageid = url_to_postid( "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] );
	}
	
	//PROCESS FORMS FIRST!! Important for redirection without duplicate form submission
	if($currentpageid==$storepageid && ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "GET") ){
		
		if(isset($_POST['l4_action']) && $_POST['l4_action'] == "submitreview"){
		
			include("l4store/product_details/submit_review.php");
			
		}
		
	}else if($currentpageid==$cartpageid && ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "GET") ){
		
		if(isset($_POST['l4_action']) && $_POST['l4_action'] == "addtocart"){
		
			include("l4cartscripts/addtocart.php");
			
		}else if(isset($_POST['l4_action']) && $_POST['l4_action'] == "updatecartitem"){
			
			include("l4cartscripts/updatecartitem.php");
			
		}else if(isset($_POST['l4_action']) && $_POST['l4_action'] == "removecartitem"){
			
			include("l4cartscripts/removecartitem.php");
			
		}else if(isset($_POST['l4_action']) && $_POST['l4_action'] == "guestcheckout"){
			
			include("l4cartscripts/guest_checkout.php");
			
		}else if(isset($_POST['l4_action']) && $_POST['l4_action'] == "login"){
			
			include("l4cartscripts/loginuser.php");
			
		}else if(isset($_POST['l4_action']) && $_POST['l4_action'] == "submitorder"){
			
			include("l4cartscripts/submitorder.php");
			
		}else if(isset($_GET['l4_action']) && $_GET['l4_action'] == "signout"){
			
			include("l4cartscripts/signout.php");
			
		}else if(isset($_POST['l4_action']) && $_POST['l4_action'] == "confirmorder"){
			
			require_once( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/scripts/l4html/l4_confirm_order_functions.php");
			
			set_form_session_vars();
			
			header("location:".$cartpage.$permalinkdivider."confirmorder=true");
			
		}
		
	}else if($currentpageid==$accountpageid && ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "GET") ){
		
		if(isset($_POST['l4_action']) && $_POST['l4_action'] == "billinginfo"){
		
			include("l4accountscripts/update_billinginfo.php");
			
		}else if(isset($_POST['l4_action']) && $_POST['l4_action'] == "editpassword"){
			
			include("l4accountscripts/update_password.php");
			
		}else if(isset($_POST['l4_action']) && $_POST['l4_action'] == "forgotpassword"){
			
			include("l4accountscripts/retrievepassword.php");
			
		}else if(isset($_POST['l4_action']) && $_POST['l4_action'] == "login"){
			
			include("l4accountscripts/loginuser.php");
			
		}else if(isset($_POST['l4_action']) && $_POST['l4_action'] == "personalinfo"){
			
			include("l4accountscripts/update_personal_info.php");
			
		}else if(isset($_POST['l4_action']) && $_POST['l4_action'] == "register"){
			
			include("l4accountscripts/register.php");
			
		}else if(isset($_POST['l4_action']) && $_POST['l4_action'] == "shippinginfo"){
			
			include("l4accountscripts/update_shippinginfo.php");
			
		}else if(isset($_GET['l4_action']) && $_GET['l4_action'] == "signout"){
			
			include("l4accountscripts/signout.php");
			
		}
		
	}
	
	
}
	
function load_styles(){ 
   
	if(get_option( 'l4_option_stylesheettype' ) == "1"){
	   
		wp_register_style( 'mainstylesheet', plugins_url( L4_PLUGIN_DIRECTORY . '/scripts/mainstylesheet.css' ) );
	
	}else if(get_option( 'l4_option_stylesheettype' ) == "2"){
	
		wp_register_style( 'mainstylesheet', plugins_url( L4_PLUGIN_DIRECTORY . '/scripts/mainstylesheet_dark.css' ) );
		
	}
	
	if(!is_admin()){
	
		wp_register_style( 'tabs', plugins_url( L4_PLUGIN_DIRECTORY . '/tabs/tabs.css' ) );
	
	}
	
	
	// enqueing:
	
	wp_enqueue_style( 'mainstylesheet' );
	
	if(!is_admin()){
	
		wp_enqueue_style( 'tabs' );
	
	}
	
}
	
	
	
function load_scripts() {

   wp_register_script('l4storefunctions', plugins_url( L4_PLUGIN_DIRECTORY . '/scripts/l4html/l4store_functions.js' ) );

   wp_register_script('l4cartfunctions', plugins_url( L4_PLUGIN_DIRECTORY . '/scripts/l4html/l4store_cart.js' ) );

   if(!is_admin()){

   		wp_register_script('jquery-ui', plugins_url( L4_PLUGIN_DIRECTORY . '/tabs/jquery-ui.js' ) );

   		wp_register_script('jquery-tabs', plugins_url( L4_PLUGIN_DIRECTORY . '/tabs/jquery-tabs.js' ) );

   }
   

   wp_enqueue_script('l4storefunctions');

   wp_enqueue_script('l4cartfunctions');

   wp_enqueue_script('jquery');
   
   if(!is_admin()){
   
	   wp_enqueue_script('jquery-ui');
	   
	   wp_enqueue_script('jquery-tabs');
	
   }

}
	
	
function facebookmeta(){

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

	if(isset($_GET['ModelNumber'])){

		$query_productRS = sprintf("SELECT * FROM products WHERE ModelNumber = '%s'", mysql_real_escape_string($_GET['ModelNumber']));

		$productRS = mysql_query($query_productRS);

		$row_productRS = mysql_fetch_assoc($productRS);

		$arr = explode(".", $row_productRS['Image1']);

		$imgname = $arr[0];

		$imgext = $arr[1];

		if($row_productRS['useoptionitemimages']){
			$optimg_sql = sprintf("SELECT optionitemimages.* FROM optionitems, optionitemimages WHERE optionitems.optionparentID = '%s' AND optionitemimages.optionitemID = optionitems.optionitemID AND optionitemimages.productID = '%s' ORDER BY optionitems.optionorder", $row_productRS['option1'], $row_productRS['ProductID']);
			$optimgs = mysql_query($optimg_sql);
		
			if(isset($_GET['catid'])){
				while($optimg = mysql_fetch_assoc($optimgs)){
					if($optimg['optionitemID'] == $_GET['catid']){
						$imageforfb = $optimg['Image1'];
					}
				}
			}else{
				$optimg = mysql_fetch_assoc($optimgs);
				$imageforfb = $optimg['Image1'];
			} 
		
		}else{
			$imageforfb = $row_productRS['Image1'];
		}
	

		echo "<meta property=\"og:title\" content=\"" . $row_productRS['Title'] . "\" />\n"; 

		echo "<meta property=\"og:type\" content=\"product\" />\n";
	
		echo "<meta property=\"og:description\" content=\"" . short_string($row_productRS['Description'], 100) . "\" />\n";

		echo "<meta property=\"og:image\" content=\"" . str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__))) . "levelfourstorefront/products/pics1/" . $imageforfb . "\" />\n"; 

		echo "<meta property=\"og:url\" content=\"" . $storepage . $permalinkdivider;
		
		if($_GET['ModelNumber']){
			
			echo "ModelNumber=" . $_GET['ModelNumber'];
			
		}
		
		if($_GET['catid']){
			
			echo "&catid=" . $_GET['catid'];
			
		}
		
		echo "\" />\n";

		echo "<meta name=\"keywords\" http-equiv=\"keywords\" content=\"" . $row_productRS['Keywords'] . "\" />\n";
	
		echo "<meta name=\"description\" http-equiv=\"description\" content=\"" . $row_productRS['shortDescription'] . "\" />\n";
		
	}
	
	echo "<style type=\"text/css\">\n";
		
	echo "	.l4store_button{\n";
		
	echo "		background: " . get_option('l4_option_button_color1') . " !important; /* Show a solid color for older browsers */\n";
		
	echo "		background: -moz-linear-gradient(" . get_option('l4_option_button_color1') . ", " . get_option('l4_option_button_color2') . ") !important;\n";
		
	echo "		background: -o-linear-gradient(" . get_option('l4_option_button_color1') . ", " . get_option('l4_option_button_color2') . ") !important;\n";
		
	echo "		background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(" . get_option('l4_option_button_color1') . "), to(" . get_option('l4_option_button_color2') . ")) !important; /* older webkit syntax */\n";
		
	echo "		background: -webkit-linear-gradient(" . get_option('l4_option_button_color1') . ", " . get_option('l4_option_button_color2') . ") !important;\n";
		
	echo "		font-size: 12px !important;\n";
		
	echo "		font-weight:bold !important;\n";
		
	echo "		text-align:center !important;\n";
		
	echo "		color: " . get_option('l4_option_button_font_color') . " !important;\n";
		
	echo "		padding:4px !important;\n";
		
	echo "		margin:1px !important;\n";
	
	echo "		border: none !important;\n";
		
	echo "	}\n";
		
	echo "	.l4store_button:hover{\n";
	
	echo "		cursor:pointer !important;\n";
		
	echo "		background: " . get_option('l4_option_button_color1_hover') . " !important; /* Show a solid color for older browsers */\n";
		
	echo "		background: -moz-linear-gradient(" . get_option('l4_option_button_color1_hover') . ", " . get_option('l4_option_button_color2_hover') . ") !important;\n";
		
	echo "		background: -o-linear-gradient(" . get_option('l4_option_button_color1_hover') . ", " . get_option('l4_option_button_color2_hover') . ") !important;\n";
		
	echo "		background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(" . get_option('l4_option_button_color1_hover') . "), to(" . get_option('l4_option_button_color2_hover') . ")) !important; /* older webkit syntax */\n";
		
	echo "		background: -webkit-linear-gradient(" . get_option('l4_option_button_color1_hover') . ", " . get_option('l4_option_button_color2_hover') . ") !important;\n";
		
	echo "		background: -webkit-linear-gradient(" . get_option('l4_option_button_color1_hover') . ", " . get_option('l4_option_button_color2_hover') . ") !important;\n";
		
	echo "		color: " . get_option('l4_option_button_font_color_hover') . " !important;\n";
		
	echo "		padding:4px !important;\n";
		
	echo "		margin:1px !important;\n";
	
	echo "		border: none !important;\n";
		
	echo "		font-weight: bold !important;\n";
		
	echo "		text-align: center !important;\n";
		
	echo "	}\n";
	
	echo "	.l4store_header{\n";
	
	echo "		background: " . get_option('l4_option_header_color1') . " !important; /* Show a solid color for older browsers */\n";
		
	echo "		background: -moz-linear-gradient(" . get_option('l4_option_header_color1') . ", " . get_option('l4_option_header_color2') . ") !important;\n";
		
	echo "		background: -o-linear-gradient(" . get_option('l4_option_header_color1') . ", " . get_option('l4_option_header_color2') . ") !important;\n";
		
	echo "		background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(" . get_option('l4_option_header_color1') . "), to(" . get_option('l4_option_header_color2') . ")) !important; /* older webkit syntax */\n";
		
	echo "		background: -webkit-linear-gradient(" . get_option('l4_option_header_color1') . ", " . get_option('l4_option_header_color2') . ") !important;\n";
	
	echo "		width:100% !important;";
	
	echo "		padding:8px 0 8px 0 !important;";
	
	echo "		-webkit-box-shadow: rgba(0, 0, 0, 0.4) 0px 1px 2px !important;";

	echo "		-moz-box-shadow: rgba(0, 0, 0, 0.4) 0px 1px 2px !important;";

	echo "		box-shadow: rgba(0, 0, 0, 0.4) 0px 1px 2px !important;";
		
	echo "		font-size: 14px !important;\n";
		
	echo "		font-weight:bold !important;\n";
		
	echo "		text-align:center !important;\n";
	
	echo "		float:left !important;";
	
	echo "		border: 1px solid #ccc !important;";
		
	echo "		color: " . get_option('l4_option_header_font_color') . " !important;\n";
		
	echo "	}\n";
	
	echo "	.l4store_title{\n";
	
	echo "		font-size:22px !important;\n";

	echo "		font-weight:bold !important;\n";

	echo "		color:" . get_option('l4_option_title_font_color') . " !important;\n";

	echo "		float:left !important;\n";
	
	echo "		width:100% !important;\n";
	
	echo "	}\n";
	
	echo "	.l4store_link:link, .l4store_link:visited, .l4store_link:active{\n";
	
	echo "		font-size:12px !important;\n";

	echo "		color:" . get_option('l4_option_link_font_color') . " !important;\n";
	
	echo "	}\n";
	
	echo "	.l4store_link:hover{\n";

	echo "		color:" . get_option('l4_option_link_font_color_hover') . " !important;\n";
	
	echo "		text-decoration: none !important;\n";
	
	echo "	}\n";
	
	echo "	.l4store_contentbox{\n";

	echo "		background-color: #FFFFFF !important;\n";

	echo "		color: #333 !important;\n";

	echo "		margin: 0 0 8px 2px !important;\n";
	
	echo "		border: 1px solid #ccc !important;";
	
	echo "	}\n";
	
	echo "	.l4store_contentbox div{\n";

	echo "		padding: 5px 10px !important;\n";
	
	echo "	}\n";
		
	echo "</style>\n";

}
	
	
	
function curPageURL() {

	$pageURL = 'http';

	if ($_SERVER["HTTPS"] == "on"){

		$pageURL .= "s";

	}

	$pageURL .= "://";

	if ($_SERVER["SERVER_PORT"] != "80") {

		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];

	} else {

		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

	}

	return $pageURL;

}
	
	
	
function short_string($text, $length){

	if(strlen($text) > $length) {

		$text = substr($text, 0, strpos($text, ' ', $length));

	}



	return $text;

}
	
	
	

//load search
function load_l4search($content){
	global $wp_query;
    
	if ($wp_query->is_search){

		include('search.php');
		
	}else{
	
		return $content;
	}
}


//[l4store]
function load_l4store( $atts ){
	
	ob_start();
    include "store.php";
    return ob_get_clean();

}

//[l4cart]
function load_l4cart( $atts ){
	
	ob_start();
    include "cart.php";
    return ob_get_clean();

}

//[l4account]
function load_l4account( $atts ){
	
	ob_start();
    include "account.php";
    return ob_get_clean();

}

//[l4product]
function load_l4product( $atts ){
	
	extract( shortcode_atts( array(
		'modelnumber' => 'NOPRODUCT'
	), $atts ) );
	
	$simp_product_id = $modelnumber;
	
	ob_start();
    include "simproduct.php";
    return ob_get_clean();

}

function wp_myplugin_property_title($data){ 

	$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";
	$settingsRS = mysql_query($query_settingsRS);
	$row_settingsRS = mysql_fetch_assoc($settingsRS);
	
	$storepageid = get_option('l4_option_storepage');
	$storepage = get_permalink( $storepageid );
	
	global $post;
	
	if( isset($_GET['ModelNumber']) && $post->ID == $storepageid ){
		
		$query_productRS = sprintf("SELECT products.Title FROM products WHERE ModelNumber = '%s'", mysql_real_escape_string($_GET['ModelNumber']));
		$productRS = mysql_query($query_productRS);
		$row_productRS = mysql_fetch_assoc($productRS);
		
		$seotitle = $row_productRS['Title'];
		return $seotitle . " ";
		
	}else{
		
		return $data;
		
	}
		
		
}

load_styles();
	
load_scripts();

add_action('init', 'load_l4_pre');

add_action('wp_head', 'facebookmeta');

add_shortcode( 'l4store', 'load_l4store' );

add_shortcode( 'l4cart', 'load_l4cart' );

add_shortcode( 'l4account', 'load_l4account' );

add_shortcode( 'l4product', 'load_l4product' );

add_filter( 'the_content', 'load_l4search' );

add_filter('wp_title', wp_myplugin_property_title, 100);

/////////////////////////////////////////
////*****START WIDGETS*****///////
/////////////////////////////////////////////

class L4MenuWidget extends WP_Widget
{
	
  function L4MenuWidget()
  {
    $widget_ops = array('classname' => 'L4MenuWidget', 'description' => 'Displays the menu for your Level Four Storefront' );
    $this->WP_Widget('L4MenuWidget', 'L4 Store Dropdown Menu', $widget_ops);
  }
 
  function form($instance)
  {
	$defaults = array(
		'bgcolor1' => '#196BAD',
		'bgrollovercolor1' => '#196BAD',
		'bgcolor2' => '#196BAD',
		'bgrollovercolor2' => '#196BAD',
		'bgcolor3' => '#196BAD',
		'bgrollovercolor3' => '#196BAD',
		'fontcolor1' => '#FFFFFF',
		'fontrollovercolor1' => '#CCCCCC',
		'fontcolor2' => '#FFFFFF',
		'fontrollovercolor2' => '#CCCCCC',
		'fontcolor3' => '#FFFFFF',
		'fontrollovercolor3' => '#CCCCCC',
		'menutype' => '1'
	);
	$instance = wp_parse_args( (array) $instance, $defaults);
	$bgcolor1 = $instance['bgcolor1'];
	$bgrollovercolor1 = $instance['bgrollovercolor1'];
	$bgcolor2 = $instance['bgcolor2'];
	$bgrollovercolor2 = $instance['bgrollovercolor2'];
	$bgcolor3 = $instance['bgcolor3'];
	$bgrollovercolor3 = $instance['bgrollovercolor3'];
	$fontcolor1 = $instance['fontcolor1'];
	$fontrollovercolor1 = $instance['fontrollovercolor1'];
	$fontcolor2 = $instance['fontcolor2'];
	$fontrollovercolor2 = $instance['fontrollovercolor2'];
	$fontcolor3 = $instance['fontcolor3'];
	$fontrollovercolor3 = $instance['fontrollovercolor3'];
	$menutype = $instance['menutype'];
	?>
	<p><label for="<?php echo $this->get_field_id('bgcolor1'); ?>">BG Color Level 1: <input class="widefat" id="<?php echo $this->get_field_id('bgcolor1'); ?>" name="<?php echo $this->get_field_name('bgcolor1'); ?>" type="text" value="<?php echo attribute_escape($bgcolor1); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('bgrollovercolor1'); ?>">BG Rollover Color Level 1: <input class="widefat" id="<?php echo $this->get_field_id('bgrollovercolor1'); ?>" name="<?php echo $this->get_field_name('bgrollovercolor1'); ?>" type="text" value="<?php echo attribute_escape($bgrollovercolor1); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('bgcolor2'); ?>">BG Color Level 2: <input class="widefat" id="<?php echo $this->get_field_id('bgcolor2'); ?>" name="<?php echo $this->get_field_name('bgcolor2'); ?>" type="text" value="<?php echo attribute_escape($bgcolor2); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('bgrollovercolor2'); ?>">BG Rollover Color Level 2: <input class="widefat" id="<?php echo $this->get_field_id('bgrollovercolor2'); ?>" name="<?php echo $this->get_field_name('bgrollovercolor2'); ?>" type="text" value="<?php echo attribute_escape($bgrollovercolor2); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('bgcolor3'); ?>">BG Color Level 3: <input class="widefat" id="<?php echo $this->get_field_id('bgcolor3'); ?>" name="<?php echo $this->get_field_name('bgcolor3'); ?>" type="text" value="<?php echo attribute_escape($bgcolor3); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('bgrollovercolor3'); ?>">BG Rollover Color Level 3: <input class="widefat" id="<?php echo $this->get_field_id('bgrollovercolor3'); ?>" name="<?php echo $this->get_field_name('bgrollovercolor3'); ?>" type="text" value="<?php echo attribute_escape($bgrollovercolor3); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('fontcolor1'); ?>">Font Color Level 1: <input class="widefat" id="<?php echo $this->get_field_id('fontcolor1'); ?>" name="<?php echo $this->get_field_name('fontcolor1'); ?>" type="text" value="<?php echo attribute_escape($fontcolor1); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('fontrollovercolor1'); ?>">Font Rollover Color Level 1: <input class="widefat" id="<?php echo $this->get_field_id('fontrollovercolor1'); ?>" name="<?php echo $this->get_field_name('fontrollovercolor1'); ?>" type="text" value="<?php echo attribute_escape($fontrollovercolor1); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('fontcolor2'); ?>">Font Color Level 2: <input class="widefat" id="<?php echo $this->get_field_id('fontcolor2'); ?>" name="<?php echo $this->get_field_name('fontcolor2'); ?>" type="text" value="<?php echo attribute_escape($fontcolor2); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('fontrollovercolor2'); ?>">Font Rollover Color Level 2: <input class="widefat" id="<?php echo $this->get_field_id('fontrollovercolor2'); ?>" name="<?php echo $this->get_field_name('fontrollovercolor2'); ?>" type="text" value="<?php echo attribute_escape($fontrollovercolor2); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('fontcolor3'); ?>">Font Color Level 3: <input class="widefat" id="<?php echo $this->get_field_id('fontcolor3'); ?>" name="<?php echo $this->get_field_name('fontcolor3'); ?>" type="text" value="<?php echo attribute_escape($fontcolor3); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('fontrollovercolor3'); ?>">Font Rollover Color Level 3: <input class="widefat" id="<?php echo $this->get_field_id('fontrollovercolor3'); ?>" name="<?php echo $this->get_field_name('fontrollovercolor3'); ?>" type="text" value="<?php echo attribute_escape($fontrollovercolor3); ?>" /></label></p>
  
	<p><label for="<?php echo $this->get_field_id('menutype'); ?>">Menu Type (1=horizontal, 2=vertical): <input class="widefat" id="<?php echo $this->get_field_id('menutype'); ?>" name="<?php echo $this->get_field_name('menutype'); ?>" type="text" value="<?php echo attribute_escape($menutype); ?>" /></label></p>


<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['bgcolor1'] = $new_instance['bgcolor1'];
    $instance['bgrollovercolor1'] = $new_instance['bgrollovercolor1'];
    $instance['bgcolor2'] = $new_instance['bgcolor2'];
    $instance['bgrollovercolor2'] = $new_instance['bgrollovercolor2'];
    $instance['bgcolor3'] = $new_instance['bgcolor3'];
    $instance['bgrollovercolor3'] = $new_instance['bgrollovercolor3'];
	$instance['fontcolor1'] = $new_instance['fontcolor1'];
    $instance['fontrollovercolor1'] = $new_instance['fontrollovercolor1'];
    $instance['fontcolor2'] = $new_instance['fontcolor2'];
    $instance['fontrollovercolor2'] = $new_instance['fontrollovercolor2'];
    $instance['fontcolor3'] = $new_instance['fontcolor3'];
    $instance['fontrollovercolor3'] = $new_instance['fontrollovercolor3'];
    $instance['menutype'] = $new_instance['menutype'];
    return $instance;
  }
 
 
  function widget($args, $instance)
  {
	
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $bgcolor1 = empty($instance['bgcolor1']) ? ' ' : apply_filters('widget_bgcolor1', $instance['bgcolor1']);
    $bgrollovercolor1 = empty($instance['bgrollovercolor1']) ? ' ' : apply_filters('widget_bgrollovercolor1', $instance['bgrollovercolor1']);
	$bgcolor2 = empty($instance['bgcolor2']) ? ' ' : apply_filters('widget_bgcolor2', $instance['bgcolor2']);
    $bgrollovercolor2 = empty($instance['bgrollovercolor2']) ? ' ' : apply_filters('widget_bgrollovercolor2', $instance['bgrollovercolor2']);
	$bgcolor3 = empty($instance['bgcolor3']) ? ' ' : apply_filters('widget_bgcolor3', $instance['bgcolor3']);
    $bgrollovercolor3 = empty($instance['bgrollovercolor3']) ? ' ' : apply_filters('widget_bgrollovercolor3', $instance['bgrollovercolor3']);
	$fontcolor1 = empty($instance['fontcolor1']) ? ' ' : apply_filters('widget_fontcolor1', $instance['fontcolor1']);
    $fontrollovercolor1 = empty($instance['fontrollovercolor1']) ? ' ' : apply_filters('widget_fontrollovercolor1', $instance['fontrollovercolor1']);
	$fontcolor2 = empty($instance['fontcolor2']) ? ' ' : apply_filters('widget_fontcolor2', $instance['fontcolor2']);
    $fontrollovercolor2 = empty($instance['fontrollovercolor2']) ? ' ' : apply_filters('widget_fontrollovercolor2', $instance['fontrollovercolor2']);
	$fontcolor3 = empty($instance['fontcolor3']) ? ' ' : apply_filters('widget_fontcolor3', $instance['fontcolor3']);
    $fontgrollovercolor3 = empty($instance['fontrollovercolor3']) ? ' ' : apply_filters('widget_fontrollovercolor3', $instance['fontrollovercolor3']);
    $menutype = empty($instance['menutype']) ? ' ' : apply_filters('widget_menutype', $instance['menutype']);
 
    // WIDGET CODE GOES HERE
	//query the database for our settings
	if($menutype == "1"){
		include("wp-content/plugins/levelfourstorefront/storemenu-top.php");
	}else{
		include("wp-content/plugins/levelfourstorefront/storemenu-vertical.php");
		create_l4_vert_menu($bgcolor1, $bgrollovercolor1, $bgcolor2, $bgrollovercolor2, $bgcolor3, $bgrollovercolor3, $fontcolor1, $fontrollovercolor1, $fontcolor2, $fontrollovercolor2, $fontcolor3, $fontrollovercolor3);
	}
	
    echo $after_widget;
  }
 
}


class L4CartWidget extends WP_Widget
{
	
  function L4CartWidget()
  {
    $widget_ops = array('classname' => 'L4CartWidget', 'description' => 'Displays the cart for your Level Four Storefront' );
    $this->WP_Widget('L4CartWidget', 'L4 Mini Cart', $widget_ops);
  }
 
  function form($instance)
  {
	$defaults = array(
		'title' => 'Shopping Cart',
		'carttype' => '1'
	);
	$instance = wp_parse_args( (array) $instance, $defaults);
	$title = $instance['title'];
	$carttype = $instance['carttype'];
	?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  
	<p><label for="<?php echo $this->get_field_id('carttype'); ?>">Cart Type (1=square, 2=wide): <input class="widefat" id="<?php echo $this->get_field_id('carttype'); ?>" name="<?php echo $this->get_field_name('carttype'); ?>" type="text" value="<?php echo attribute_escape($carttype); ?>" /></label></p>


<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['carttype'] = $new_instance['carttype'];
    return $instance;
  }
 
 
  function widget($args, $instance)
  {
	
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $carttype = empty($instance['carttype']) ? ' ' : apply_filters('widget_carttype', $instance['carttype']);
 
    if (strlen($title) > 0)
      echo $before_title . $title . $after_title;;
 
    // WIDGET CODE GOES HERE
	//query the database for our settings
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
	
	$widget_cart_sql = sprintf("SELECT * FROM tempcart WHERE sessionid = '%s'", mysql_real_escape_string(session_id()));
	$widget_cart_result = mysql_query($widget_cart_sql);
	
	$tempcart_total_items = 0;
	$tempcart_subtotal = 0;
	
	while($widget_row = mysql_fetch_assoc($widget_cart_result)){
		$tempcart_total_items = $tempcart_total_items + $widget_row['quantity'];
		$tempcart_subtotal = $tempcart_subtotal + $widget_row['orderprice'] * $widget_row['quantity'];
	}
	
	if($tempcart_total_items > 0){
		if($carttype == 1){
		    echo "Items in Cart: ".$tempcart_total_items."<br />Sub-Total: ".$row_settingsRS['currencySymbol'].number_format($tempcart_subtotal, 2)."<br /><a href=\"".$cartpage."\">Checkout</a>";
		}else if($carttype == 2){
			echo $tempcart_total_items." Items in Cart Totaling ".$row_settingsRS['currencySymbol'].number_format($tempcart_subtotal, 2)." <a href=\"".$cartpage."\">Checkout</a>";
		}
	}else{
		echo "No Items in Your Cart";	
	}
	
    echo $after_widget;
  }
 
}

class L4NewsletterWidget extends WP_Widget
{
  function L4NewsletterWidget()
  {
    $widget_ops = array('classname' => 'L4NewsletterWidget', 'description' => 'Displays a newsletter signup form for your Level Four Storefront' );
    $this->WP_Widget('L4NewsletterWidget', 'L4 Newsletter Signup', $widget_ops);
  }
 
  function form($instance)
  {
	$defaults = array(
		'title' => 'Newsletter Signup'
	);
	$instance = wp_parse_args( (array) $instance, $defaults);
	$title = $instance['title'];
	?>
    
	<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
 
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
	session_start();
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (strlen($title) > 0)
      echo $before_title . $title . $after_title;;
 
    // WIDGET CODE GOES HERE
	if(isset($_GET['l4submittype'])){
	  $l4news_sql = sprintf("INSERT INTO subscribers(email) VALUES('%s')", mysql_real_escape_string($_GET['l4newsemail']));
	  $l4news_result = mysql_query($l4news_sql);
	  echo "You are now signed up.";	
	}
	
	echo "<form action=\"\"><input type=\"text\" name=\"l4newsemail\" id=\"l4newsemail\" /><input type=\"hidden\" value=\"l4newsletter\" name=\"l4submittype\" id=\"l4submittype\" /><input type=\"hidden\" value=\"".$storepage."\" name=\"storeurl\" /><input type=\"submit\" value=\"Sign-Up\" /></form>";
	
    echo $after_widget;
  }
 
}

class L4SpecialsWidget extends WP_Widget
{
	
  function L4SpecialsWidget()
  {
    $widget_ops = array('classname' => 'L4SpecialsWidget', 'description' => 'Displays the products listed as specials for your Level Four Storefront' );
    $this->WP_Widget('L4SpecialsWidget', 'L4 Specials', $widget_ops);
  }
 
  function form($instance)
  {
	$defaults = array(
		'title' => 'Specials',
		'numprods' => '3'
	);
	$instance = wp_parse_args( (array) $instance, $defaults);
	$title = $instance['title'];
	$numprods = $instance['numprods'];
	?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  
	<p><label for="<?php echo $this->get_field_id('numprods'); ?>">Number of Products to Display: <input class="widefat" id="<?php echo $this->get_field_id('numprods'); ?>" name="<?php echo $this->get_field_name('numprods'); ?>" type="text" value="<?php echo attribute_escape($numprods); ?>" /></label></p>


<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['numprods'] = $new_instance['numprods'];
    return $instance;
  }
 
 
  function widget($args, $instance)
  {
	
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $numprods = empty($instance['numprods']) ? ' ' : apply_filters('widget_numprods', $instance['numprods']);
 
    if (strlen($title) > 0)
      echo $before_title . $title . $after_title;;
 
    // WIDGET CODE GOES HERE
	//query the database for our settings
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
	
	$widget_products_sql = "SELECT products.* FROM products LEFT JOIN reviews ON (reviews.ProductID = products.ProductID) WHERE products.isSpecial = 1 AND products.inStock = 1 ORDER BY products.Title LIMIT " . mysql_real_escape_string($numprods);
	$widget_products_result = mysql_query($widget_products_sql);
	$widget_products_numrows = mysql_num_rows($widget_products_result);
	
	if($widget_products_numrows > 0){
	
		while($row = mysql_fetch_assoc($widget_products_result)){?>
			
			<div class="widget_table_holder">
	
				<div class="bordertable">
                    	<a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row['ModelNumber']; ?><?php if($menulevel == 1){ echo "&amp;menuid=".$menu_row['keyfield']."&amp;menu=".sanatizeCategory($menu_row['menuName']); }else if($menulevel == 2){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2']); }else if($menulevel == 3){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;subsubmenuid=".$menu_row['keyfield3']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2'])."&amp;subsubmenu=".sanatizeCategory($menu_row['menuName3']); } ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; }?>" class="product_title_link">
	
							<img src="<?php echo str_replace("levelfourstorefront/", "", plugin_dir_url(__DIR__) ); ?>levelfourstorefront/products/pics1/images.php?max_width=<?php echo get_option('l4_option_medium_width'); ?>&max_height=<?php echo get_option('l4_option_medium_height'); ?>&imgfile=<?php echo $row['Image1']; ?>" class="product_image" alt="<?php echo $row['ModelNumber']; ?>" />
                    
                    	</a><br>
	
					<a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row['ModelNumber']; ?><?php if($menulevel == 1){ echo "&amp;menuid=".$menu_row['keyfield']."&amp;menu=".sanatizeCategory($menu_row['menuName']); }else if($menulevel == 2){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2']); }else if($menulevel == 3){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;subsubmenuid=".$menu_row['keyfield3']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2'])."&amp;subsubmenu=".sanatizeCategory($menu_row['menuName3']); } ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; }?>" class="product_title_link"><?php echo $row['Title']; ?></a><br />
	
					<?php if($row['ListPrice'] && $row['ListPrice'] != "0.00"){ ?>
					<span class="newprice"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo $row['Price']; ?></span> <span class="oldprice"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo $row['ListPrice']; ?></span><br /><?php }else{ ?>
					<?php echo $row_settingsRS['currencySymbol']; ?><?php echo $row['Price']; ?><br />
					<?php }?>
                    <?php
						$rating_sql = "SELECT AVG(reviews.rating) AS review_avg FROM reviews WHERE reviews.productID = ".$row['ProductID']." AND (reviews.reviewapproved = 1 OR reviews.reviewapproved IS NULL)";
						$rating_result = mysql_query($rating_sql);
						$rating_row = mysql_fetch_assoc($rating_result);
						$thisrating = $rating_row['review_avg'];
					?>
					
					
			  </div>
	
			</div>
		<?php }
		
	}else{
		echo "No Specials Available";	
	}
	
    echo $after_widget;
  }
 
}

class L4CategoriesWidget extends WP_Widget
{
  function L4CategoriesWidget()
  {
    $widget_ops = array('classname' => 'L4CategoriesWidget', 'description' => 'Displays categories for your L4 Storefront. Can be used as a menu system, but will no display more than one level at a time.' );
    $this->WP_Widget('L4CategoriesWidget', 'L4 Categories', $widget_ops);
  }
 
  function form($instance)
  {
	$defaults = array(
		'title' => 'Categories',
		'showquantity' => '0'
	);
	$instance = wp_parse_args( (array) $instance, $defaults);
	$title = $instance['title'];
	$showquantity = $instance['showquantity'];
	?>
    
	<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('showquantity'); ?>">Show Quantity (0=No, 1=Yes): <input class="widefat" id="<?php echo $this->get_field_id('showquantity'); ?>" name="<?php echo $this->get_field_name('showquantity'); ?>" type="text" value="<?php echo attribute_escape($showquantity); ?>" /></label></p>
 
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['showquantity'] = $new_instance['showquantity'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
	session_start();
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $showquantity = empty($instance['showquantity']) ? ' ' : apply_filters('widget_showquantity', $instance['showquantity']);
	
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

 	include("getsortcategories.php");
	
    echo $after_widget;
  }
 
}

class L4ManufacturersWidget extends WP_Widget
{
  function L4ManufacturersWidget()
  {
    $widget_ops = array('classname' => 'L4ManufacturersWidget', 'description' => 'Displays manufacturers for your L4 Storefront. Used to filter results, but can also allow a quick search from other pages in your WordPress blog.' );
    $this->WP_Widget('L4ManufacturersWidget', 'L4 Manufacturers', $widget_ops);
  }
 
  function form($instance)
  {
	$defaults = array(
		'title' => 'Manufacturers',
		'showquantity' => '0'
	);
	$instance = wp_parse_args( (array) $instance, $defaults);
	$title = $instance['title'];
	$showquantity = $instance['showquantity'];
	?>
    
	<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('showquantity'); ?>">Show Quantity (0=No, 1=Yes): <input class="widefat" id="<?php echo $this->get_field_id('showquantity'); ?>" name="<?php echo $this->get_field_name('showquantity'); ?>" type="text" value="<?php echo attribute_escape($showquantity); ?>" /></label></p>
 
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['showquantity'] = $new_instance['showquantity'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
	session_start();
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $showquantity = empty($instance['showquantity']) ? ' ' : apply_filters('widget_showquantity', $instance['showquantity']);
 
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
 
    include("getsortmanufacturers.php");
	
    echo $after_widget;
  }
 
}

class L4PriceWidget extends WP_Widget
{
  function L4PriceWidget()
  {
    $widget_ops = array('classname' => 'L4PriceWidget', 'description' => 'Displays price points for your L4 Storefront. Used to filter results, but can also allow a quick search from other pages in your WordPress blog.' );
    $this->WP_Widget('L4PriceWidget', 'L4 Price Points', $widget_ops);
  }
 
  function form($instance)
  {
	$defaults = array(
		'title' => 'Price',
		'showquantity' => '0'
	);
	$instance = wp_parse_args( (array) $instance, $defaults);
	$title = $instance['title'];
	$showquantity = $instance['showquantity'];
	?>
    
	<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
    
    <p><label for="<?php echo $this->get_field_id('showquantity'); ?>">Show Quantity (0=No, 1=Yes): <input class="widefat" id="<?php echo $this->get_field_id('showquantity'); ?>" name="<?php echo $this->get_field_name('showquantity'); ?>" type="text" value="<?php echo attribute_escape($showquantity); ?>" /></label></p>
 
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['showquantity'] = $new_instance['showquantity'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
	session_start();
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $showquantity = empty($instance['showquantity']) ? ' ' : apply_filters('widget_showquantity', $instance['showquantity']);
 
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
	
    include("getsortpricepoints.php");
	
    echo $after_widget;
  }
 
}

add_action( 'widgets_init', create_function('', 'return register_widget("L4MenuWidget");') );
add_action( 'widgets_init', create_function('', 'return register_widget("L4CartWidget");') );
add_action( 'widgets_init', create_function('', 'return register_widget("L4NewsletterWidget");') );
add_action( 'widgets_init', create_function('', 'return register_widget("L4SpecialsWidget");') );
add_action( 'widgets_init', create_function('', 'return register_widget("L4CategoriesWidget");') );
add_action( 'widgets_init', create_function('', 'return register_widget("L4ManufacturersWidget");') );
add_action( 'widgets_init', create_function('', 'return register_widget("L4PriceWidget");') );

//Enable short codes in widget
add_filter('widget_text', 'do_shortcode');

//////////////////////////////////////////////
//END WIDGETS
//////////////////////////////////////////////

//////////////////////////////////////////////
//UPDATE FUNCTIONS
//////////////////////////////////////////////

function levelfourstorefront_copyr($source, $dest){
    
	// Check for symlinks
    if (is_link($source)) {
        return symlink(readlink($source), $dest);
    }

    // Simple copy for a file
    if (is_file($source)) {
        return copy($source, $dest);
    }

    // Make destination directory
    if (!is_dir($dest)) {
        mkdir($dest);
    }

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // Deep copy directories
        levelfourstorefront_copyr("$source/$entry", "$dest/$entry"); // <------- defines levelfourstorefront copy action
    }

    // Clean up
    $dir->close();
    return true;
}

function levelfourstorefront_backup(){
	
    $to = dirname(__FILE__)."/../l4-back-up-directory/"; // <------- this back up directory will be made
    $from = dirname(__FILE__) . "/"; // <------- this is the directory that will be backed up
    
	 // Make destination directory
    if (!is_dir($to)) {
        mkdir($to);
    }
	
	levelfourstorefront_copyr($from . "products", $to . "products"); // <------- executes levelfourstorefront copy action
	levelfourstorefront_copyr($from . "images", $to . "images"); // <------- executes levelfourstorefront copy action
	
	 // Make Connections directory
    if (!is_dir($to . "Connections/")) {
        mkdir($to . "Connections/");
    }
	
	 // Make scripts directory
    if (!is_dir($to . "scripts/")) {
        mkdir($to . "scripts/");
    }
	
	
	levelfourstorefront_copyr($from . "Connections/flashdb.php", $to . "Connections/flashdb.php"); // <------- executes levelfourstorefront copy action
	levelfourstorefront_copyr($from . "scripts/mainstylesheet.css", $to . "scripts/mainstylesheet.css"); // <------- executes levelfourstorefront copy action
	levelfourstorefront_copyr($from . "scripts/mainstylesheet.css", $to . "scripts/mainstylesheet.css"); // <------- executes levelfourstorefront copy action
	levelfourstorefront_copyr($from . "scripts/mainstylesheet_dark.css", $to . "scripts/mainstylesheet_dark.css"); // <------- executes levelfourstorefront copy action
	
	
}

function recursive_remove_directory($directory, $empty=FALSE) {
     // if the path has a slash at the end we remove it here
     if(substr($directory,-1) == '/')
     {
         $directory = substr($directory,0,-1);
     }
  
     // if the path is not valid or is not a directory ...
     if(!file_exists($directory) || !is_dir($directory))
     {
         // ... we return false and exit the function
         return FALSE;
  
     // ... if the path is not readable
     }elseif(!is_readable($directory))
     {
         // ... we return false and exit the function
         return FALSE;
  
     // ... else if the path is readable
     }else{
  
         // we open the directory
         $handle = opendir($directory);
  
         // and scan through the items inside
         while (FALSE !== ($item = readdir($handle)))
         {
             // if the filepointer is not the current directory
             // or the parent directory
             if($item != '.' && $item != '..')
             {
                 // we build the new path to delete
                 $path = $directory.'/'.$item;
  
                 // if the new path is a directory
                 if(is_dir($path)) 
                 {
                     // we call this function with the new path
                    recursive_remove_directory($path);

                 // if the new path is a file
                 }else{
                     // we remove the file
                     unlink($path);
                 }
             }
         }
         // close the directory
         closedir($handle);
		  
         // if the option to empty is not set to true
         if($empty == FALSE)
         {
             // try to delete the now empty directory
             if(!rmdir($directory))
             {
                 // return false if not possible
                 return FALSE;
             }
         }
         // return success
         return TRUE;
     }
 }

function levelfourstorefront_recover(){
	
    $from = dirname(__FILE__)."/../l4-back-up-directory/"; // <------- this back up directory will be made
    $to = dirname(__FILE__) . "/"; // <------- this is the directory that will be backed up
    
	levelfourstorefront_copyr($from . "products", $to . "products"); // <------- executes levelfourstorefront copy action
	levelfourstorefront_copyr($from . "images", $to . "images"); // <------- executes levelfourstorefront copy action
	
	levelfourstorefront_copyr($from . "Connections/flashdb.php", $to . "Connections/flashdb.php"); // <------- executes levelfourstorefront copy action
	levelfourstorefront_copyr($from . "scripts/mainstylesheet.css", $to . "scripts/mainstylesheet.css"); // <------- executes levelfourstorefront copy action
	levelfourstorefront_copyr($from . "scripts/mainstylesheet.css", $to . "scripts/mainstylesheet.css"); // <------- executes levelfourstorefront copy action
	levelfourstorefront_copyr($from . "scripts/mainstylesheet_dark.css", $to . "scripts/mainstylesheet_dark.css"); // <------- executes levelfourstorefront copy action
	
    if (is_dir($from)) {
        recursive_remove_directory($from); //<------- deletes the backup directory
    }
	
	//Check for an ugrade script and run it, this will upgrade anything in the db
	if( file_exists( "scripts/sql/upgrade.sql" ) ){
		
		//Put up the databse for website
		$url = "scripts/sql/upgrade.sql";
		
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
		
	}
	
	//Add the new options
	add_option( 'l4_option_use_pretty_image_names', '0' );
	
}

add_filter('upgrader_pre_install', 'levelfourstorefront_backup', 10, 2); // <------- adds the levelfourstorefront_backup filter
add_filter('upgrader_post_install', 'levelfourstorefront_recover', 10, 2); //<------- adds the levelfourstorefront_recover filter

//////////////////////////////////////////////
//END UPDATE FUNCTIONS
//////////////////////////////////////////////

//////////////////////////////////////////////
//START LEVEL FOUR ADMIN PAGE(S)
//////////////////////////////////////////////

function l4_create_menu() {
	add_menu_page( 
		__('Cart Settings', EMU2_I18N_DOMAIN),
		__('Cart Settings', EMU2_I18N_DOMAIN),
		0,
		'levelfourstorefront/settings.php',
		'',
		plugins_url('images/l4icon16x16.png', __FILE__)
	);
	
	
	//call register settings function
	add_action( 'admin_init', 'l4_register_settings' );
	
}


function l4_register_settings() {
	//register settings
	register_setting( 'l4-settings-group', 'l4_option_storepage' );
	register_setting( 'l4-settings-group', 'l4_option_cartpage' );
	register_setting( 'l4-settings-group', 'l4_option_accountpage' );
	register_setting( 'l4-settings-group', 'l4_option_sideMenuOnProducts' );
	register_setting( 'l4-settings-group', 'l4_option_sideMenuOnProductDetails' );
	register_setting( 'l4-settings-group', 'l4_option_stylesheettype' );
	register_setting( 'l4-settings-group', 'l4_option_googleanalyticsid' );
	register_setting( 'l4-settings-group', 'l4_option_num_prods_per_row' );
	register_setting( 'l4-settings-group', 'l4_option_button_color1' );
	register_setting( 'l4-settings-group', 'l4_option_button_color2' );
	register_setting( 'l4-settings-group', 'l4_option_button_font_color' );
	register_setting( 'l4-settings-group', 'l4_option_button_color1_hover' );
	register_setting( 'l4-settings-group', 'l4_option_button_color2_hover' );
	register_setting( 'l4-settings-group', 'l4_option_button_font_color_hover' );
	register_setting( 'l4-settings-group', 'l4_option_header_color1' );
	register_setting( 'l4-settings-group', 'l4_option_header_color2' );
	register_setting( 'l4-settings-group', 'l4_option_header_font_color' );
	register_setting( 'l4-settings-group', 'l4_option_title_font_color' );
	register_setting( 'l4-settings-group', 'l4_option_link_font_color' );
	register_setting( 'l4-settings-group', 'l4_option_link_font_color_hover' );
	register_setting( 'l4-settings-group', 'l4_option_categories_title' );
	register_setting( 'l4-settings-group', 'l4_option_manufacturers_title' );
	register_setting( 'l4-settings-group', 'l4_option_pricepoints_title' );
	register_setting( 'l4-settings-group', 'l4_option_guest_text' );
	register_setting( 'l4-settings-group', 'l4_option_submit_order_text' );
	register_setting( 'l4-settings-group', 'l4_option_xsmall_width' );
	register_setting( 'l4-settings-group', 'l4_option_xsmall_height' );
	register_setting( 'l4-settings-group', 'l4_option_small_width' );
	register_setting( 'l4-settings-group', 'l4_option_small_height' );
	register_setting( 'l4-settings-group', 'l4_option_medium_width' );
	register_setting( 'l4-settings-group', 'l4_option_medium_height' );
	register_setting( 'l4-settings-group', 'l4_option_large_width' );
	register_setting( 'l4-settings-group', 'l4_option_large_height' );
	register_setting( 'l4-settings-group', 'l4_option_swatch_small_width' );
	register_setting( 'l4-settings-group', 'l4_option_swatch_small_height' );
	register_setting( 'l4-settings-group', 'l4_option_swatch_large_width' );
	register_setting( 'l4-settings-group', 'l4_option_swatch_large_height' );
	register_setting( 'l4-settings-group', 'l4_option_use_facebook_icon' );
	register_setting( 'l4-settings-group', 'l4_option_use_twitter_icon' );
	register_setting( 'l4-settings-group', 'l4_option_use_delicious_icon' );
	register_setting( 'l4-settings-group', 'l4_option_use_myspace_icon' );
	register_setting( 'l4-settings-group', 'l4_option_use_linkedin_icon' );
	register_setting( 'l4-settings-group', 'l4_option_use_email_icon' );
	register_setting( 'l4-settings-group', 'l4_option_use_digg_icon' );
	register_setting( 'l4-settings-group', 'l4_option_use_googleplus_icon' );
	register_setting( 'l4-settings-group', 'l4_option_use_pinterest_icon' );
	register_setting( 'l4-settings-group', 'l4_option_use_pretty_image_names' );
}

function l4_admin_style()
{
	include('style.php');

}
add_action('admin_print_styles', 'l4_admin_style');

// create custom plugin settings menu
add_action( 'admin_menu', 'l4_create_menu' );

?>