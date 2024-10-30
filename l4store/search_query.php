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

$orderquery = "products.Title ASC";

$search_entry = mysql_real_escape_string($_GET['s']);

$search_query = " AND (products.Title LIKE '%" . $search_entry . "%' OR products.Description LIKE '%" . $search_entry . "%' OR products.ModelNumber LIKE '%" . $search_entry . "%') ";

$query_all = "SELECT 

		  		reviews.reviewapproved,

				  AVG(reviews.rating) AS review_avg,
		
				  COUNT(reviews.reviewID) AS review_count,
		
				  products.*,
		
				  statistics.views
		
				FROM
		
				  products
		
				  LEFT OUTER JOIN reviews ON (reviews.productID = products.ProductID AND (reviews.reviewapproved = 1 OR reviews.reviewapproved IS NULL))
		
				  LEFT OUTER JOIN statistics ON (statistics.ProductID = products.ProductID)
		
				WHERE
		
				  products.InStock = 1 " . $search_query . "
		
				GROUP BY
		
				  products.ProductID
		
				ORDER BY " . $orderquery;

$result = mysql_query($query_all);

?>