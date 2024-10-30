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



require_once('Connections/flashdb.php'); 

require_once("scripts/l4html/l4store_functions.php"); 


//set our connection variables

$dbhost = HOSTNAME;

$dbname = DATABASE;

$dbuser = USERNAME;

$dbpass = PASSWORD;	

//make a connection to our database

$conn = mysql_pconnect($dbhost, $dbuser, $dbpass);

mysql_select_db ($dbname);


//query the database for our settings
	
$query_settingsRS = "SELECT * FROM settings WHERE settingID = 1";

$settingsRS = mysql_query($query_settingsRS);

$row_settingsRS = mysql_fetch_assoc($settingsRS);


$storepageid = $row_settingsRS['storepage'];
$cartpageid = $row_settingsRS['cartpage'];
$accountpageid = $row_settingsRS['accountpage'];

$storepage = get_permalink( $storepageid );
$cartpage = get_permalink( $cartpageid );
$accountpage = get_permalink( $accountpageid );

if(substr_count($storepage, '?')){
	$permalinkdivider = "&amp;";
}else{
	$permalinkdivider = "?";
}

?>

<style>

#L4navigation-holder {
 margin: 0;
 padding: 0 1em 0 0;
 background: <?php echo $bgcolor1; ?>;
 height: 3em;
 list-style: none;
 z-index:1001;
 position:relative;
}

#L4navigation-holder > li {
 float: left;
 height: 100%;
 padding: 0 1em;
 border:0;
}

#L4navigation-holder > li:hover{
 background: <?php echo $bgrollovercolor1; ?>;
}

#L4navigation-holder > li > a {
 float: left;
 height: 100%;
 color: <?php echo $fontcolor1; ?>;
 text-decoration: none;
 line-height: 3em;
 font-weight:bold;
 text-transform: uppercase;
}

#L4navigation-holder > li > a:hover {
 color: <?php echo $fontrollovercolor1; ?>;
 text-decoration: none;
}

#L4navigation-holder > li.L4sub {
 position: relative;
}

#L4navigation-holder > li.L4sub ul {
 width: 10em;
 margin: 0;
 list-style: none;
 background: <?php echo $bgcolor2; ?>;
 position: absolute;
 top: -1000em;
}

#L4navigation-holder > li.L4sub ul li {
 padding:0;
 width: 100%;
 margin: 0;
 border:0;
}

#L4navigation-holder > li.L4sub ul li:hover {
 background: <?php echo $bgrollovercolor2; ?>;
}

#L4navigation-holder > li.L4sub ul li a {
 height: 100%;
 display: block;
 padding: 0.4em;
 color: <?php echo $fontcolor2; ?>;
 font-weight: bold;
 text-decoration: none;
}

#L4navigation-holder > li.L4sub ul li a:hover {
 text-decoration: none;
 color: <?php echo $fontrollovercolor2; ?>;
}

#L4navigation-holder > li.L4sub:hover ul {
 top: 2.5em;
 left:0em;
 width:100%;
}



/*SUBSUB*/

#L4navigation-holder > li ul li.L4subsub {
 position: relative;
}

#L4navigation-holder > li ul li.L4subsub ul {
 width: 10em;
 margin: 7px 0 0 0;
 list-style: none;
 background: <?php echo $bgcolor3; ?>;
 position: absolute;
 display:none;
}

#L4navigation-holder > li ul li.L4subsub ul li {
 width: 100%;
 margin: 0;
 border:0;
 padding:0;
}

#L4navigation-holder > li ul li.L4subsub ul li:hover {
 background: <?php echo $bgrollovercolor3; ?>;
}

#L4navigation-holder > li ul li.L4subsub ul li a {
 height: 100%;
 display: block;
 padding: 0.4em;
 color: <?php echo $fontcolor3; ?>;
 font-weight: bold;
 text-decoration: none;
}

#L4navigation-holder > li ul li.L4subsub ul li a:hover {
 color: <?php echo $fontrollovercolor3; ?>;
 text-decoration: none;
}

#L4navigation-holder > li ul li.L4subsub:hover ul {
 left: 9em;
 margin-left:10px;
 top: -.5em;
 display:block;
}

</style>

<?php



//start building the strucutre for the menu

$xml_output = "<div><div class=\"store-menu-top\">";

$xml_output .= "<ul id=\"L4navigation-holder\">"; 

$query1 = mysql_query("SELECT * FROM menulevel1 ORDER BY menu1order ASC"); 

