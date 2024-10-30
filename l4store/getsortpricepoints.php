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

$pricepoint_sql = "SELECT pricepoints.* FROM pricepoints ORDER BY pricepoints.lowpoint";

$pricepoint_result = mysql_query($pricepoint_sql);

$filters_selected = 0;

$filters_used = 0;


while($pricepoint_row = mysql_fetch_assoc($pricepoint_result)){ 
	
	$num_prods = 0;
	for($i=0;$i<count($product_prices);$i++){
		if($pricepoint_row['lessthan'] == "1"){
			if($product_prices[$i] < $pricepoint_row['highpoint']){
				$num_prods++;
			}
		}else if($pricepoint_row['greaterthan'] == "1"){
			if($product_prices[$i] > $pricepoint_row['lowpoint']){
				$num_prods++;
			}
		}else if($product_prices[$i] >= $pricepoint_row['lowpoint'] && $product_prices[$i] <= $pricepoint_row['highpoint']){
			$num_prods++;
		}
	}
	
	if($num_prods > 0){
		$filters_used++;
		?>
    
	<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".$menuname; }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".$menuname; }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".$menuname; } ?>&amp;pricepoint=<?php echo $pricepoint_row['pricepointID']; if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>"<?php if($pricepoint_row['pricepointID'] == $pricepointid){ echo " class=\"sort_products_selected\""; $filters_selected++; }else{ ?> class="sort_products_link"<?php }?>><?php if($pricepoint_row['lessthan'] == "1"){ echo "Less Than $" . number_format($pricepoint_row['highpoint'], 2); }else if($pricepoint_row['greaterthan'] == "1"){ echo "Greater Than $" . number_format($pricepoint_row['lowpoint'], 2); }else{ echo "$" . $pricepoint_row['lowpoint'] . " - $" . $pricepoint_row['highpoint']; } ?> (<?php echo $num_prods; ?>)</a><br />

<?php }} ?>

<?php if($filters_selected > 0){ ?>

	<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".$menuname; }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".$menuname; }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".$menuname; } ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>" class="sort_products_clear_link">clear</a><br />

<?php }else if($filters_used == 0){ echo "No Products"; }?>