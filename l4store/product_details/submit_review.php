<?php
$sql = sprintf("INSERT INTO reviews(productID, reviewapproved, rating, reviewtitle, reviewdescription, datesubmitted) VALUES('%s', '%s', '%s', '%s', '%s', '%s')", 
					mysql_real_escape_string($_POST['productid']),
					mysql_real_escape_string("0"),
					mysql_real_escape_string($_POST['review']),
					mysql_real_escape_string($_POST['review_title']),
					mysql_real_escape_string($_POST['review_description']),
					date("Y-m-d H:i:s"));
					
$result = mysql_query($sql);

header("location:" . $storepage . $permalinkdivider . "ModelNumber=" . $_POST['ModelNumber'] . "&catid=" . $_POST['catid'] . "&message=Review Submitted Successfully!");

?>