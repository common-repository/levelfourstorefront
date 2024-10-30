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

<?php if($row_productRS['useoptionitemimages']){ ?>
<script>
var currbox = 1;
var curropt = 1;

function open_lightbox(num, opt){
	currbox = num;
	curropt = opt;
	
	document.getElementById('photo_' + num + '_lightbox_' + opt).style.display = "block";
	document.getElementById('lightboxbg_' + opt).style.display = "block";
	document.getElementById('lightboxclose_' + opt).style.display = "block";
}

function close_lightbox(){
	document.getElementById('photo_' + currbox + '_lightbox_' + curropt).style.display = "none";
	document.getElementById('lightboxbg_' + curropt).style.display = "none";
	document.getElementById('lightboxclose_' + curropt).style.display = "none";
}

function switch_product_img(divName, totalImgs, optnum) {
	for (var i=1; i<=parseInt(totalImgs); i++) {
		var showDivName = 'photo_' + i + "_" + optnum;
		var showObj = document.getElementById(showDivName);
		if (showDivName == divName){
			showObj.style.display = 'block';
		}else{
			showObj.style.display = 'none';
		}
	}
}

</script>
<?php }else{?>
<script>
var currbox = 1;

function open_lightbox(num){
	currbox = num;
	document.getElementById('photo_' + num + '_lightbox').style.display = "block";
	document.getElementById('lightboxbg').style.display = "block";
	document.getElementById('lightboxclose').style.display = "block";
}

function close_lightbox(){
	document.getElementById('photo_' + currbox + '_lightbox').style.display = "none";
	document.getElementById('lightboxbg').style.display = "none";
	document.getElementById('lightboxclose').style.display = "none";
}

function switch_product_img(divName, totalImgs) {
	for (var i=1; i<=parseInt(totalImgs); i++) {
		var showDivName = 'photo_' + i;
		var showObj = document.getElementById(showDivName);
		if (showDivName == divName){
			showObj.style.display = 'block';
		}else{
			showObj.style.display = 'none';
		}
	}
}
</script>
<?php } ?>

<style>
.lightboxpopup {
   width: <?php echo $row_settingsRS['max_width']; ?>px;
   height: <?php echo $row_settingsRS['max_height']; ?>px;
   position: fixed;
   left: 50%;
   top: 50%; 
   margin-left: -<?php echo $row_settingsRS['max_width']/2; ?>px;
   margin-top: -<?php echo $row_settingsRS['max_height']/2; ?>px;
   display:none;
   z-index:1501;
   -webkit-box-shadow: rgba(0, 0, 0, 0.8) 0px 1px 10px;
	-moz-box-shadow: rgba(0, 0, 0, 0.8) 0px 1px 10px;
	box-shadow: rgba(0, 0, 0, 0.8) 0px 1px 10px;
	
	border: 1px #000 solid;
}



.lightbox_bg{
   	width: 100%;
   	height: 100%;
	position:fixed;
	left:0; top:0;
	background-color:#FFF;
	
	-moz-opacity:.75;
	filter:alpha(opacity=75);
	opacity:.75;
	
	display:none;
	z-index:1001;
}

.lightbox_close{
	min-width:800px;
	min-height:800px;
	position:fixed;
	left:0; top:0;
	background-color:#000;
	
	-moz-opacity:.0;
	filter:alpha(opacity=0);
	opacity:.0;
	
	display:none;
	z-index:2001;
	
	left: 50%;
	top: 50%; 
	margin-left: -<?php echo $row_settingsRS['max_width']/2; ?>px;
	margin-top: -<?php echo $row_settingsRS['max_height']/2; ?>px;
}

.lightbox_close:hover{
	-moz-opacity:.05;
	filter:alpha(opacity=05);
	opacity:.05;
}

