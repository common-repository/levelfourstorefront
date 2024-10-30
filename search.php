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

include("l4store/search_query.php");

include("l4store/search.php"); 

?>