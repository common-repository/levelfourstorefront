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



//////////////////////////////////////////////

//if we have a ModelNumber, fetch that product

//////////////////////////////////////////////

if($_GET['ModelNumber']){

	$proddetailssql = sprintf("SELECT ModelNumber FROM products WHERE ModelNumber = '%s'", mysql_real_escape_string($_GET['ModelNumber']));

	$proddetailsresult = mysql_query($proddetailssql);

	$proddetailsnumrows = mysql_num_rows($proddetailsresult);

}else{

	$proddetailsnumrows = 0;

}

//////////////////////////////////////////////

//if we found a model number, fetch it again?

//then get all reviews, options for the product

//////////////////////////////////////////////

if($proddetailsnumrows > 0){

	//////////////////////////////////////////////

	//query for the product

	//////////////////////////////////////////////

	$query_companyRS = "SELECT * FROM company";

	$companyRS = mysql_query($query_companyRS);

	$row_companyRS = mysql_fetch_assoc($companyRS);

	

	//////////////////////////////////////////////

	//query for the product

	//////////////////////////////////////////////

	$query_productRS = sprintf("SELECT products.*, AVG(reviews.rating) AS review_avg, COUNT(reviews.rating) AS total_reviews FROM products LEFT OUTER JOIN reviews ON (reviews.productID = products.ProductID AND (reviews.reviewapproved = 1 OR reviews.reviewapproved IS NULL)) WHERE products.ModelNumber = '%s'", mysql_real_escape_string($_GET['ModelNumber']));

	$productRS = mysql_query($query_productRS);

	$row_productRS = mysql_fetch_assoc($productRS);

	$totalRows_productRS = mysql_num_rows($productRS);

	

	///Update product statistics

	$stats_is_inserted_sql = sprintf("SELECT * FROM statistics WHERE ProductID = '%s'", mysql_real_escape_string($row_productRS['ProductID']));

	$stats_is_inserted = mysql_query($stats_is_inserted_sql);

	$stats_is_inserted_num_rows = mysql_num_rows($stats_is_inserted);

	

	if($stats_is_inserted_num_rows > 0){

		$update_stats_sql = sprintf("UPDATE statistics SET views = views + 1, lastUpdated = '%s' WHERE ProductID = '%s'", date('Y-m-d H:i:s'), mysql_real_escape_string($row_productRS['ProductID']));

	}else{

		$update_stats_sql = sprintf("INSERT INTO statistics(ProductID, views, lastUpdated) VALUES('%s', '%s', '%s')", mysql_real_escape_string($row_productRS['ProductID']), "1", date('Y-m-d H:i:s'));

	}

	

	mysql_query($update_stats_sql);



	//////////////////////////////////////////////

	//query for the reviews

	//////////////////////////////////////////////

	$query_reviews = sprintf("SELECT * FROM reviews WHERE productID = '%s' AND reviews.reviewapproved = '1'", mysql_real_escape_string($row_productRS['ProductID']));

	$reviews = mysql_query($query_reviews);

	$reviews_numrows = mysql_num_rows($reviews);

	

	

	//////////////////////////////////////////////

	//query for the featured products

	//////////////////////////////////////////////

	if($row_productRS['featureproduct1'] != "0"){

		$query_featured1 = sprintf("SELECT reviews.reviewapproved,

							  AVG(reviews.rating) AS review_avg,

							  COUNT(reviews.reviewID) AS total_reviews, 
							  
							  products.*
							  
							  FROM products

							  LEFT JOIN reviews ON (reviews.productID = products.ProductID AND (reviews.reviewapproved = 1 OR reviews.reviewapproved IS NULL))

							  WHERE ModelNumber = '%s'", mysql_real_escape_string($row_productRS['featureproduct1']));

		$featured1 = mysql_query($query_featured1);

		$row_featured1 = mysql_fetch_assoc($featured1);

	}

	

	if($row_productRS['featureproduct2'] != "0"){

		$query_featured2 = sprintf("SELECT reviews.reviewapproved,

							  AVG(reviews.rating) AS review_avg,

							  COUNT(reviews.reviewID) AS total_reviews, 
							  
							  products.*
							  
							  FROM products

							  LEFT OUTER JOIN reviews ON (reviews.productID = products.ProductID AND (reviews.reviewapproved = 1 OR reviews.reviewapproved IS NULL))

							  WHERE ModelNumber = '%s'", mysql_real_escape_string($row_productRS['featureproduct2']));

		$featured2 = mysql_query($query_featured2);

		$row_featured2 = mysql_fetch_assoc($featured2);

	}

	

	if($row_productRS['featureproduct3'] != "0"){

		$query_featured3 = sprintf("SELECT reviews.reviewapproved,

							  AVG(reviews.rating) AS review_avg,

							  COUNT(reviews.reviewID) AS total_reviews, 
							  
							  products.*
							  
							  FROM products

							  LEFT OUTER JOIN reviews ON (reviews.productID = products.ProductID AND (reviews.reviewapproved = 1 OR reviews.reviewapproved IS NULL))

							  WHERE ModelNumber = '%s'", mysql_real_escape_string($row_productRS['featureproduct3']));

		$featured3 = mysql_query($query_featured3);

		$row_featured3 = mysql_fetch_assoc($featured3);

	}

	

	if($row_productRS['featureproduct4'] != "0"){

		$query_featured4 = sprintf("SELECT reviews.reviewapproved,

							  AVG(reviews.rating) AS review_avg,

							  COUNT(reviews.reviewID) AS total_reviews, 
							  
							  products.*
							  
							  FROM products

							  LEFT OUTER JOIN reviews ON (reviews.productID = products.ProductID AND (reviews.reviewapproved = 1 OR reviews.reviewapproved IS NULL))

							  WHERE ModelNumber = '%s'", mysql_real_escape_string($row_productRS['featureproduct4']));

		$featured4 = mysql_query($query_featured4);

		$row_featured4 = mysql_fetch_assoc($featured4);

	}

	

	

	

	//////////////////////////////////////////////

	//query for the options for the product

	//////////////////////////////////////////////

	$colname_option1RS = "-1";

	if (isset($row_productRS['option1'])) {

	  $colname_option1RS = $row_productRS['option1'];

	}

	

	$query_option1RS = sprintf("SELECT * FROM optionitems, options WHERE optionitems.optionparentID = %s AND options.optionID = %s ORDER BY optionorder ASC", mysql_real_escape_string($colname_option1RS), mysql_real_escape_string($colname_option1RS));

	$option1RS = mysql_query($query_option1RS);

	$row_option1RS = mysql_fetch_assoc($option1RS);

	$totalRows_option1RS = mysql_num_rows($option1RS);

	

	$colname_option2RS = "-1";

	if (isset($row_productRS['option2'])) {

	  $colname_option2RS = $row_productRS['option2'];

	}

	

	$query_option2RS = sprintf("SELECT * FROM optionitems, options WHERE optionitems.optionparentID = %s AND options.optionID = %s ORDER BY optionorder ASC", mysql_real_escape_string($colname_option2RS), mysql_real_escape_string($colname_option2RS));

	$option2RS = mysql_query($query_option2RS);

	$row_option2RS = mysql_fetch_assoc($option2RS);

	$totalRows_option2RS = mysql_num_rows($option2RS);

	

	$colname_option3RS = "-1";

	if (isset($row_productRS['option3'])) {

	  $colname_option3RS = $row_productRS['option3'];

	}

	

	$query_option3RS = sprintf("SELECT * FROM optionitems, options WHERE optionitems.optionparentID = %s AND options.optionID = %s ORDER BY optionorder ASC", mysql_real_escape_string($colname_option3RS), mysql_real_escape_string($colname_option3RS));

	$option3RS = mysql_query($query_option3RS);

	$row_option3RS = mysql_fetch_assoc($option3RS);

	$totalRows_option3RS = mysql_num_rows($option3RS);

	

	$colname_option4RS = "-1";

	if (isset($row_productRS['option4'])) {

	  $colname_option4RS = $row_productRS['option4'];

	}

	

	$query_option4RS = sprintf("SELECT * FROM optionitems, options WHERE optionitems.optionparentID = %s AND options.optionID = %s ORDER BY optionorder ASC", mysql_real_escape_string($colname_option4RS), mysql_real_escape_string($colname_option4RS));

	$option4RS = mysql_query($query_option4RS);

	$row_option4RS = mysql_fetch_assoc($option4RS);

	$totalRows_option4RS = mysql_num_rows($option4RS);

	

	$colname_option5RS = "-1";

	if (isset($row_productRS['option5'])) {

	  $colname_option5RS = $row_productRS['option5'];

	}

	

	$query_option5RS = sprintf("SELECT * FROM optionitems, options WHERE optionitems.optionparentID = %s AND options.optionID = %s ORDER BY optionorder ASC", mysql_real_escape_string($colname_option5RS), mysql_real_escape_string($colname_option5RS));

	$option5RS = mysql_query($query_option5RS);

	$row_option5RS = mysql_fetch_assoc($option5RS); 

	$totalRows_option5RS = mysql_num_rows($option5RS);

}



//Query for menu items





?>

<div id="product_details_results">

    <div class="product_details_holder">

		<div class="floatleft_prod_nav"><?php if( isset( $_GET['menu'] ) || isset( $_GET['submenu'] ) || isset( $_GET['subsubmenu'] ) ){ ?><?php if( isset( $_GET['menu'] ) ){?> <a href="<?php echo $storepage . $permalinkdivider; ?>menuid=<?php echo $_GET['menuid']; ?>&amp;menu=<?php echo unsanatizeCategory($_GET['menu']);?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } echo "&amp;perpage=" . $maxperpage;?>" class="breadcrumb"><?php echo $_GET['menu'];?> </a><?php } ?><?php if( isset( $_GET['menu'] ) && isset( $_GET['submenu'] ) ){ ?>><?php } ?><?php if( isset( $_GET['submenu'] ) ){?> <a href="<?php echo $storepage . $permalinkdivider; ?>submenuid=<?php echo $_GET['submenuid']; ?>&amp;submenu=<?php echo unsanatizeCategory($_GET['submenu']); ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } echo "&amp;perpage=" . $maxperpage; ?>" class="breadcrumb"><?php echo $_GET['submenu']; ?></a> <?php } ?><?php if( ( isset( $_GET['menu'] ) && isset( $_GET['subsubmenu'] ) ) || ( isset( $_GET['submenu'] ) && isset( $_GET['subsubmenu'] ) ) ){?>><?php }?><?php if( isset( $_GET['subsubmenu'] ) ){?> <a href="<?php echo $storepage . $permalinkdivider; ?>subsubmenuid=<?php echo $_GET['subsubmenuid']; ?>&amp;subsubmenu=<?php echo unsanatizeCategory($_GET['subsubmenu']); ?><?php if($manufacturerid != 0){ echo "&amp;manufacturer=".$manufacturerid; } if($pricepointid != 0){ echo "&amp;pricepoint=".$pricepointid; } echo "&amp;perpage=" . $maxperpage; ?>" class="breadcrumb"><?php echo $_GET['subsubmenu']; ?></a> <?php }?><?php }//close for there being any options?></div>
        
        <div class="floatright"><?php include("product_details/sharedicons.php"); ?></div>
        
        <div class="divider"></div>
        
        <div class="floatleft">

            <form name="addtocartform" id="addtocartform" action="<?php echo $cartpage; ?>" method="post">
            
                <div class="image_holder">
                
                <?php include("product_details/images.php"); ?>
                
                </div>
                
                <div class="option_price_holder" id="rightsideHolder">
    
                    <?php if($row_productRS['isGiftCard'] == 1){?>
    
                        <input type="hidden" name="isGiftCard" id="isGiftCard" value="1" />
    
                        <?php include("product_details/giftcard.php"); ?>
    
                    <?php }else{?>
    
                        <input type="hidden" name="isGiftCard" id="isGiftCard" value="0" />
    
                    <?php }?>
    
                    <?php include("product_details/options_pricing.php"); ?>
    
                </div>
    
            </form>
        
        </div>
		
		<div class="floatleft">
			<div class="l4store_header" style="margin-bottom:5px;">Description</div>
            <div class="l4store_contentbox">
            	<div><?php include("product_details/description.php"); ?></div>
            </div>
        </div>
            
		<?php if($row_productRS['usespecs']){?>
       	<div class="floatleft">
			<div class="l4store_header" style="margin-bottom:5px;">Specifications</div>
			<div class="l4store_contentbox">
				<div><?php include("product_details/specifications.php"); ?></div>
           	</div>
        </div>
        <?php }?>
            
		<?php if($row_productRS['allowreviews']){?>
        <div class="floatleft">
            <div class="l4store_header" style="margin-bottom:5px;">Customer Reviews</div>
			<div class="l4store_contentbox">
				<div><?php include("product_details/reviews.php"); ?></div>
           	</div>
        </div>
        <?php }?>
        
		<div id="product_review_container">

        <div id="product_review_outter"><div id="product_review">
			<form action="<?php echo $storepage . $permalinkdivider; ?>ModelNumber=<?php echo $_GET['ModelNumber']; ?>&catid=<?php echo $_GET['catid']; ?>" method="post">
            <div>

                <div class="review_width floatleft">

                	<div class="review_title">Customer Review</div><div class="review_text">Thank you for choosing to leave feedback. Please fill out this form in order to post feedback to our site. Customer feedback is important to us and it also improves buyer knowledge and overall happiness.</div><br />
			
					<div class="review_title">Rate This Product (1: poor - 5: great):</div> <div id="star_<?php echo $row_productRS['ProductID']; ?>_review\" data-rating="3">
				  	<input type="radio" name="review" id="review_1" value="1" class="review_radio" /> 1 
				  	<input type="radio" name="review" id="review_2" value="2" class="review_radio" /> 2 
				  	<input type="radio" name="review" id="review_3" value="3" class="review_radio" /> 3 
				  	<input type="radio" name="review" id="review_4" value="4" class="review_radio" /> 4 
				  	<input type="radio" name="review" id="review_5" value="5" class="review_radio" /> 5
                	</div>

              	</div>

                <div class="closebutton"><a href="#" onclick="hidereview(); return false;"><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/close_button.png" alt="Close" /></a></div>

                <div class="review_width floatleft">

                	<div class="review_title">Title of Review:</div>

                    <input type="text" id="review_title" name="review_title" class="review_width" /><br />

                    <div class="review_title">Your Comments (optional):</div>

                    <textarea id="review_description" name="review_description" class="review_width review_height"></textarea><br />
					
                    <input type="hidden" name="l4_action" value="submitreview" />
                    
                    <input type="hidden" name="l4_form_hash" value="<?php echo md5(microtime()); ?>" />
                    
                    <input type="hidden" name="productid" value="<?php echo $row_productRS['ProductID']; ?>" />
                    
                    <input type="hidden" name="ModelNumber" value="<?php echo $_GET['ModelNumber']; ?>" />
                    
                    <input type="hidden" name="catid" value="<?php echo $_GET['catid']; ?>" />
                    
                    <input type="submit" value="Submit Review" class="l4store_button" />

                </div>
				</form>
            </div></div>

        </div>

        </div>

		<?php include("product_details/featured_products.php"); ?>

	</div>

</div>