.lightbox_close:hover{
	cursor:pointer;
}
</style>
<?php 
	if($row_productRS['useoptionitemimages']){?>

	<?php
		$optionimages_sql = sprintf("SELECT optionitemimages.* FROM optionitems, optionitemimages WHERE optionitems.optionparentID = '%s' AND optionitemimages.optionitemID = optionitems.optionitemID AND optionitemimages.productID = '%s' ORDER BY optionitems.optionorder", $row_productRS['option1'], $row_productRS['ProductID']);
		$optionimages = mysql_query($optionimages_sql);
		$i = 0;
		while($optionimage = mysql_fetch_assoc($optionimages)){?>
        
        	<div id="optionimages_<?php echo $i; ?>"<?php if(isset($_GET['catid'])){ if($_GET['catid'] != $optionimage['optionitemID']){ echo " class=\"l4inactive\""; } }else if($i > 0){ ?> class="l4inactive"<?php }?>>
			
            	<div class="lightbox_bg" id="lightboxbg_<?php echo $i; ?>"></div>
                    <div class="lightbox_close" id="lightboxclose_<?php echo $i; ?>" onclick="close_lightbox()"></div>
                    
                    <div id="photo_1_lightbox_<?php echo $i; ?>" class="lightboxpopup">
                        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/<?php echo $optionimage['Image1']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 1" />
                    </div>
                    
                    <?php if($optionimage['Image2'] != 0 || $optionimage['Image2'] != ""){?>
                    <div id="photo_2_lightbox_<?php echo $i; ?>" class="lightboxpopup">
                        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/<?php echo $optionimage['Image2']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 2" />
                    </div>
                    <?php }?>
                    
                    <?php if($optionimage['Image3'] != 0 || $optionimage['Image3'] != ""){?>
                    <div id="photo_3_lightbox_<?php echo $i; ?>" class="lightboxpopup">
                        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/<?php echo $optionimage['Image3']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 3" />
                    </div>
                    <?php }?>
                    
                    <?php if($optionimage['Image4'] != 0 || $optionimage['Image4'] != ""){?>
                    <div id="photo_4_lightbox_<?php echo $i; ?>" class="lightboxpopup">
                        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/<?php echo $optionimage['Image4']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 4" />
                    </div>
                    <?php }?>
                    
                    <?php if($optionimage['Image5'] != 0 || $optionimage['Image5'] != ""){?>
                    <div id="photo_5_lightbox_<?php echo $i; ?>" class="lightboxpopup">
                        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/<?php echo $optionimage['Image5']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 5" />
                    </div>
                    <?php }?>
                    
                    <div class="l4photos">
                    
                        <div id="photo_1_<?php echo $i; ?>">
                    
                            <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/<?php echo $optionimage['Image1']; ?>" onclick="open_lightbox('1', '<?php echo $i; ?>'); return false;">
                            <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_large_width'); ?>_<?php echo get_option('l4_option_large_height'); ?>_<?php echo $optionimage['Image1']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 1" border="0" class="l4imgfix" />
                            <?php }else{?>
                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/images.php?max_width=<?php echo get_option('l4_option_large_width'); ?>&max_height=<?php echo get_option('l4_option_large_height'); ?>&imgfile=<?php echo $optionimage['Image1']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 1" border="0" class="l4imgfix" />
                            <?php }?>
                            </a>
                    
                        </div>
                        
                        
                    
                        <?php if($optionimage['Image2'] != 0 || $optionimage['Image2'] != ""){?>
                    
                        <div id="photo_2_<?php echo $i; ?>" style="display:none;">
                    
                            <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/<?php echo $optionimage['Image2']; ?>" onclick="open_lightbox('2', '<?php echo $i; ?>'); return false;">
                            <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/thumb_<?php echo get_option('l4_option_large_width'); ?>_<?php echo get_option('l4_option_large_height'); ?>_<?php echo $optionimage['Image2']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 2" border="0" class="l4imgfix" />
                            <?php }else{?>
                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/images.php?max_width=<?php echo get_option('l4_option_large_width'); ?>&max_height=<?php echo get_option('l4_option_large_height'); ?>&imgfile=<?php echo $optionimage['Image2']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 2" border="0" class="l4imgfix" />
                            <?php }?>
                            </a>
                    
                        </div>
                    
                        <?php }?>
                    
                        <?php if($optionimage['Image3'] != 0 || $optionimage['Image3'] != ""){?>
                    
                        <div id="photo_3_<?php echo $i; ?>" style="display:none;">
                    
                            <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/<?php echo $optionimage['Image3']; ?>" onclick="open_lightbox('3', '<?php echo $i; ?>'); return false;">
                            <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/thumb_<?php echo get_option('l4_option_large_width'); ?>_<?php echo get_option('l4_option_large_height'); ?>_<?php echo $optionimage['Image3']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 3" border="0" class="l4imgfix" />
                            <?php }else{?>
                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/images.php?max_width=<?php echo get_option('l4_option_large_width'); ?>&max_height=<?php echo get_option('l4_option_large_height'); ?>&imgfile=<?php echo $optionimage['Image3']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 3" border="0" class="l4imgfix" />
                            <?php }?>
                            </a>
                    
                        </div>
                    
                        <?php }?>
                    
                        <?php if($optionimage['Image4'] != 0 || $optionimage['Image4'] != ""){?>
                    
                        <div id="photo_4_<?php echo $i; ?>" class="photo_inactive">
                    
                            <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/<?php echo $optionimage['Image4']; ?>" onclick="open_lightbox('4', '<?php echo $i; ?>'); return false;">
                            <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/thumb_<?php echo get_option('l4_option_large_width'); ?>_<?php echo get_option('l4_option_large_height'); ?>_<?php echo $optionimage['Image4']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 4" border="0" class="l4imgfix" />
                            <?php }else{?>
                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/images.php?max_width=<?php echo get_option('l4_option_large_width'); ?>&max_height=<?php echo get_option('l4_option_large_height'); ?>&imgfile=<?php echo $optionimage['Image4']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 4" border="0" class="l4imgfix" />
                            <?php }?>
                            </a>
                    
                        </div>
                    
                        <?php }?>
                    
                        <?php if($optionimage['Image5'] != 0 || $optionimage['Image5'] != ""){?>
                    
                        <div id="photo_5_<?php echo $i; ?>" class="photo_inactive">
                    
                            <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/<?php echo $optionimage['Image5']; ?>" onclick="open_lightbox('5', '<?php echo $i; ?>'); return false;">
                            <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/thumb_<?php echo get_option('l4_option_large_width'); ?>_<?php echo get_option('l4_option_large_height'); ?>_<?php echo $optionimage['Image5']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 5" border="0" class="l4imgfix" />
                            <?php }else{?>
                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/images.php?max_width=<?php echo get_option('l4_option_large_width'); ?>&max_height=<?php echo get_option('l4_option_large_height'); ?>&imgfile=<?php echo $optionimage['Image5']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 5" border="0" class="l4imgfix" />
                            <?php }?>
                            </a>
                    
                        </div>
                    
                        <?php }?>
                    
                        <?php
                    
                            if($optionimage['Image5'] != 0 || $optionimage['Image5'] != ""){
                    
                                $totalimgs = 5;
                    
                            }else if($optionimage['Image4'] != 0 || $optionimage['Image4'] != ""){
                    
                                $totalimgs = 4;
                    
                            }else if($optionimage['Image3'] != 0 || $optionimage['Image3'] != ""){
                    
                                $totalimgs = 3;
                    
                            }else if($optionimage['Image2'] != 0 || $optionimage['Image2'] != ""){
                    
                                $totalimgs = 2;
                    
                            }else{
                    
                                $totalimgs = 1;
                    
                            }
                    
                        ?>
                        <?php if($optionimage['Image2'] != 0 || $optionimage['Image2'] != "" || $optionimage['Image3'] != 0 || $optionimage['Image3'] != "" || $optionimage['Image4'] != 0 || $optionimage['Image4'] != "" || $optionimage['Image5'] != 0 || $optionimage['Image5'] != ""){ ?>
                        <ul class="l4thumbs">
                    
                            <li>
                    
                                <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/<?php echo $optionimage['Image1']; ?>" target="_blank" onclick="switch_product_img('photo_1_<?php echo $i; ?>', <?php echo $totalimgs; ?>, '<?php echo $i; ?>'); return false;">
                    				<?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_xsmall_width'); ?>_<?php echo get_option('l4_option_xsmall_height'); ?>_<?php echo $optionimage['Image1']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Thumb 1" class="product_details_image" />
                    				<?php }else{?>
                                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/images.php?max_width=<?php echo get_option('l4_option_xsmall_width'); ?>&max_height=<?php echo get_option('l4_option_xsmall_height'); ?>&imgfile=<?php echo $optionimage['Image1']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Thumb 1" class="product_details_image" />
                                    <?php }?>
                                    
                                </a>
                    
                            </li>
                    
                            <?php if($optionimage['Image2'] != 0 || $optionimage['Image2'] != ""){ ?>
                    
                            <li>
                    
                                <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/<?php echo $optionimage['Image2']; ?>" target="_blank" onclick="switch_product_img('photo_2_<?php echo $i; ?>', '<?php echo $totalimgs; ?>', '<?php echo $i; ?>'); return false;">
                    				
                                    <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/thumb_<?php echo get_option('l4_option_xsmall_width'); ?>_<?php echo get_option('l4_option_xsmall_height'); ?>_<?php echo $optionimage['Image2']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Thumb 2" class="product_details_image" />
                                    <?php }else{?>
                                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/images.php?max_width=<?php echo get_option('l4_option_xsmall_width'); ?>&max_height=<?php echo get_option('l4_option_xsmall_height'); ?>&imgfile=<?php echo $optionimage['Image2']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Thumb 2" class="product_details_image" />
                                    <?php }?>
                    
                                </a>
                    
                            </li>
                    
                            <?php }?>
                    
                            <?php if($optionimage['Image3'] != 0 || $optionimage['Image3'] != ""){ ?>
                    
                            <li>
                    
                                <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/<?php echo $optionimage['Image3']; ?>" target="_blank" onclick="switch_product_img('photo_3_<?php echo $i; ?>', '<?php echo $totalimgs; ?>', '<?php echo $i; ?>'); return false;">
                    				
                                    <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/thumb_<?php echo get_option('l4_option_xsmall_width'); ?>_<?php echo get_option('l4_option_xsmall_height'); ?>_<?php echo $optionimage['Image3']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 3" class="product_details_image" />
                                    <?php }else{?>
                                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/images.php?max_width=<?php echo get_option('l4_option_xsmall_width'); ?>&max_height=<?php echo get_option('l4_option_xsmall_height'); ?>&imgfile=<?php echo $optionimage['Image3']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 3" class="product_details_image" />
                                    <?php }?>
                    
                                </a>
                    
                            </li>
                    
                            <?php }?>
                    
                            <?php if($optionimage['Image4'] != 0 || $optionimage['Image4'] != ""){ ?>
                    
                            <li>
                    
                                <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/<?php echo $optionimage['Image4']; ?>" target="_blank" onclick="switch_product_img('photo_4_<?php echo $i; ?>', '<?php echo $totalimgs; ?>', '<?php echo $i; ?>'); return false;">
                    				
                                    <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/thumb_<?php echo get_option('l4_option_xsmall_width'); ?>_<?php echo get_option('l4_option_xsmall_height'); ?>_<?php echo $optionimage['Image4']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 4" class="product_details_image" />
                                    <?php }else{?>
                                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/images.php?max_width=<?php echo get_option('l4_option_xsmall_width'); ?>&max_height=<?php echo get_option('l4_option_xsmall_height'); ?>&imgfile=<?php echo $optionimage['Image4']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 4" class="product_details_image" />
                                    <?php }?>
                    
                                </a>
                    
                            </li>
                    
                            <?php }?>
                    
                            <?php if($optionimage['Image5'] != 0 || $optionimage['Image5'] != ""){ ?>
                    
                            <li>
                    
                                <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/<?php echo $optionimage['Image5']; ?>" target="_blank" onclick="switch_product_img('photo_5_<?php echo $i; ?>', '<?php echo $totalimgs; ?>', '<?php echo $i; ?>'); return false;">
                    				
                                    <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/thumb_<?php echo get_option('l4_option_xsmall_width'); ?>_<?php echo get_option('l4_option_xsmall_height'); ?>_<?php echo $optionimage['Image5']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 5" class="product_details_image" />
                                    <?php }else{?>
                                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/images.php?max_width=<?php echo get_option('l4_option_xsmall_width'); ?>&max_height=<?php echo get_option('l4_option_xsmall_height'); ?>&imgfile=<?php echo $optionimage['Image5']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 5" class="product_details_image" />
                                    <?php }?>
                    
                                </a>
                    
                            </li>
                    
                            <?php }?>
                    
                        </ul> <?php } //close if more than one thumbnail statement ?>
                    
                    </div>
            
            </div>
	
    <?php $i++; }?>

