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

$filters_selected = 0;

$manufacturer_sql = "SELECT manufacturer.* FROM manufacturer ORDER BY manufacturername ASC";

$manufacturer_result = mysql_query($manufacturer_sql);

$arrayCount = array_count_values($product_manufacturers);

$filters_used = 0;

while($manufacturer_row = mysql_fetch_assoc($manufacturer_result)){ 
	$num_prods = $arrayCount[$manufacturer_row['manufacturername']];
	if($num_prods > 0){
		$filters_used++;
?>

	<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".$menuname; }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".$menuname; }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".$menuname; } ?>&amp;manufacturer=<?php echo $manufacturer_row['manufacturerID']; if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>"<?php if($manufacturer_row['manufacturerID'] == $manufacturerid){ echo " class=\"sort_products_selected\""; $filters_selected++; }else{ ?> class="sort_products_link"<?php }?>><?php echo $manufacturer_row['manufacturername']; ?> (<?php echo $num_prods; ?>)</a><br />

<?php }} ?>



<?php if($filters_selected > 0){ ?>

	<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".$menuname; }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".$menuname; }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".$menuname; } ?><?php if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>" class="sort_products_clear_link">clear</a><br />

<?php }else if($filters_used == 0){ echo "No Products"; }?>