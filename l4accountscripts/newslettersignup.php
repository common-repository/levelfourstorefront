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

$sql = sprintf("INSERT IGNORE INTO subscribers (email, firstname, lastname) VALUES('%s', '%s', '%s')", mysql_real_escape_string($_POST['EmailAddress']), mysql_real_escape_string($_POST['FirstNameText']), mysql_real_escape_string($_POST['LastNameText']));

mysql_query($sql);

$storepage = $_POST['storeurl'];
if(substr_count($_POST['storeurl'], '?')){
	$permalinkdivider = "&amp;";
}else{
	$permalinkdivider = "?";
}

header("location:".$storepage.$permalinkdivider."Message=Successfully%20Added%20to%20Newsletter%20List");

?>