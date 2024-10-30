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

include(WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4store/products_query.php"  );

include(WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/scripts/l4html/l4store_error_codes.php" );

?>

    <table class="store_table">

        <tr>

            <?php if( (!isset($_GET['ModelNumber']) && get_option('l4_option_sideMenuOnProducts') == 1) ||  (isset($_GET['ModelNumber'] ) && get_option('l4_option_sideMenuOnProductDetails') == 1) ){ ?>
			
			<td style="width:25%;"><?php include(WP_PLUGIN_DIR . "/" . L4_PLUGIN_DIRECTORY . "/l4store/sortresults.php" ); ?></td>
            
            <?php }?>

            <td style="width:<?php if( (!isset($_GET['ModelNumber']) && get_option('l4_option_sideMenuOnProducts') == 1) ||  (isset($_GET['ModelNumber'] ) && get_option('l4_option_sideMenuOnProductDetails') == 1) ){ echo "100%"; }else{ echo "75%"; } ?>;">
			
			  <?php if(isset($_GET['Error'])){?>

              <div class="error"><?php echo $L4ErrorCodes[$_GET['Error']]; ?></div>

              <?php }?>

              <?php if(isset($_GET['Message'])){?>

              <div class="message"><?php echo $_GET['Message']; ?></div>

              <?php }?>

			  <?php if(isset($_GET['message'])){?>

              <div class="message"><?php echo $_GET['message']; ?></div>

              <?php }?>

              <?php 

                    if(isset($_GET['ModelNumber'])){

                        include(WP_PLUGIN_DIR . "/" . L4_PLUGIN_DIRECTORY . "/l4store/productdetails.php" );

                    }else{

                        include( WP_PLUGIN_DIR . "/" . L4_PLUGIN_DIRECTORY . "/l4store/products.php" );

                    } ?>

            </td>

        </tr>

    </table>

<?php 
mysql_free_result($perpage_result);
mysql_free_result($perpage_result2);
mysql_free_result($menuRS);
mysql_free_result($all_menuRS);
mysql_free_result($result);
mysql_free_result($productlist1);
?>