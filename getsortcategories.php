<?php if(isset($title) && count($title) > 0){?><div class="sort_products_header"><?php echo $title; ?></div><?php }?>
    
    <div class="sort_products_content" id="sort_categories">

<?php

//This is for the left side category menu. What we do is see if there are child menu items

//If there are not, we go up a level and get the parent menu items. This makes for a nice display.

if(isset($_GET['perpage']) && $_GET['perpage'] != 0){

	$maxperpage = $_GET['perpage'];

}else if(isset($_SESSION['perpage']) && $_SESSION['perpage'] != 0){

	$maxperpage = $_SESSION['perpage'];

}else{

	$maxperpage = 12;

}


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

$catmenulevel = $menulevel;

if($catmenulevel == 1){

	$catmenuitem = mysql_real_escape_string($menuid);

	$catmenu_sql = sprintf("SELECT menulevel2.*, menulevel1.menuName as parentMenuName, menulevel1.keyfield as parentMenuID FROM menulevel2 LEFT JOIN menulevel1 ON (menulevel1.keyfield = menulevel2.menuParentID) WHERE menulevel2.menuParentID = '%s' ORDER BY menulevel2.menu2order", mysql_real_escape_string($catmenuitem));

	$catmenu_result = mysql_query($catmenu_sql);

	$catmenu_numrows = mysql_num_rows($catmenu_result);

	

	if($catmenu_numrows == 0){

		$catmenu_sql = "SELECT * FROM menulevel1 ORDER BY menu1order";

		$catmenu_result = mysql_query($catmenu_sql);

		$catmenu_numrows = mysql_num_rows($catmenu_result);

		$catmenulevel = 0;

	}

}else if($catmenulevel == 2){

	$catmenuitem = mysql_real_escape_string($menuid);

	$catmenu_sql = sprintf("SELECT menulevel3.*, menulevel2.menuParentID, menulevel1.menuName as parentMenuName, menulevel1.keyfield as parentMenuID FROM menulevel3 LEFT JOIN menulevel2 ON (menulevel2.keyfield = menulevel3.menuParentID) LEFT JOIN menulevel1 ON (menulevel1.keyfield = menulevel2.menuParentID) WHERE menulevel3.menuParentID = '%s' ORDER BY menu3order", mysql_real_escape_string($catmenuitem));

	$catmenu_result = mysql_query($catmenu_sql);

	$catmenu_numrows = mysql_num_rows($catmenu_result);

	if($catmenu_numrows == 0){

		$getparentmenu_sql = sprintf("SELECT * FROM menulevel2 WHERE keyfield = '%s' ORDER BY menu2order", mysql_real_escape_string($catmenuitem));

		$resultgetparent = mysql_query($getparentmenu_sql);

		$row_getparent = mysql_fetch_assoc($resultgetparent);

		$parentid = $row_getparent['menuParentID'];

		

		$catmenu_sql = sprintf("SELECT menulevel2.*, menulevel1.menuName as parentMenuName, menulevel1.keyfield as parentMenuID FROM menulevel2 LEFT JOIN menulevel1 ON (menulevel1.keyfield = menulevel2.menuParentID) WHERE menulevel2.menuParentID = '%s' ORDER BY menu2order", mysql_real_escape_string($parentid));

		$catmenu_result = mysql_query($catmenu_sql);

		$catmenu_numrows = mysql_num_rows($catmenu_result);

		$catmenulevel = 1;

	}

}else if($catmenulevel == 3){

	$catmenuitem = mysql_real_escape_string($menuid);

	$getparentmenu_sql = sprintf("SELECT * FROM menulevel3 WHERE keyfield = '%s' ORDER BY menu3order", mysql_real_escape_string($catmenuitem));

	$resultgetparent = mysql_query($getparentmenu_sql);

	$row_getparent = mysql_fetch_assoc($resultgetparent);

	$parentid = $row_getparent['menuParentID'];

	$catmenu_sql = sprintf("SELECT menulevel3.*, menulevel2.menuParentID, menulevel1.menuName as parentMenuName, menulevel1.keyfield as parentMenuID FROM menulevel3 LEFT JOIN menulevel2 ON (menulevel2.keyfield = menulevel3.menuParentID) LEFT JOIN menulevel1 ON (menulevel1.keyfield = menulevel2.menuParentID) WHERE menulevel3.menuParentID = '%s' ORDER BY menu3order", mysql_real_escape_string($parentid));

	$catmenu_result = mysql_query($catmenu_sql);

	$catmenu_numrows = mysql_num_rows($catmenu_result);

	$catmenulevel = 2;

	

	if($catmenu_numrows == 0){

		$getparentmenu_sql = sprintf("SELECT * FROM menulevel2 WHERE keyfield = '%s' ORDER BY menu2order", mysql_real_escape_string($parentid));

		$resultgetparent = mysql_query($getparentmenu_sql);

		$row_getparent = mysql_fetch_assoc($resultgetparent);

		$parentid = $row_getparent['menuParentID'];

		

		$catmenu_sql = sprintf("SELECT menulevel2.*, menulevel1.menuName as parentMenuName, menulevel1.keyfield as parentMenuID FROM menulevel2 LEFT JOIN menulevel1 ON (menulevel1.keyfield = menulevel2.menuParentID) WHERE menulevel2.menuParentID = '%s' ORDER BY menu2order", mysql_real_escape_string($parentid));

		$catmenu_result = mysql_query($catmenu_sql);

		$catmenu_numrows = mysql_num_rows($catmenu_result);

		$catmenulevel = 2;

	}

}else{

	$catmenu_sql = sprintf("SELECT * FROM menulevel1 ORDER BY menu1order");

	$catmenu_result = mysql_query($catmenu_sql);

	$catmenu_numrows = mysql_num_rows($catmenu_result);

}



