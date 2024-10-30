<?php
/*
* Level Four License File. This software is protected under U.S. copyright law. We require each website URL to register with
* Level Four Storefront, LLC at www.levelfourstorefront.com. Each license is $499.00 USD or $49 USD per month hosted with
* Level Four Storefront, LLC. Bypassing this file puts you in violation of the terms and conditions of using this software
* and by bypassing this license file you may be procesucted by Level Four Storefront for theft.
*/

//Helper Function, Get URL
function license_url(){
  $protocol = $_SERVER['HTTPS'] ? "https" : "http";
  $baseurl = $_SERVER['HTTP_HOST'];
  $strip = explode("://", $baseurl);
  if(count($strip) > 1){
	  $strip2 = $strip[1];
  }else{
	  $strip2 = $strip[0];
  }
  if(!strstr($strip2, "www.")){
	 $strip2 = "www.".$strip2;
  }
  return $strip2;
}

function checklicense($regCode){
	$val = md5("L4WP" . license_url() . "L4V8WP");
	if($regCode == $val) return true;
	else return false;
}
?>