<?php 

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//All Code and Design is copyrighted by Level Four Storefront, LLC

//Level Four Storefront, LLC provides this code "as is" without     

//warranty of any kind, either express or implied,       

//including but not limited to the implied warranties    

//of merchantability and/or fitness for a particular     

//purpose.         

//

//Only licnesed users may use this code and storfront for live purposes.

//All other use is prohibited and may be subject to copyright violation laws.

//If you have any questions regarding proper use of this code, please

//contact Level Four Storefront, LLC prior to use.

//

//All use of this storefront is subject to our terms of agreement found on

// Level Four Storefront, LLC's official website.

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//Version 8.1.0 -  2011

require_once('../../Connections/flashdb.php'); 


$sqlquery = sprintf("select * from clients order by email asc");

mysql_select_db($database_flashdb, $flashdb);

$result = mysql_query($sqlquery, $flashdb) or die(mysql_error());

$count = mysql_num_fields($result);


$requestID = "-1";

if (isset($_GET['reqID'])) {

  $requestID = $_GET['reqID'];

}


$usersqlquery = sprintf("select * from clients WHERE clients.Password = '%s' AND clients.UserLevel = 'admin' ORDER BY Email ASC", mysql_real_escape_string($requestID));

mysql_select_db($database_flashdb, $flashdb);

$userresult = mysql_query($usersqlquery, $flashdb) or die(mysql_error());

$users = mysql_fetch_assoc($userresult);



if ($users) {

	//create 2 variables for use later on

	$header = "";

	$data = "";

	//now loop through and get database field names

	for ($i = 0; $i < $count; $i++){

		$header .= mysql_field_name($result, $i)."\t";

	}

	while($row = mysql_fetch_row($result)){

		$line = '';

		foreach($row as $value){

			if(!isset($value) || $value == ""){

				$value = "\t";

			}else{

				# important to escape any quotes to preserve them in the data.

				$value = str_replace('"', '""', $value);

				# needed to encapsulate data in quotes because some data might be multi line.

				# the good news is that numbers remain numbers in Excel even though quoted.

				$value = '"' . utf8_decode($value) . '"' . "\t";

			}

			$line .= $value;

		}

		$data .= trim($line)."\n";

	}

	# this line is needed because returns embedded in the data have "\r"

	# and this looks like a "box character" in Excel

	$data = str_replace("\r", "", $data);

	
	# Nice to let someone know that the search came up empty.

	# Otherwise only the column name headers will be output to Excel.

	if ($data == "") {

	$data = "\nno matching records found\n";

	}

	# This line will stream the file to the user rather than spray it across the screen

	//header("Content-Type: application/vnd.ms-excel; name='excel'");

	header("Content-type: application/vnd.ms-excel");

	header("Content-Transfer-Encoding: binary"); 

	header("Content-Disposition: attachment; filename=accounts.xls");

	header("Pragma: no-cache");

	header("Expires: 0");

	echo $header."\n".$data; 

} else {

	echo "Not Authorized...";

}

?>