if($catmenu_numrows != 0){

	$i=0;
	
	while($catmenu_row = mysql_fetch_assoc($catmenu_result)){

		if($catmenulevel == 0){
			$menuitems_sql = sprintf("SELECT COUNT(products.ProductID) as ProdCount FROM products WHERE products.InStock = 1 AND (products.Cat1Name = '%s' OR products.Cat1bName = '%s' OR products.Cat1cName = '%s')", mysql_real_escape_string($catmenu_row['keyfield']), mysql_real_escape_string($catmenu_row['keyfield']), mysql_real_escape_string($catmenu_row['keyfield']));
		}else if($catmenulevel == 1){
			$menuitems_sql = sprintf("SELECT COUNT(products.ProductID) as ProdCount FROM products WHERE products.InStock = 1 AND (products.Cat2Name = '%s' OR products.Cat2bName = '%s' OR products.Cat2cName = '%s')", mysql_real_escape_string($catmenu_row['keyfield']), mysql_real_escape_string($catmenu_row['keyfield']), mysql_real_escape_string($catmenu_row['keyfield']));
		}else if($catmenulevel == 2 || $catmenulevel == 3){
			$menuitems_sql = sprintf("SELECT COUNT(products.ProductID) as ProdCount FROM products WHERE products.InStock = 1 AND (products.Cat3Name = '%s' OR products.Cat3bName = '%s' OR products.Cat3cName = '%s')", mysql_real_escape_string($catmenu_row['keyfield']), mysql_real_escape_string($catmenu_row['keyfield']), mysql_real_escape_string($catmenu_row['keyfield']));
		}else{
			$menuitems_sql = sprintf("SELECT COUNT(products.ProductID) as ProdCount FROM products WHERE products.InStock = 1 AND (products.Cat1Name = '%s' OR products.Cat1bName = '%s' OR products.Cat1cName = '%s')", mysql_real_escape_string($catmenu_row['keyfield']), mysql_real_escape_string($catmenu_row['keyfield']), mysql_real_escape_string($catmenu_row['keyfield']));
		}
		
		$menuitems_result = mysql_query($menuitems_sql);
		$menuitems_row = mysql_fetch_assoc($menuitems_result);
		$totmenuitems = $menuitems_row['ProdCount'];

    	if($i == 0 && ($catmenulevel == 2 || $catmenulevel == 3) ){?>

			<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($catmenulevel == 3){ echo "sub"; }?>menuid=<?php echo $catmenu_row['parentMenuID']; ?>&amp;menu=<?php echo sanatizeCategory($catmenu_row['parentMenuName']); if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>" id="sortmenu_<?php echo $catmenu_row['menuParentID']; ?>"  class="sort_products_link_up">Up a Level</a><br />

		<?php }else if($i == 0 && $catmenulevel == 1){ ?>

    		<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>" class="sort_products_link_up">Up a Level</a><br />

        <?php } $i++; ?>

    		

			 <a href="<?php echo $storepage . $permalinkdivider; ?><?php if($catmenulevel == 1){ echo "sub"; }else if($catmenulevel == 2 || $catmenulevel == 3){ echo "subsub"; } ?>menuid=<?php echo $catmenu_row['keyfield']; ?><?php echo "&amp;"; if($catmenulevel == 1){ echo "sub"; }else if($catmenulevel == 2 || $catmenulevel == 3){ echo "subsub"; } echo "menu=".sanatizeCategory($catmenu_row['menuName']);?><?php if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>" id="sortmenu_<?php echo $catmenu_row['keyfield']; ?>"  class="<?php if( $catmenu_row['menuName'] == $menuname || $catmenu_row['keyfield'] == $catmenuid){?>sort_products_selected<?php }else{ echo "sort_products_link"; } ?>"><?php echo $catmenu_row['menuName']; ?><?php if($showquantity == "1"){?> (<?php echo $totmenuitems; ?>)<?php }?></a><br />

	<?php } 

}else{?>

	<div class="no_sort_results">No Categories</div>

<?php } ?>

</div>