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

<style>
.prod_table_holder{
	width:<?php echo 100/get_option('l4_option_num_prods_per_row'); ?>%;
	float:left;
}
.bordertable {
	width: <?php echo $row_settingsRS['medium_width'] + 10; ?>px;
	border: none;
	font-family:Tahoma, Geneva, sans-serif;
	font-size:12px;
	text-align:center;
}
</style>

<?php

if (mysql_num_rows($result) > 0){ ?>

	<?php 

		if($menulevel != 0){?>

        	<div class="results_title">

			<?php 

			if($menulevel == 1){ 

				echo "<a href=\"". $storepage . $permalinkdivider . "menu=".$menu_row['menuName']."&amp;menuid=".$menu_row['keyfield']."\" class=\"l4store_link\">" . $menu_row['menuName'] . "</a>"; 

			}else if($menulevel == 2){

				echo "<a href=\"". $storepage . $permalinkdivider . "menu=".$menu_row['menuName1']."&amp;menuid=".$menu_row['keyfield1']."\" class=\"l4store_link\">" . $menu_row['menuName1'] . "</a> > <a href=\"". $storepage . "?menu=".$menu_row['menuName1']."&amp;submenuid=".$menu_row['keyfield2'] . "&amp;submenu=".$menu_row['menuName2']."\">" . $menu_row['menuName2'] . "</a>";

			}else if($menulevel == 3){ 

				echo "<a href=\"". $storepage . $permalinkdivider . "menu=".$menu_row['menuName1']."&amp;menuid=".$menu_row['keyfield1']."\" class=\"l4store_link\">" . $menu_row['menuName1'] . "</a> > <a href=\"". $storepage . "?submenu=".$menu_row['menuName2']."&amp;submenuid=".$menu_row['keyfield2'] . "&amp;submenu=".$menu_row['menuName2']."\" class=\"l4store_link\">" . $menu_row['menuName2'] . "</a> > <a href=\"". $storepage . "?subsubmenu=".$menu_row['menuName3']."&amp;subsubmenuid=".$menu_row['keyfield3'] . "&amp;subsubmenu=".$menu_row['menuName3']."\" class=\"l4store_link\">" . $menu_row['menuName3'] . "</a>";

			}?>

            </div>

		<?php 

		}

	?>

    <?php if($menulevel == 1){

			$menulevel2_sql = sprintf("SELECT * FROM menulevel2 WHERE menuParentID = '%s'", mysql_real_escape_string($_GET['menuid']));

			$menulevel2_result = mysql_query($menulevel2_sql);

			$menulevel2_num_rows = mysql_num_rows($menulevel2_result);

	}

	?>

    <div class="divider"></div>

	<div class="floatleft">

    	<select name="sortfield" id="sortfield" onchange="changesort('<?php echo $menuid; ?>', '<?php if($menulevel == 1){ echo sanatizeCategory($menuname); } ?>', '<?php if($menulevel == 2){ echo sanatizeCategory($menuname); } ?>', '<?php if($menulevel == 3){ echo sanatizeCategory($menuname); } ?>', '<?php echo $manufacturerid; ?>', '<?php echo $pricepointid; ?>', '<?php echo $pagenum; ?>', '<?php echo $maxperpage; ?>', '<?php echo $storepage; ?>', '<?php echo $permalinkdivider; ?>');">

            <option value="1"<?php if($filternum == 1){ echo " selected=\"selected\""; }?> >Price Low-High</option>

            <option value="2"<?php if($filternum == 2){ echo " selected=\"selected\""; }?> >Price High-Low</option>

            <option value="3"<?php if($filternum == 3){ echo " selected=\"selected\""; }?> >Title A-Z</option>

            <option value="4"<?php if($filternum == 4){ echo " selected=\"selected\""; }?> >Title Z-A</option>

            <option value="5"<?php if($filternum == 5){ echo " selected=\"selected\""; }?> >Newest</option>

            <option value="6"<?php if($filternum == 6){ echo " selected=\"selected\""; }?> >Best Rating</option>

            <option value="7"<?php if($filternum == 7){ echo " selected=\"selected\""; }?> >Most Viewed</option>

        </select>

		<script>

            document.getElementById('sort_holder').style.display = "block";

        </script>

		<span class="small_font">

        &nbsp;&nbsp;|&nbsp;&nbsp; Items Per Page: 

		 	<?php 

				while($perpage = mysql_fetch_assoc($perpage_result)){

			 		if($maxperpage == $perpage['perpage']){ ?>

    					<span class="perpage_selected"><?php echo $perpage['perpage']; ?></span>

			<?php 	}else{ ?>

            			<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".sanatizeCategory($menuname); }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".sanatizeCategory($menuname); }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".sanatizeCategory($menuname); } ?>&amp;perpage=<?php echo $perpage['perpage']; ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; }?>" class="l4store_link"><?php echo $perpage['perpage']; ?></a> 

			 <?php 	} 

				}

			?>

			&nbsp;&nbsp;|&nbsp;&nbsp;

			<?php

			$start = 0;

			$end = $totalPages_menuRS;

			if($pagenum > 0 && $pagenum < $totalPages_menuRS){

				$start = $pagenum - 1;

			}else if($pagenum > 0 && $pagenum == $totalPages_menuRS && $totalPages_menuRS > 2){

				$start = $totalPages_menuRS-2;

			}

			if($totalPages_menuRS > $start + 2){

				$end = $start + 2;

			}?>

			Page <?php echo $pagenum+1; ?> of <?php echo ($totalPages_menuRS+1); ?>&nbsp;&nbsp;|&nbsp;&nbsp;

			<?php if($pagenum > 0){ ?>

				<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".sanatizeCategory($menuname); }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".sanatizeCategory($menuname); }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".sanatizeCategory($menuname); } ?><?php echo $hrefstring; ?>&amp;pagenum=<?php echo $pagenum - 1; ?>&amp;totalrows=<?php echo $totalRows_menuRS; ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>" class="l4store_link">&lt; Previous</a>

			<?php }

			for($i=$start; $i <= $end; $i++){

				if($pagenum == $i){
					
					echo "<span class=\"pageset_selected\">" . ($i+1) . "</span>";

				}else{ ?>

					<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".sanatizeCategory($menuname); }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".sanatizeCategory($menuname); }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".sanatizeCategory($menuname); } ?><?php echo $hrefstring; ?>&amp;pagenum=<?php echo $i; ?>&amp;totalrows=<?php echo $totalRows_menuRS; ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>" class="l4store_link"><?php echo ($i+1); ?></a>

				<?php }

			}

			if($pagenum < $totalPages_menuRS){ ?>

				<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".sanatizeCategory($menuname); }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".sanatizeCategory($menuname); }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".sanatizeCategory($menuname); } ?><?php echo $hrefstring; ?>&amp;pagenum=<?php echo $pagenum + 1; ?>&amp;totalrows=<?php echo $totalRows_menuRS; ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>" class="l4store_link">Next &gt;</a>

			<?php } ?>

			</span>

    </div>

    <div class="divider"></div>

	<script>

		function swapproductimages(productid, imgnum, totimages){

			for(i=0; i<Number(totimages); i++){

				if(i==imgnum){

					document.getElementById('optionitemimage_'+productid+'_'+i).style.display = "block";

					if(document.getElementById('swatch_'+productid+'_'+i).className != "swatch_img_out_of_stock"){

						document.getElementById('swatch_'+productid+'_'+i).className = "swatch_img_active";

					}

				}else{

					document.getElementById('optionitemimage_'+productid+'_'+i).style.display = "none";

					if(document.getElementById('swatch_'+productid+'_'+i).className != "swatch_img_out_of_stock"){

						document.getElementById('swatch_'+productid+'_'+i).className = "swatch_img";

					}

				}

			}

		}

	</script>

	<?php $k=0; while($row = mysql_fetch_assoc($result)){ 
	
		if($k%get_option('l4_option_num_prods_per_row')==0){
			echo "<div>";
		}
	?>
	
		<div class="prod_table_holder">

			<div class="bordertable">

				<div class="product_image_row">

                	<?php 

						if($row['useoptionitemimages']){

							$optionitems_sql = sprintf("SELECT optionitems.*, optionitemimages.Image1 FROM optionitems, optionitemimages WHERE optionitems.optionparentID = '%s' AND optionitemimages.optionitemID = optionitems.optionitemID AND optionitemimages.productID = '%s' ORDER BY optionitems.optionorder", $row['option1'], $row['ProductID']);

                            $optionitems = mysql_query($optionitems_sql);

							$numoptionitems = mysql_num_rows($optionitems);

							$i=0;

							while($optionitem = mysql_fetch_assoc($optionitems)){ 

								if($i > 0){ echo "<div class=\"l4inactive\" id=\"optionitemimage_".$row['ProductID']."_".$i."\">"; }else{ echo "<div id=\"optionitemimage_".$row['ProductID']."_".$i."\">"; }

							?>

                                <a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row['ModelNumber']; ?>&amp;catid=<?php echo $optionitem['optionitemID']; ?><?php if($menulevel == 1){ echo "&amp;menuid=".$menu_row['keyfield']."&amp;menu=".sanatizeCategory($menu_row['menuName']); }else if($menulevel == 2){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2']); }else if($menulevel == 3){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;subsubmenuid=".$menu_row['keyfield3']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2'])."&amp;subsubmenu=".sanatizeCategory($menu_row['menuName3']); } ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; }?>" class="product_title_link">
								
                                <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_medium_width'); ?>_<?php echo get_option('l4_option_medium_height'); ?>_<?php echo $optionitem['Image1']; ?>" class="product_image" alt="<?php echo $row['ModelNumber']; ?>" border="0" />
                                <?php }else{?>
                                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/images.php?max_width=<?php echo get_option('l4_option_medium_width'); ?>&max_height=<?php echo get_option('l4_option_medium_height'); ?>&imgfile=<?php echo $optionitem['Image1']; ?>" class="product_image" alt="<?php echo $row['ModelNumber']; ?>" border="0" />
                                <?php }?>

                            	</a>

                            </div>

							<?php

							$i++; 

							}

						}else{

					?>

                            <a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row['ModelNumber']; ?><?php if($menulevel == 1){ echo "&amp;menuid=".$menu_row['keyfield']."&amp;menu=".sanatizeCategory($menu_row['menuName']); }else if($menulevel == 2){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2']); }else if($menulevel == 3){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;subsubmenuid=".$menu_row['keyfield3']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2'])."&amp;subsubmenu=".sanatizeCategory($menu_row['menuName3']); } ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; }?>" class="product_title_link">
								
                                <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_medium_width'); ?>_<?php echo get_option('l4_option_medium_height'); ?>_<?php echo $row['Image1']; ?>" class="product_image" alt="<?php echo $row['Title']; ?>" border="0" />
                                <?php }else{?>
                                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/images.php?max_width=<?php echo get_option('l4_option_medium_width'); ?>&max_height=<?php echo get_option('l4_option_medium_height'); ?>&imgfile=<?php echo $row['Image1']; ?>" class="product_image" alt="<?php echo $row['Title']; ?>" border="0" />
                                <?php }?>

                            </a>

                    <?php 

						}

					?>

                </div>

                <div class="product_text_row">

                	<div class="product_title_column">

                        <div class="star_align">

                            <?php if($row['review_avg'] > .5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" alt="Star" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" alt="Off" /><?php }?>

                            <?php if($row['review_avg'] > 1.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" alt="Star" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" alt="Off" /><?php }?>

                            <?php if($row['review_avg'] > 2.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" alt="Star" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" alt="Off" /><?php }?>

                            <?php if($row['review_avg'] > 3.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" alt="Star" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" alt="Off" /><?php }?>

                            <?php if($row['review_avg'] > 4.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" alt="Star" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" alt="Off" /><?php }?>

                        </div>

                		<div class="product_title_align">

               				<a href="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $row['ModelNumber']; ?><?php if($menulevel == 1){ echo "&amp;menuid=".$menu_row['keyfield']."&amp;menu=".sanatizeCategory($menu_row['menuName']); }else if($menulevel == 2){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2']); }else if($menulevel == 3){ echo "&amp;menuid=".$menu_row['keyfield1']."&amp;submenuid=".$menu_row['keyfield2']."&amp;subsubmenuid=".$menu_row['keyfield3']."&amp;menu=".sanatizeCategory($menu_row['menuName1'])."&amp;submenu=".sanatizeCategory($menu_row['menuName2'])."&amp;subsubmenu=".sanatizeCategory($menu_row['menuName3']); } ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; }?>" class="l4store_link"><?php echo $row['Title']; ?>

                            </a>

                        </div>

                    </div>

                    <div class="product_price_column">

							<?php if($row['ListPrice'] && $row['ListPrice'] != "0.00"){ ?>

                				<span class="oldprice"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo $row['ListPrice']; ?></span><br />

                            	<span class="newprice"><sup><?php echo $row_settingsRS['currencySymbol']; ?></sup><?php echo substr($row['Price'], 0, -3); ?><sup><?php echo substr($row['Price'], -2, 2); ?></sup></span>

							<?php }else{?>

                                <br />

                                <span class="regularprice"><sup><?php echo $row_settingsRS['currencySymbol']; ?></sup><?php echo substr($row['Price'], 0, -3); ?><sup><?php echo substr($row['Price'], -2, 2); ?></sup></span>

                            <?php }?>

                    </div>

					<?php if($row['useoptionitemimages']){ ?>

                        <?php 	$optionitems_sql = sprintf("SELECT optionitems.* FROM optionitems WHERE optionitems.optionparentID = '%s' ORDER BY optionitems.optionorder", $row['option1']);

                                $optionitems = mysql_query($optionitems_sql); ?>

                    <div class="product_title_column">			

                        <div class="product_swatch_align">

                            <?php $i=0; $usedActive=0; $jsactivecode = ""; while($optionitem = mysql_fetch_assoc($optionitems)){?>

                            	<?php 

									$optionitemquantity_sql = sprintf("SELECT SUM(optionitemquantity.Quantity) AS Quantity FROM optionitemquantity WHERE OptionItemID1 = '%s' AND ProductID = '%s'", $optionitem['optionitemID'], $row['ProductID']); 

									$optionitemquantity_result = mysql_query($optionitemquantity_sql);

									$optionitemquantity_row = mysql_fetch_assoc($optionitemquantity_result);

									$optionitemquantity = $optionitemquantity_row['Quantity'];

								?>
								
                                <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/swatches/thumb_<?php echo get_option('l4_option_swatch_small_width'); ?>_<?php echo get_option('l4_option_swatch_small_height'); ?>_<?php echo $optionitem['optionitemicon']; ?>" alt="<?php echo $optionitem['optionitemname']; ?>"<?php 
								if($row['useQuantityTracking'] && $optionitemquantity == 0){ 
									echo " class=\"swatch_img_out_of_stock\""; 
								}else if($usedActive == 0 && $row['useQuantityTracking'] && $optionitemquantity > 0){ 
									$usedActive=1; 
									$jsactivecode="swapproductimages('".$row['ProductID']."', '".$i."', '".$numoptionitems."');"; 
									echo " class=\"swatch_img_active\"";
								}else if(!$row['useQuantityTracking'] && $usedActive == 0){ 
									$usedActive=1; 
									$jsactivecode="swapproductimages('".$row['ProductID']."', '".$i."', '".$numoptionitems."');"; 
									echo " class=\"swatch_img_active\""; 
								}else{
									?>  class="swatch_img"<?php }?><?php if(!$row['useQuantityTracking'] || $optionitemquantity > 0){?> onclick="swapproductimages('<?php echo $row['ProductID']; ?>', '<?php echo $i; ?>', '<?php echo $numoptionitems; ?>');"<?php 
								}?> id="swatch_<?php echo $row['ProductID']; ?>_<?php echo $i; ?>" />
                                <?php }else{?>
                                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/swatches/images.php?max_width=<?php echo get_option('l4_option_swatch_small_width'); ?>&max_height=<?php echo get_option('l4_option_swatch_small_height'); ?>&imgfile=<?php echo $optionitem['optionitemicon']; ?>" alt="<?php echo $optionitem['optionitemname']; ?>"<?php 
								if($row['useQuantityTracking'] && $optionitemquantity == 0){ 
									echo " class=\"swatch_img_out_of_stock\""; 
								}else if($usedActive == 0 && $row['useQuantityTracking'] && $optionitemquantity > 0){ 
									$usedActive=1; 
									$jsactivecode="swapproductimages('".$row['ProductID']."', '".$i."', '".$numoptionitems."');"; 
									echo " class=\"swatch_img_active\"";
								}else if(!$row['useQuantityTracking'] && $usedActive == 0){ 
									$usedActive=1; 
									$jsactivecode="swapproductimages('".$row['ProductID']."', '".$i."', '".$numoptionitems."');"; 
									echo " class=\"swatch_img_active\""; 
								}else{
									?>  class="swatch_img"<?php }?><?php if(!$row['useQuantityTracking'] || $optionitemquantity > 0){?> onclick="swapproductimages('<?php echo $row['ProductID']; ?>', '<?php echo $i; ?>', '<?php echo $numoptionitems; ?>');"<?php 
								}?> id="swatch_<?php echo $row['ProductID']; ?>_<?php echo $i; ?>" />
                                <?php }?>

                            <?php $i++; }?>

                        </div>

                    </div>

                    <script>

					<?php echo $jsactivecode; ?>

					</script>

                    <?php }?>

                </div>
                
		  </div>

        </div>
        
        
	<?php
    
		if($k%get_option('l4_option_num_prods_per_row')==(get_option('l4_option_num_prods_per_row')-1)){
			echo "<div class=\"clear\"></div></div>";
		}
 		$k++;
	} 
	
	if($k%get_option('l4_option_num_prods_per_row')!=0){
		echo "<div class=\"clear\"></div></div>";
	}
	?>

	<div class="divider"></div>

	<div class="floatleft">

    	<select name="sortfield2" id="sortfield2" onchange="changesort2('<?php echo $menuid; ?>', '<?php if($menulevel == 1){ echo sanatizeCategory($menuname); } ?>', '<?php if($menulevel == 2){ echo sanatizeCategory($menuname); } ?>', '<?php if($menulevel == 3){ echo sanatizeCategory($menuname); } ?>', '<?php echo $manufacturerid; ?>', '<?php echo $pricepointid; ?>', '<?php echo $pagenum; ?>', '<?php echo $maxperpage; ?>', '<?php echo $storepage; ?>', '<?php echo $permalinkdivider; ?>');">

            <option value="1"<?php if($filternum == 1){ echo " selected=\"selected\""; }?> >Price Low-High</option>

            <option value="2"<?php if($filternum == 2){ echo " selected=\"selected\""; }?> >Price High-Low</option>

            <option value="3"<?php if($filternum == 3){ echo " selected=\"selected\""; }?> >Title A-Z</option>

            <option value="4"<?php if($filternum == 4){ echo " selected=\"selected\""; }?> >Title Z-A</option>

            <option value="5"<?php if($filternum == 5){ echo " selected=\"selected\""; }?> >Newest</option>

            <option value="6"<?php if($filternum == 6){ echo " selected=\"selected\""; }?> >Best Rating</option>

            <option value="7"<?php if($filternum == 7){ echo " selected=\"selected\""; }?> >Most Viewed</option>

        </select>

		<script>

            document.getElementById('sort_holder').style.display = "block";

        </script>

		<span class="small_font">

        &nbsp;&nbsp;|&nbsp;&nbsp; Items Per Page: 

		 	<?php 

				while($perpage = mysql_fetch_assoc($perpage_result2)){

			 		if($maxperpage == $perpage['perpage']){ ?>

    					<span class="perpage_selected"><?php echo $perpage['perpage']; ?></span>

			<?php 	}else{ ?>

            			<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".sanatizeCategory($menuname); }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".sanatizeCategory($menuname); }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".sanatizeCategory($menuname); } ?>&amp;perpage=<?php echo $perpage['perpage']; ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; }?>" class="l4store_link"><?php echo $perpage['perpage']; ?></a> 

			 <?php 	} 

				}

			?>

			&nbsp;&nbsp;|&nbsp;&nbsp;

			<?php

			$start = 0;

			$end = $totalPages_menuRS;

			if($pagenum > 0 && $pagenum < $totalPages_menuRS){

				$start = $pagenum - 1;

			}else if($pagenum > 0 && $pagenum == $totalPages_menuRS && $totalPages_menuRS > 2){

				$start = $totalPages_menuRS-2;

			}

			if($totalPages_menuRS > $start + 2){

				$end = $start + 2;

			}?>

			Page <?php echo $pagenum+1; ?> of <?php echo ($totalPages_menuRS+1); ?>&nbsp;&nbsp;|&nbsp;&nbsp;

			<?php if($pagenum > 0){ ?>

				<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".sanatizeCategory($menuname); }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".sanatizeCategory($menuname); }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".sanatizeCategory($menuname); } ?><?php echo $hrefstring; ?>&amp;pagenum=<?php echo $pagenum - 1; ?>&amp;totalrows=<?php echo $totalRows_menuRS; ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>" class="l4store_link">&lt; Previous</a>

			<?php }

			for($i=$start; $i <= $end; $i++){

				if($pagenum == $i){
					
					echo "<span class=\"pageset_selected\">" . ($i+1) . "</span>";

				}else{ ?>

					<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".sanatizeCategory($menuname); }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".sanatizeCategory($menuname); }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".sanatizeCategory($menuname); } ?><?php echo $hrefstring; ?>&amp;pagenum=<?php echo $i; ?>&amp;totalrows=<?php echo $totalRows_menuRS; ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>" class="l4store_link"><?php echo ($i+1); ?></a>

				<?php }

			}

			if($pagenum < $totalPages_menuRS){ ?>

				<a href="<?php echo $storepage . $permalinkdivider; ?><?php if($menulevel == 1){ echo "menuid=".$menuid."&amp;menu=".sanatizeCategory($menuname); }else if($menulevel == 2){ echo "submenuid=".$menuid."&amp;submenu=".sanatizeCategory($menuname); }else if($menulevel == 3){ echo "subsubmenuid=".$menuid."&amp;subsubmenu=".sanatizeCategory($menuname); } ?><?php echo $hrefstring; ?>&amp;pagenum=<?php echo $pagenum + 1; ?>&amp;totalrows=<?php echo $totalRows_menuRS; ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } if($filternum != 0){ echo "&amp;filternum=".$filternum; } echo "&amp;perpage=" . $maxperpage; ?>" class="l4store_link">Next &gt;</a>

			<?php } ?>

			</span>

    </div>

	</div></div>

<?php }else{ ?>

  <div class="no_results">There are no results that fit your search criteria.</div>

<?php } ?>