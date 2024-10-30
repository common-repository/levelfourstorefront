<?php if(isset($title) && count($title) > 0){?><div class="sort_products_header"><?php echo $title; ?></div><?php }?>
    
    <div class="sort_products_content" id="sort_manufacturers">

<?php

//////////GET THE MAX PER PAGE VARIABLE/////////////////

if(isset($_GET['perpage']) && $_GET['perpage'] != 0){

	$maxperpage = $_GET['perpage'];

}else if(isset($_SESSION['perpage']) && $_SESSION['perpage'] != 0){

	$maxperpage = $_SESSION['perpage'];

}else{

	$maxperpage = 12;

}



$_SESSION['perpage'] = $maxperpage;

////////////////////////////////////////////////////////

$menulevel = 0;



if(isset($_GET['subsubmenuid'])){ // is it sub sub menu item?

	$menuid = $_GET['subsubmenuid'];

	$menuname = $_GET['subsubmenu'];

	$menulevel = 3;

}else if(isset($_GET['submenuid'])){ //Is it Sub Menu Item?

	$menuid = $_GET['submenuid'];

	$menuname = $_GET['submenu'];

	$menulevel = 2;

}else if(isset($_GET['menuid'])){ //Is It Menu Item?

	$menuid = $_GET['menuid'];

	$menuname = $_GET['menu'];

	$menulevel = 1;

} 



/////////////CHECK FOR MANUFACTURER ID////////////////////

$manufacturerid = 0;

if(isset($_GET['manufacturer'])){

	$manufacturerstring = $_GET['manufacturer'];

	$manufacturerlist = explode("^", $manufacturerstring); 

	$manufacturerid = $manufacturerlist[0];

}


////////////GET PER PAGE OPTIONS///////////////

$perpage_sql = "SELECT perpage FROM perpage ORDER BY perpage ASC";
$perpage_result = mysql_query($perpage_sql);
$perpage_result2 = mysql_query($perpage_sql);



//Getting a current manufacturer to sort by. If none, then the where statement remains empty.

$manufacturerwhere = "";

if($manufacturerid != 0){

	$mansql = sprintf("SELECT * FROM manufacturer WHERE manufacturerID = '%s'", mysql_real_escape_string($manufacturerid));

	$manresult = mysql_query($mansql);

	$mannumrows = mysql_num_rows($manresult);

	if($mannumrows > 0){

		$manrow = mysql_fetch_assoc($manresult);

		$manufacturername = $manrow['manufacturername'];

		$manufacturerwhere = " AND products.manufacturer = '" . mysql_real_escape_string($manufacturername) . "' ";

	}

}



////////////CHECK FOR PRICE POINT ID///////////////////////

$pricepointid = 0;

if(isset($_GET['pricepoint'])){

	$pricepointid = $_GET['pricepoint'];

}



//Getting a current price point and the data to sort by. If nothing, do not create where statement.

$pricepointwhere = "";

if($pricepointid != 0){

	$pricesql = sprintf("SELECT * FROM pricepoints WHERE pricepointID = '%s'", mysql_real_escape_string($pricepointid));

	$priceresult = mysql_query($pricesql);

	$pricenumrows = mysql_num_rows($priceresult);

	if($pricenumrows > 0){

		$pricerow = mysql_fetch_assoc($priceresult);

		if($pricerow['lessthan']){

			$pricepointwhere = " AND products.Price < '" . mysql_real_escape_string($pricerow['highpoint']) . "' ";

		}else if($pricerow['greaterthan']){

			$pricepointwhere = " AND products.Price > '" . mysql_real_escape_string($pricerow['lowpoint']) . "' ";

		}else{

			$pricepointwhere = " AND products.Price >= '" . mysql_real_escape_string($pricerow['lowpoint']) . "' AND products.Price <= '" . mysql_real_escape_string($pricerow['highpoint']) . "' ";

		}

	}

}



////////////////////GET MENU DATA//////////////////

if($menulevel == 1 || $menulevel == 2 || $menulevel == 3){

	//Update the menu statistics

	$menustatssql = sprintf("UPDATE menulevel" . mysql_real_escape_string($menulevel) . " SET Clicks = Clicks + 1 WHERE keyfield = '%s'", mysql_real_escape_string($menuid));

	$menuupdateresult = mysql_query($menustatssql);

	

	//Get the current side menu stuff

	if($menulevel == 1){

		$menu_sql = sprintf("SELECT menulevel1.menuName, menulevel1.keyfield FROM menulevel1 WHERE menulevel1.keyfield = '%s'", mysql_real_escape_string($menuid));

	}else if($menulevel == 2){

		$menu_sql = sprintf("SELECT menulevel1.menuName as menuName1, menulevel1.keyfield as keyfield1, menulevel2.menuName as menuName2, menulevel2.keyfield as keyfield2 FROM menulevel2 LEFT JOIN menulevel1 ON (menulevel1.keyfield = menulevel2.menuParentID) WHERE menulevel2.keyfield = '%s'", mysql_real_escape_string($menuid));

	}else if($menulevel == 3){

		$menu_sql = sprintf("SELECT menulevel1.menuName as menuName1, menulevel1.keyfield as keyfield1, menulevel2.menuName as menuName2, menulevel2.keyfield as keyfield2, menulevel3.menuName as menuName3, menulevel3.keyfield as keyfield3 FROM menulevel3 LEFT JOIN menulevel2 ON (menulevel2.keyfield = menulevel3.menuParentID) LEFT JOIN menulevel1 ON (menulevel1.keyfield = menulevel2.menuParentID) WHERE menulevel3.keyfield = '%s'", mysql_real_escape_string($menuid));

	}



	$menu_result = mysql_query($menu_sql);

	$menu_row = mysql_fetch_assoc($menu_result);

}



