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

$sql = sprintf("DELETE FROM tempcart WHERE sessionid = '%s' AND tempcartid = '%s'", mysql_real_escape_string(session_id()), mysql_real_escape_string($_POST['tempcartid']));

$result = mysql_query($sql);

if(isset($_POST['confirmorder']) && $_POST['confirmorder'] == "true"){
	header("location:".$cartpage.$permalinkdivider."confirmorder=true");
}else{
	header("location:".$cartpage);
}
?>