<?php }else{ ?>
    <div class="lightbox_bg" id="lightboxbg"></div>
    <div class="lightbox_close" id="lightboxclose" onclick="close_lightbox()"><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/close_button2.png" alt="Close Box" /></div>
    
    <div id="photo_1_lightbox" class="lightboxpopup">
        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/<?php echo $row_productRS['Image1']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 1" />
    </div>
    
    <?php if($row_productRS['Image2'] != 0 || $row_productRS['Image2'] != ""){?>
    <div id="photo_2_lightbox" class="lightboxpopup">
        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/<?php echo $row_productRS['Image2']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 2" />
    </div>
    <?php }?>
    
    <?php if($row_productRS['Image3'] != 0 || $row_productRS['Image3'] != ""){?>
    <div id="photo_3_lightbox" class="lightboxpopup">
        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/<?php echo $row_productRS['Image3']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 3" />
    </div>
    <?php }?>
    
    <?php if($row_productRS['Image4'] != 0 || $row_productRS['Image4'] != ""){?>
    <div id="photo_4_lightbox" class="lightboxpopup">
        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/<?php echo $row_productRS['Image4']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 4" />
    </div>
    <?php }?>
    
    <?php if($row_productRS['Image5'] != 0 || $row_productRS['Image5'] != ""){?>
    <div id="photo_5_lightbox" class="lightboxpopup">
        <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/<?php echo $row_productRS['Image5']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 5" />
    </div>
    <?php }?>
    
    <div class="l4photos">
    
        <div id="photo_1">
    
            <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/<?php echo $row_productRS['Image1']; ?>" onclick="open_lightbox('1', '<?php echo $i; ?>'); return false;">
            <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_large_width'); ?>_<?php echo get_option('l4_option_large_height'); ?>_<?php echo $row_productRS['Image1']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 1" border="0" class="l4imgfix" />
            <?php }else{?>
            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/images.php?max_width=<?php echo get_option('l4_option_large_width'); ?>&max_height=<?php echo get_option('l4_option_large_height'); ?>&imgfile=<?php echo $row_productRS['Image1']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 1" border="0" class="l4imgfix" />
            <?php }?>
            </a>
    
        </div>
        
        
    
        <?php if($row_productRS['Image2'] != 0 || $row_productRS['Image2'] != ""){?>
    
        <div id="photo_2" style="display:none;">
    
            <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/<?php echo $row_productRS['Image2']; ?>" onclick="open_lightbox('2', '<?php echo $i; ?>'); return false;">
            <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/thumb_<?php echo get_option('l4_option_large_width'); ?>_<?php echo get_option('l4_option_large_height'); ?>_<?php echo $row_productRS['Image2']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 2" border="0" class="l4imgfix" />
            <?php }else{?>
            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/images.php?max_width=<?php echo get_option('l4_option_large_width'); ?>&max_height=<?php echo get_option('l4_option_large_height'); ?>&imgfile=<?php echo $row_productRS['Image2']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 2" border="0" class="l4imgfix" />
            <?php }?>
            </a>
    
        </div>
    
        <?php }?>
    
        <?php if($row_productRS['Image3'] != 0 || $row_productRS['Image3'] != ""){?>
    
        <div id="photo_3" style="display:none;">
    
            <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/<?php echo $row_productRS['Image3']; ?>" onclick="open_lightbox('3', '<?php echo $i; ?>'); return false;">
            <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/thumb_<?php echo get_option('l4_option_large_width'); ?>_<?php echo get_option('l4_option_large_height'); ?>_<?php echo $row_productRS['Image3']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 3" border="0" class="l4imgfix" />
            <?php }else{?>
            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/images.php?max_width=<?php echo get_option('l4_option_large_width'); ?>&max_height=<?php echo get_option('l4_option_large_height'); ?>&imgfile=<?php echo $row_productRS['Image3']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 3" border="0" class="l4imgfix" />
            <?php }?>
            </a>
    
        </div>
    
        <?php }?>
    
        <?php if($row_productRS['Image4'] != 0 || $row_productRS['Image4'] != ""){?>
    
        <div id="photo_4" class="photo_inactive">
    
            <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/<?php echo $row_productRS['Image4']; ?>" onclick="open_lightbox('4', '<?php echo $i; ?>'); return false;">
            <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/thumb_<?php echo get_option('l4_option_large_width'); ?>_<?php echo get_option('l4_option_large_height'); ?>_<?php echo $row_productRS['Image4']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 4" border="0" class="l4imgfix" />
            <?php }else{?>
            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/images.php?max_width=<?php echo get_option('l4_option_large_width'); ?>&max_height=<?php echo get_option('l4_option_large_height'); ?>&imgfile=<?php echo $row_productRS['Image4']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 4" border="0" class="l4imgfix" />
            <?php }?>
            </a>
    
        </div>
    
        <?php }?>
    
        <?php if($row_productRS['Image5'] != 0 || $row_productRS['Image5'] != ""){?>
    
        <div id="photo_5" class="photo_inactive">
    
            <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/<?php echo $row_productRS['Image5']; ?>" onclick="open_lightbox('5', '<?php echo $i; ?>'); return false;">
            <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/thumb_<?php echo get_option('l4_option_large_width'); ?>_<?php echo get_option('l4_option_large_height'); ?>_<?php echo $row_productRS['Image5']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 5" border="0" class="l4imgfix" />
            <?php }else{?>
            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/images.php?max_width=<?php echo get_option('l4_option_large_width'); ?>&max_height=<?php echo get_option('l4_option_large_height'); ?>&imgfile=<?php echo $row_productRS['Image5']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Image 5" border="0" class="l4imgfix" />
            <?php }?>
            </a>
    
        </div>
    
        <?php }?>
    
        <?php
    
            if($row_productRS['Image5'] != 0 || $row_productRS['Image5'] != ""){
    
                $totalimgs = 5;
    
            }else if($row_productRS['Image4'] != 0 || $row_productRS['Image4'] != ""){
    
                $totalimgs = 4;
    
            }else if($row_productRS['Image3'] != 0 || $row_productRS['Image3'] != ""){
    
                $totalimgs = 3;
    
            }else if($row_productRS['Image2'] != 0 || $row_productRS['Image2'] != ""){
    
                $totalimgs = 2;
    
            }else{
    
                $totalimgs = 1;
    
            }
    
        ?>
        <?php if($row_productRS['Image2'] != 0 || $row_productRS['Image2'] != "" || $row_productRS['Image3'] != 0 || $row_productRS['Image3'] != "" || $row_productRS['Image4'] != 0 || $row_productRS['Image4'] != "" || $row_productRS['Image5'] != 0 || $row_productRS['Image5'] != ""){ ?>
        <ul class="l4thumbs">
    
            <li>
    
                <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/<?php echo $row_productRS['Image1']; ?>" target="_blank" onclick="switch_product_img('photo_1', <?php echo $totalimgs; ?>); return false;">
    				
                    <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/thumb_<?php echo get_option('l4_option_xsmall_width'); ?>_<?php echo get_option('l4_option_xsmall_height'); ?>_<?php echo $row_productRS['Image1']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Thumb 1" class="product_details_image" />
                    <?php }else{?>
                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics1/images.php?max_width=<?php echo get_option('l4_option_xsmall_width'); ?>&max_height=<?php echo get_option('l4_option_xsmall_height'); ?>&imgfile=<?php echo $row_productRS['Image1']; ?>" alt="<?php echo $row_productRS['Title']; ?> - Thumb 1" class="product_details_image" />
                    <?php }?>
    
                </a>
    
            </li>
    
            <?php if($row_productRS['Image2'] != 0 || $row_productRS['Image2'] != ""){ ?>
    
            <li>
    
                <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/<?php echo $row_productRS['Image2']; ?>" target="_blank" onclick="switch_product_img('photo_2', '<?php echo $totalimgs; ?>'); return false;">
    				
                    <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/thumb_<?php echo get_option('l4_option_xsmall_width'); ?>_<?php echo get_option('l4_option_xsmall_height'); ?>_<?php echo $row_productRS['Image2']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 2" class="product_details_image" />
                    <?php }else{?>
                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics2/images.php?max_width=<?php echo get_option('l4_option_xsmall_width'); ?>&max_height=<?php echo get_option('l4_option_xsmall_height'); ?>&imgfile=<?php echo $row_productRS['Image2']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 2" class="product_details_image" />
                    <?php }?>
    
                </a>
    
            </li>
    
            <?php }?>
    
            <?php if($row_productRS['Image3'] != 0 || $row_productRS['Image3'] != ""){ ?>
    
            <li>
    
                <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/<?php echo $row_productRS['Image3']; ?>" target="_blank" onclick="switch_product_img('photo_3', '<?php echo $totalimgs; ?>'); return false;">
    				
                    <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/thumb_<?php echo get_option('l4_option_xsmall_width'); ?>_<?php echo get_option('l4_option_xsmall_height'); ?>_<?php echo $row_productRS['Image3']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 3" class="product_details_image" />
                    <?php }else{?>
                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics3/images.php?max_width=<?php echo get_option('l4_option_xsmall_width'); ?>&max_height=<?php echo get_option('l4_option_xsmall_height'); ?>&imgfile=<?php echo $row_productRS['Image3']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 3" class="product_details_image" />
                    <?php }?>
    
                </a>
    
            </li>
    
            <?php }?>
    
            <?php if($row_productRS['Image4'] != 0 || $row_productRS['Image4'] != ""){ ?>
    
            <li>
    
                <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/<?php echo $row_productRS['Image4']; ?>" target="_blank" onclick="switch_product_img('photo_4', '<?php echo $totalimgs; ?>'); return false;">
    
    				<?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/thumb_<?php echo get_option('l4_option_xsmall_width'); ?>_<?php echo get_option('l4_option_xsmall_height'); ?>_<?php echo $row_productRS['Image4']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 4" class="product_details_image" />
                    <?php }else{?>
                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics4/images.php?max_width=<?php echo get_option('l4_option_xsmall_width'); ?>&max_height=<?php echo get_option('l4_option_xsmall_height'); ?>&imgfile=<?php echo $row_productRS['Image4']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 4" class="product_details_image" />
                    <?php }?>
    
                </a>
    
            </li>
    
            <?php }?>
    
            <?php if($row_productRS['Image5'] != 0 || $row_productRS['Image5'] != ""){ ?>
    
            <li>
    
                <a href="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/<?php echo $row_productRS['Image5']; ?>" target="_blank" onclick="switch_product_img('photo_5', '<?php echo $totalimgs; ?>'); return false;">
    				
                    <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/thumb_<?php echo get_option('l4_option_xsmall_width'); ?>_<?php echo get_option('l4_option_xsmall_height'); ?>_<?php echo $row_productRS['Image5']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 5" class="product_details_image" />
                    <?php }else{?>
                    <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/pics5/images.php?max_width=<?php echo get_option('l4_option_xsmall_width'); ?>&max_height=<?php echo get_option('l4_option_xsmall_height'); ?>&imgfile=<?php echo $row_productRS['Image5']; ?>"  alt="<?php echo $row_productRS['Title']; ?> - Thumb 5" class="product_details_image" />
                    <?php }?>
    
                </a>
    
            </li>
    
            <?php }?>
    
        </ul> <?php } //close if more than one thumbnail statement ?>
    
    </div>
    
<?php }?>