//////////////CHECK FOR CURRENT PAGE/////////////////////

$pagenum = 0;

if(isset($_GET['pagenum'])){

	$pagenum = $_GET['pagenum'];

}



////////////CHECK FOR FILTER NUM, (THIS IS THE PRODUCT SORT METHOD)

$filternum = 0;

if(isset($_GET['filternum']) && $_GET['filternum'] != 0){

	$filternum = $_GET['filternum'];

	$_SESSION['filternum'] = $filternum;

}else if(isset($_SESSION['filternum'])){

	$filternum = $_SESSION['filternum'];

}



//Now find the pagenation stuff

$startitem = $pagenum * $maxperpage;



//Sort done by the filter number

$orderby = "";

$orderquery = " products.Price ASC"; // Initialize to price, this is the first option.



//We already pulled the filter number, now go through and get the corresponding filter sql query.

if($filternum != 0){

	$_SESSION['filternum'] = $filternum;

	if($filternum == 1){

		$orderquery = " products.Price ASC";

	}else if($filternum == 2){

		$orderquery = " products.Price DESC";

	}else if($filternum == 3){

		$orderquery = " products.Title ASC";

	}else if($filternum == 4){

		$orderquery = " products.Title DESC";

	}else if($filternum == 5){

		$orderquery = " products.dateadded DESC";

	}else if($filternum == 6){

		$orderquery = " review_avg DESC";

	}else if($filternum == 7){

		$orderquery = " views DESC";

	}	

}



//Now we need a menu where, based on the current menu level.

$menuwhere = " products.featureditem = 1 AND ";

if($menulevel == 1){

	$menuwhere = " (products.Cat1Name = '%s' OR products.Cat1bName = '%s' OR products.Cat1cName = '%s') AND ";

}else if($menulevel == 2){

	$menuwhere = " (products.Cat2Name = '%s' OR products.Cat2bName = '%s' OR products.Cat2cName = '%s') AND ";

}else if($menulevel == 3){

	$menuwhere = " (products.Cat3Name = '%s' OR products.Cat3bName = '%s' OR products.Cat3cName = '%s') AND ";

}





$query_menuRS = sprintf("SELECT 

		  reviews.reviewapproved,

		  AVG(reviews.rating) AS review_avg,

		  COUNT(reviews.reviewID) AS review_count,

		  products.*,

		  statistics.views

		FROM

		  products

		  LEFT JOIN reviews ON (reviews.productID = products.ProductID AND (reviews.reviewapproved = 1 OR reviews.reviewapproved IS NULL))

		  LEFT JOIN statistics ON (statistics.ProductID = products.ProductID)

		WHERE

		  " . $menuwhere . " 

		  products.InStock = 1 " . $manufacturerwhere . $pricepointwhere . "

		GROUP BY

		  products.ProductID

		ORDER BY " . $orderquery, 

			mysql_real_escape_string($menuid), 

			mysql_real_escape_string($menuid),

			mysql_real_escape_string($menuid));

			

$query_limit_menuRS = sprintf("%s LIMIT %d, %d", $query_menuRS, $startitem, $maxperpage);



$menuRS = mysql_query($query_limit_menuRS);

$row_menuRS = mysql_fetch_assoc($menuRS);

$numrows_menuRS = mysql_num_rows($menuRS);



$all_menuRS = mysql_query($query_menuRS);

$totalRows_menuRS = mysql_num_rows($all_menuRS);

$totalPages_menuRS = ceil($totalRows_menuRS/$maxperpage)-1;



$queryString_menuRS = "";

if (!empty($_SERVER['QUERY_STRING'])) {

	$params = explode("&", $_SERVER['QUERY_STRING']);

	$newParams = array();

	foreach ($params as $param) {

	if (stristr($param, "pagenum") == false && stristr($param, "totalRows_menuRS") == false) {

		array_push($newParams, $param);

	}

}



if (count($newParams) != 0) {

	$queryString_menuRS = "&" . htmlentities(implode("&", $newParams));

}

}

$queryString_menuRS = sprintf("&totalRows_menuRS=%d%s", $totalRows_menuRS, $queryString_menuRS);

$enditem = $startitem + $maxperpage;

if($enditem > $totalRows_menuRS){

	$enditem = $totalRows_menuRS;

}

$result = mysql_query($query_limit_menuRS);

$productlist1 = mysql_query($query_menuRS);

$product_manufacturers = array();
$product_prices = array();

while($product_row = mysql_fetch_array($productlist1)){
    $product_manufacturers[] = $product_row['manufacturer'];
	$product_prices[] = $product_row['Price'];
}

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

	<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".$menuname; }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".$menuname; }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".$menuname; } ?>&amp;manufacturer=<?php echo $manufacturer_row['manufacturerID']; if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>"<?php if($manufacturer_row['manufacturerID'] == $manufacturerid){ echo " class=\"sort_products_selected\""; $filters_selected++; }else{ ?> class="sort_products_link"<?php }?>><?php echo $manufacturer_row['manufacturername']; ?><?php if($showquantity == "1"){?> (<?php echo $num_prods; ?>)<?php }?></a><br />

<?php }} ?>



<?php if($filters_selected > 0){ ?>

	<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".$menuname; }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".$menuname; }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".$menuname; } ?><?php if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>" class="sort_products_clear_link">clear</a><br />

<?php }else if($filters_used == 0){ echo "No Products"; }?>

</div>