for($x = 0 ; $x < mysql_num_rows($query1) ; $x++){ 

	$row = mysql_fetch_assoc($query1);

	$query2 = mysql_query("SELECT * FROM menulevel2 ORDER BY menu2order ASC"); 

	$match1 = false;

	for($y = 0 ; $y < mysql_num_rows($query2) ; $y++){ 		

	$checksubs = mysql_fetch_assoc($query2); 

	//do this if there are submenus

	if($checksubs['menuParentID'] == $row['keyfield']){

		$xml_output .= "<li class='L4sub'><a href=\"" . $storepage . $permalinkdivider . "menuid=".$row['keyfield']."&amp;menu=".sanatizeCategory($row['menuName'])."\" id=\"menu_".$row['keyfield']."\" >".$row['menuName']."</a><ul>";		

				  

		/////////////////////////////////////////////////////

		//This is the subroutine for the submenus of each item

		//////////////////////////////////////////////////////

		$query3 = mysql_query("SELECT * FROM menulevel2 WHERE menuParentID = '".mysql_real_escape_string($checksubs['menuParentID'])."' ORDER BY menu2order ASC");

		for($z = 0 ; $z < mysql_num_rows($query3) ; $z++){

			$row2 = mysql_fetch_assoc($query3);

			$query4 = mysql_query("SELECT * FROM menulevel3 ORDER BY menu3order ASC");

			$match2 = false;

			for($t = 0 ; $t < mysql_num_rows($query4) ; $t++){

				$checksubsubs = mysql_fetch_assoc($query4);

				//do this if there are subsubmenus

				if($checksubsubs['menuParentID'] == $row2['keyfield']){

					$xml_output .= "<li class='L4subsub'";

					$xml_output .= "><a href='" . $storepage . $permalinkdivider . "submenuid=".$row2['keyfield']."&amp;menu=".sanatizeCategory($row['menuName'])."&amp;submenu=".sanatizeCategory($row2['menuName'])."' id='menu_".$row2['keyfield']."' >" . $row2['menuName'] . "</a><ul>";

					/////////////////////////////////////////////////////

					//This is the sub-sub routine for the sub sub menus of each item

					//////////////////////////////////////////////////////

					$query5 = mysql_query("SELECT * FROM menulevel3 WHERE menuParentID = '".mysql_real_escape_string($checksubsubs['menuParentID'])."' ORDER BY menu3order ASC");

					for($u = 0 ; $u < mysql_num_rows($query5) ; $u++){

						$row3 = mysql_fetch_assoc($query5);

						$query6 = mysql_query("SELECT * FROM menulevel3 ORDER BY menu3order ASC");

						$match3 = false;

						//do this if there are sub-sub menus

						if($checksubsubs['menuParentID'] == $row3['keyfield']){

							$xml_output .= "<li";

							$xml_output .= "><a href='" . $storepage . $permalinkdivider . "subsubmenuid=".$row3['keyfield']."&amp;menu=".sanatizeCategory($row['menuName'])."&amp;submenu=".sanatizeCategory($row2['menuName'])."&amp;subsubmenu=".sanatizeCategory($row3['menuName'])."' id='menu_".$row3['keyfield']."' >" . $row3['menuName'] . "</a><ul>";	

							

							$match3 = true;

							break;

						}

						//do this if there was no matcc in the sub-sub menu section

						if ($match3 == false){

							$xml_output .= "<li";

							$xml_output .= "><a href='" . $storepage . $permalinkdivider . "subsubmenuid=".$row3['keyfield']."&amp;menu=".sanatizeCategory($row['menuName'])."&amp;submenu=".sanatizeCategory($row2['menuName'])."&amp;subsubmenu=".sanatizeCategory($row3['menuName'])."' id='menu_".$row3['keyfield']."' >" . $row3['menuName'] . "</a></li>";

						}

					}

					////////////////////////////////////////////////////////	

					//this ends the subroutine for the submenus of each item

					////////////////////////////////////////////////////////	

					$xml_output .= "</ul></li>";	

					$match2 = true;

					break;

				}

			}							//do this if there was no matcc in the subsubmenu section

			if ($match2 == false){  

				$xml_output .= "<li class='L4subsub'";

					
					$xml_output .= "><a href='" . $storepage . $permalinkdivider . "submenuid=".$row2['keyfield']."&amp;menu=".sanatizeCategory($row['menuName'])."&amp;submenu=".sanatizeCategory($row2['menuName'])."' id='menu_".$row2['keyfield']."' >" . $row2['menuName'] . "</a></li>";

			}

		}

		////////////////////////////////////////////////////////	

		//this ends the subroutine for the submenus of each item

		////////////////////////////////////////////////////////		

		$xml_output .= "</ul></li>";	

		$match1 = true;

		break;

	}

	}

	//do this if there was no matcc in the submenu section

	if ($match1 == false){

	  $xml_output .= "<li><a href=\"" . $storepage . $permalinkdivider . "menuid=".$row['keyfield']."&amp;menu=".sanatizeCategory($row['menuName'])."\" id=\"menu_".$row['keyfield']."\" >".$row['menuName']."</a></li>";		

	}				

} 

$xml_output .= "</ul></div></div>"; 

echo $xml_output; 

?>