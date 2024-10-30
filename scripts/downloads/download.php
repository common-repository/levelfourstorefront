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

require_once('../../Connections/flashdb.php');

if (!function_exists("GetSQLValueString")) {

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 

{

  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;



  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);



  switch ($theType) {

		case "text":
	
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	
		  break;    
	
		case "long":
	
		case "int":
	
		  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
	
		  break;
	
		case "double":
	
		  $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
	
		  break;
	
		case "date":
	
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	
		  break;
	
		case "defined":
	
		  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
	
		  break;
	
	  }
	
	  return $theValue;
	
	}

}


mysql_select_db($database_flashdb, $flashdb);

$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";

$settingsRS = mysql_query($query_settingsRS, $flashdb) or die(mysql_error());

$row_settingsRS = mysql_fetch_assoc($settingsRS);

$totalRows_settingsRS = mysql_num_rows($settingsRS);

/////////////////////////////////////////////////////////////////////////

//set max time and download limits

//////////////////////////////////////////////////////////////////////////

$maxdownloads = $row_settingsRS['maxdownloads'];

$maxtime = $row_settingsRS['maxdownloadtime'];

	if(get_magic_quotes_gpc()) {

        $id = stripslashes($_GET['downloadkey']);

	}else{

		$id = $_GET['downloadkey'];

	}



	$downloadid = "empty";

	

	// Get the key, timestamp, and number of downloads from the database

	$query = sprintf("SELECT * FROM downloadkey WHERE uniqueid= '%s'",

	mysql_real_escape_string($id));

	$result = mysql_query($query) or die(mysql_error());

	$row = mysql_fetch_array($result);

	if (!$row) { 

		echo "The download key you are using is invalid.";

	}else{

		$timecheck = date('U') - $row['timestamp'];

		if ($timecheck >= $maxtime && $maxtime != 0) {

			echo "<br><div align='center'><strong>The download key has expired!</strong><br><br>You have exceeded the length of time that you have to access and download this product.<br />If you feel you have received this in error, please contact us via our website.<br>Thank You.</div>";

		}else{

			$downloads = $row['downloads'];

			$downloadid = $row['productid'];

			$downloads += 1;

			if ($downloads > $maxdownloads && $maxdownloads != 0) {

				echo "<br><div align='center'><strong>The download key has expired!</strong><br><br>You have exceeded your download limit set for this product.<br />If you feel you have received this in error, please contact us via our website.<br>Thank You.</div>";

			}else{

				$sql = sprintf("UPDATE downloadkey SET downloads = '".$downloads."' WHERE uniqueid= '%s'",
	
				mysql_real_escape_string($id));
	
				$incrementdownloads = mysql_query($sql) or die(mysql_error());

				ob_start();
				
				$mm_type="application/octet-stream";
				
				$file = "../../products/downloads/" . $downloadid;
				
				$ext = substr($downloadid, strrpos($downloadid, '.') + 1);
				
				$filename = "My Download.".$ext;
				
				header("Cache-Control: public, must-revalidate");
				
				header("Pragma: no-cache");
				
				header("Content-Type: " . $mm_type);
				
				header("Content-Length: " .(string)(filesize($file)) );
				
				header('Content-Disposition: attachment; filename="'.$filename.'"');
				
				header("Content-Transfer-Encoding: binary\n");

				ob_end_clean();
				
				readfile($file);

			}

		}

	}

?>