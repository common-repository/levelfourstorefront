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

include( WP_PLUGIN_DIR . "/" . L4_PLUGIN_DIRECTORY . '/scripts/l4html/l4store_error_codes.php' );

?>

<div id="store_holder">


	<?php if(isset($_GET['password']) && $_GET['password'] == "reset"){?>

        <div class="loginsuccess ">Your password has been reset and sent to your email address.</div>

    <?php }else if(isset($_GET['password']) && $_GET['password'] == "resetfailed"){?>

        <div class="loginsuccess">An unknown error has occurred while sending your new password to your account. Please try again.</div>

    <?php } ?>

    <?php if(isset($_GET['order']) && $_GET['order'] == "success"){?>

        <div class="loginsuccess">Your order was submitted successfully. You should recieve an email with your receipt shortly.</div>

    <?php }?>

    <?php 

    if(isset($_GET['login']) && $_GET['login'] == "failed"){

        echo "<div class=\"loginfailed\">Login Failed</div>";

    }else if(isset($_GET['signup']) && $_GET['signup'] == "failed" && $_GET['reason'] == "emailerror"){

        echo "<div class=\"loginfailed\">Account Creation Failed - Email Address In Use</div>";

    }else if(isset($_GET['reason']) && $_GET['reason'] == "currentpassworderror"){

		echo "<div class=\"loginfailed\">We could not change your password because the new password you entered was invalid</div>";

	}

    ?>

    <?php 

    if(userloggedin()){

        if(isset($_GET['createaccount']) && $_GET['createaccount'] == "success"){

            include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4account/accountpages/accountinfo.php" );

        }else if(isset($_GET['page'])){

            include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4account/accountpages/".$_GET['page'].".php" );

        }else{

            include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4account/accountpages/dashboard.php" );

        }

    }else{

        if(isset($_GET['page']) && $_GET['page'] == "forgotpw"){

            include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4account/accountpages/forgot_password.php" );

        }else if(isset($_GET['page']) && $_GET['page'] == "register"){

            include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4account/accountpages/register.php" );

        }else if(isset($_GET['page']) && $_GET['page'] == "orderdetails" && isset($_GET['orderid']) && isset($_GET['key'])){

            include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4account/accountpages/orderdetails.php" );

        }else{

            include( WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/l4account/accountpages/login.php" );

        }

    }

    ?>

</div>