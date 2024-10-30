<?php

	require_once('../Connections/flashdb.php');

	mysql_select_db($database_flashdb, $flashdb);

	session_start();	

	$sql = sprintf("SELECT * FROM promocodes WHERE promoID = '%s'", mysql_real_escape_string($_POST['couponcode']));

	$result = mysql_query($sql);

	$numrows = mysql_num_rows($result);

	if($numrows > 0){

		$_SESSION['currcouponcode'] = $_POST['couponcode'];

	}

	header("location:/cart/");

?>