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

<script>

<?php

/*****************************

This section is to create an n deep array for managing option items.

It is created as a Javascript array for use in live validation.

*****************************/

if(mysql_num_rows($option1RS) > 0){

	$optionlevel1_sql = sprintf("SELECT optionitems.* FROM optionitems, options WHERE options.optionID = %s AND optionitems.optionparentID = options.optionID ORDER BY optionorder ASC", mysql_real_escape_string($row_option1RS['optionparentID']));

	$optionlevel1_result = mysql_query($optionlevel1_sql);

	$optionlevel1_total = mysql_num_rows($optionlevel1_result);
	
	//Echo out start of entire array

	echo "var myoptionitems = new Array(".$optionlevel1_total.");\n";

	//Go through each level 1 option

	$a=1;

	while($optionlevel1 = mysql_fetch_assoc($optionlevel1_result)){

		echo "myoptionitems[".($a-1)."] = new Array(2);\n";

		if($row_productRS['useQuantityTracking']){

			//Get the quantity for each item
	
			$optionlevel1quantity_sql = sprintf("SELECT SUM(optionitemquantity.Quantity) as Quantity FROM optionitemquantity WHERE optionitemquantity.OptionItemID1 = %s AND optionitemquantity.ProductID = %s", mysql_real_escape_string($optionlevel1['optionitemID']), mysql_real_escape_string($row_productRS['ProductID']));
	
			$optionlevel1quantity_result = mysql_query($optionlevel1quantity_sql);
	
			$optionlevel1quantity_row = mysql_fetch_assoc($optionlevel1quantity_result);
		}
		
		//Each item in top level is made up of a name and another array

		echo "myoptionitems[".($a-1)."][0] = new Array(5);\n";

		echo "myoptionitems[".($a-1)."][0][0] = '" . $optionlevel1['optionitemID'] . "';\n";

		echo "myoptionitems[".($a-1)."][0][1] = '" . $optionlevel1['optionitemname'] . "';\n";

		echo "myoptionitems[".($a-1)."][0][2] = '" . $optionlevel1['optionitemprice'] . "';\n";

		if($row_productRS['useQuantityTracking']){
		
		echo "myoptionitems[".($a-1)."][0][3] = " . $optionlevel1quantity_row['Quantity'] . ";\n";
		
		}else{
			
		echo "myoptionitems[".($a-1)."][0][3] = ".$row_productRS['quantity'].";\n";
			
		}

		echo "myoptionitems[".($a-1)."][0][4] = '" . $optionlevel1['optionitemicon'] . "';\n";

		

		//Drop to level 2

		if(mysql_num_rows($option2RS) > 0){
			
			$optionlevel2_sql = sprintf("SELECT optionitems.* FROM optionitems, options WHERE options.optionID = %s AND optionitems.optionparentID = options.optionID ORDER BY optionorder ASC", mysql_real_escape_string($row_option2RS['optionparentID']));

			$optionlevel2_result = mysql_query($optionlevel2_sql);

			$optionlevel2_total = mysql_num_rows($optionlevel2_result);
			
			//now create next array!

			echo "myoptionitems[".($a-1)."][1] = new Array(".$optionlevel2_total.");\n";

			//Now loop through level 2 items

			$b=1;

			while($optionlevel2 = mysql_fetch_assoc($optionlevel2_result)){

				echo "myoptionitems[".($a-1)."][1][".($b-1)."] = new Array(2);\n";

				if($row_productRS['useQuantityTracking']){

				//Get the quantity for each item

				$optionlevel2quantity_sql = sprintf("SELECT SUM(optionitemquantity.Quantity) as Quantity FROM optionitemquantity WHERE optionitemquantity.OptionItemID1 = %s AND optionitemquantity.OptionItemID2 = %s AND optionitemquantity.ProductID = %s", mysql_real_escape_string($optionlevel1['optionitemID']), mysql_real_escape_string($optionlevel2['optionitemID']), mysql_real_escape_string($row_productRS['ProductID']));

				$optionlevel2quantity_result = mysql_query($optionlevel2quantity_sql);

				$optionlevel2quantity_row = mysql_fetch_assoc($optionlevel2quantity_result);

				}

				//Each item in top level is made up of a name and another array

				echo "myoptionitems[".($a-1)."][1][".($b-1)."][0] = new Array(5);\n";

				echo "myoptionitems[".($a-1)."][1][".($b-1)."][0][0] = '" . $optionlevel2['optionitemID'] . "';\n";

				echo "myoptionitems[".($a-1)."][1][".($b-1)."][0][1] = '" . $optionlevel2['optionitemname'] . "';\n";

				echo "myoptionitems[".($a-1)."][1][".($b-1)."][0][2] = '" . $optionlevel2['optionitemprice'] . "';\n";

				if($row_productRS['useQuantityTracking']){

				echo "myoptionitems[".($a-1)."][1][".($b-1)."][0][3] = " . $optionlevel2quantity_row['Quantity'] . ";\n";

				}else{
				
				echo "myoptionitems[".($a-1)."][1][".($b-1)."][0][3] = ".$row_productRS['quantity'].";\n";	
					
				}
	
				echo "myoptionitems[".($a-1)."][1][".($b-1)."][0][4] = '" . $optionlevel2['optionitemicon'] . "';\n";
				
				//Drop to level 3

				if(mysql_num_rows($option3RS) > 0){

					$optionlevel3_sql = sprintf("SELECT optionitems.* FROM optionitems, options WHERE options.optionID = %s AND optionitems.optionparentID = options.optionID ORDER BY optionorder ASC", mysql_real_escape_string($row_option3RS['optionparentID']));

					$optionlevel3_result = mysql_query($optionlevel3_sql);

					$optionlevel3_total = mysql_num_rows($optionlevel3_result);

					

					//now create next array!

					echo "myoptionitems[".($a-1)."][1][".($b-1)."][1] = new Array(".$optionlevel3_total.");\n";

					//Now loop through level 3 items

					$c=1;

					while($optionlevel3 = mysql_fetch_assoc($optionlevel3_result)){

						echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."] = new Array(2);\n";

						if($row_productRS['useQuantityTracking']){

						//Get the quantity for each item

						$optionlevel3quantity_sql = sprintf("SELECT SUM(optionitemquantity.Quantity) as Quantity FROM optionitemquantity WHERE optionitemquantity.OptionItemID1 = %s AND optionitemquantity.OptionItemID2 = %s AND optionitemquantity.OptionItemID3 = %s AND optionitemquantity.ProductID = %s", mysql_real_escape_string($optionlevel1['optionitemID']), mysql_real_escape_string($optionlevel2['optionitemID']), mysql_real_escape_string($optionlevel3['optionitemID']), mysql_real_escape_string($row_productRS['ProductID']));

						$optionlevel3quantity_result = mysql_query($optionlevel3quantity_sql);

						$optionlevel3quantity_row = mysql_fetch_assoc($optionlevel3quantity_result);

						}

						//Each item in top level is made up of a name and another array

						echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][0] = new Array(5);\n";

						echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][0][0] = '" . $optionlevel3['optionitemID'] . "';\n";

						echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][0][1] = '" . $optionlevel3['optionitemname'] . "';\n";

						echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][0][2] = '" . $optionlevel3['optionitemprice'] . "';\n";
						
						if($row_productRS['useQuantityTracking']){
						
						echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][0][3] = '" . $optionlevel3quantity_row['Quantity'] . "';\n";
						
						}else{
						
						echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][0][3] = ".$row_productRS['quantity'].";\n";	
							
						}

						echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][0][4] = '" . $optionlevel3['optionitemicon'] . "';\n";
							
						//Drop to level 4

						if(mysql_num_rows($option4RS) > 0){

							$optionlevel4_sql = sprintf("SELECT optionitems.* FROM optionitems, options WHERE options.optionID = %s AND optionitems.optionparentID = options.optionID ORDER BY optionorder ASC", mysql_real_escape_string($row_option4RS['optionparentID']));

							$optionlevel4_result = mysql_query($optionlevel4_sql);

							$optionlevel4_total = mysql_num_rows($optionlevel4_result);							

							//now create next array!

							echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1] = new Array(".$optionlevel4_total.");\n";

							//Now loop through level 4 items

							$d=1;

							while($optionlevel4 = mysql_fetch_assoc($optionlevel4_result)){

								echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."] = new Array(2);\n";

								if($row_productRS['useQuantityTracking']){
								
								//Get the quantity for each item

								$optionlevel4quantity_sql = sprintf("SELECT SUM(optionitemquantity.Quantity) as Quantity FROM optionitemquantity WHERE optionitemquantity.OptionItemID1 = %s AND optionitemquantity.OptionItemID2 = %s AND optionitemquantity.OptionItemID3 = %s AND optionitemquantity.OptionItemID4 = %s AND optionitemquantity.ProductID = %s", mysql_real_escape_string($optionlevel1['optionitemID']), mysql_real_escape_string($optionlevel2['optionitemID']), mysql_real_escape_string($optionlevel3['optionitemID']), mysql_real_escape_string($optionlevel4['optionitemID']), mysql_real_escape_string($row_productRS['ProductID']));

								$optionlevel4quantity_result = mysql_query($optionlevel4quantity_sql);

								$optionlevel4quantity_row = mysql_fetch_assoc($optionlevel4quantity_result);

								}

								//Each item in top level is made up of a name and another array

								echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][0] = new Array(5);\n";

								echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][0][0] = '" . $optionlevel4['optionitemID'] . "';\n";

								echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][0][1] = '" . $optionlevel4['optionitemname'] . "';\n";

								echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][0][2] = '" . $optionlevel4['optionitemprice'] . "';\n";

								if($row_productRS['useQuantityTracking']){
								
								echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][0][3] = " . $optionlevel4quantity_row['Quantity'] . ";\n";
								
								}else{
									
								echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][0][3] = ".$row_productRS['quantity'].";\n";
									
								}

								echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][0][4] = '" . $optionlevel4['optionitemicon'] . "';\n";
																
								//Drop to level 5

								if(mysql_num_rows($option5RS) > 0){

									$optionlevel5_sql = sprintf("SELECT optionitems.* FROM optionitems, options WHERE options.optionID = %s AND optionitems.optionparentID = options.optionID ORDER BY optionorder ASC", mysql_real_escape_string($row_option5RS['optionparentID']));

									$optionlevel5_result = mysql_query($optionlevel5_sql);

									$optionlevel5_total = mysql_num_rows($optionlevel5_result);
								
									//now create next array!

									echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][1] = new Array(".$optionlevel5_total.");\n";

									//Now loop through level 5 items

									$e=1;

									while($optionlevel5 = mysql_fetch_assoc($optionlevel5_result)){

										echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][1][".($e-1)."] = new Array(1);\n";

										if($row_productRS['useQuantityTracking']){
										
										//Get the quantity for each item

										$optionlevel5quantity_sql = sprintf("SELECT SUM(optionitemquantity.Quantity) as Quantity FROM optionitemquantity WHERE optionitemquantity.OptionItemID1 = %s AND optionitemquantity.OptionItemID2 = %s AND optionitemquantity.OptionItemID3 = %s AND optionitemquantity.OptionItemID4 = %s AND optionitemquantity.OptionItemID5 = %s AND optionitemquantity.ProductID = %s", mysql_real_escape_string($optionlevel1['optionitemID']), mysql_real_escape_string($optionlevel2['optionitemID']), mysql_real_escape_string($optionlevel3['optionitemID']), mysql_real_escape_string($optionlevel4['optionitemID']), mysql_real_escape_string($optionlevel5['optionitemID']), mysql_real_escape_string($row_productRS['ProductID']));

										$optionlevel5quantity_result = mysql_query($optionlevel5quantity_sql);

										$optionlevel5quantity_row = mysql_fetch_assoc($optionlevel5quantity_result);

										}

										//Each item in top level is made up of a name and another array

										echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][1][".($e-1)."][0] = new Array(5);\n";

										echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][1][".($e-1)."][0][0] = '" . $optionlevel5['optionitemID'] . "';\n";

										echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][1][".($e-1)."][0][1] = '" . $optionlevel5['optionitemname'] . "';\n";

										echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][1][".($e-1)."][0][2] = '" . $optionlevel5['optionitemprice'] . "';\n";

										if($row_productRS['useQuantityTracking']){
										
										echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][1][".($e-1)."][0][3] = " . $optionlevel5quantity_row['Quantity'] . ";\n";
										
										}else{
											
										echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][1][".($e-1)."][0][3] = ".$row_productRS['quantity'].";\n";
											
										}

										echo "myoptionitems[".($a-1)."][1][".($b-1)."][1][".($c-1)."][1][".($d-1)."][1][".($e-1)."][0][4] = '" . $optionlevel5['optionitemicon'] . "';\n";
										
										$e++;

									}//Close while 5
									
								}//Close IF 5
								
								$d++;	

							}//Close While 4
	
						}//Close If 4
				
						$c++;

					}//Close While 3
					
				}//Close If 3
				
				$b++;
		
			}//Close while 2
			
		}//Close if 2
		
		$a++;
		
	}//close while 1
	
}//close if 1

?>
<?php /*
//Initiate current levels
var currentlevel1 = 0;
var currentlevel2 = 0;
var currentlevel3 = 0;
var currentlevel4 = 0;
var currentlevel5 = 0;
*/ ?>

</script>

<script>

var currentlevels = new Array(5);
currentlevels[0] = -1; 
currentlevels[1] = -1; 
currentlevels[2] = -1;
currentlevels[3] = -1;
currentlevels[4] = -1;

//Usage: When a swatch is clicked, update the screen to reflect the selected swatch.
function update_options_swatch(optnum, opti){
	
	if(has_quantity(optnum, opti)){
	
		//Set currently selected swatch to arrow css
		update_selected_swatch(optnum, currentlevels[optnum-1], opti);
		
		//Set the current level
		currentlevels[ optnum-1 ] = opti;
		
		//Clear future levels
		clear_future_levels( optnum );
		
		<?php if($row_productRS['useQuantityTracking']){ ?>
		//Load next combo/swatch
		if(is_swatch(optnum+1)){
			load_swatch(optnum+1);
		}else if(is_combo(optnum+1)){
			load_combo(optnum+1);
		}
		<?php } ?>
		
		update_quantity_text( optnum );
		
		<?php if($row_productRS['useoptionitemimages']){ ?>
		
		if(optnum == 1){
			
			update_image_display( );
			
		}
				
		<?php }?>
		
	}
	
}

//Usage: When a combo is changed, update the screen to reflect the selected combo item.
function update_options_combo( optnum ){
	
	//Set the current level
	currentlevels[optnum-1] = document.getElementById('option'+optnum+'dd').value;
	
	//Clear future levels
	clear_future_levels( optnum );
	
	update_quantity_text( optnum );
	
	update_combo_selected_id( optnum );
	
	<?php if($row_productRS['useQuantityTracking']){ ?>
	//Load next combo/swatch
	if(is_swatch(optnum+1)){
		load_swatch(optnum+1);
	}else if(is_combo(optnum+1)){
		load_combo(optnum+1);
	}
	<?php }?>
	
	<?php if($row_productRS['useoptionitemimages']){ ?>
	
	if(optnum == 1){
		
		update_image_display( );
		
	}
			
	<?php }?>
	
}

//Usage: Tests to make sure the clicked swatch has some quantity, and if it does continue, if not don't do anything!
function has_quantity(level, num){
	
	var hasquantity = false;

	if(level == 1){
		
		if(myoptionitems[num][0][3] > 0){
			
			hasquantity = true;
		
		}
		
	}else if(level == 2){
		
		if(myoptionitems[currentlevels[0]][1][num][0][3] > 0){
			
			hasquantity = true;
		
		}
		
	}else if(level == 3){
		
		if(myoptionitems[currentlevels[0]][1][currentlevels[1]][1][num][0][3] > 0){
			
			hasquantity = true;
		
		}
		
	}else if(level == 4){
		
		if(myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][num][0][3] > 0){
			
			hasquantity = true;
		
		}
		
	}else if(level == 5){
		
		if(myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1][num][0][3] > 0){
			
			hasquantity = true;
		
		}
		
	}
	
	return hasquantity;
	
}

//Usage: If a color is selected from previous screen, show that image, otherwise, find the first option item in the first 
//       option set that is in stock.
//Return: count value of the first available option item, e.g. Second swatch is 1.
function first_available(){
	
	<?php if(isset($_GET['catid'])){ ?>
	
	var numoptions = myoptionitems.length;
	
	var first_available = -1;
		
	for(var i=0; i<numoptions && first_available == -1; i++){
	
		if(	myoptionitems[i][0][0] == <?php echo $_GET['catid']; ?>){
	
			first_available = i;
	
		}
	
	}
	
	return first_available;
	
	<?php 
	//Use this if no option item in url
	}else{?>
	
	var numoptions = myoptionitems.length;
	
	var first_available = -1;
		
	for(var i=0; i<numoptions && first_available == -1; i++){
	
		if(	myoptionitems[i][0][3] > 0){
	
			first_available = i;
	
		}
	
	}
	
	return first_available;
	
	<?php }?>
}

//Usage: Update the option hidden field to reflect the selected option item ID.
function update_combo_selected_id( level ){
	
	var selected_id = 0;
	
	if(level == 1 && currentlevels[0] != -1){
		selected_id = myoptionitems[currentlevels[0]][0][0];
	}else if(level == 2 && currentlevels[1] != -1){
		selected_id = myoptionitems[currentlevels[0]][1][currentlevels[1]][0][0];
	}else if(level == 3 && currentlevels[2] != -1){
		selected_id = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][0][0];
	}else if(level == 4 && currentlevels[3] != -1){
		selected_id = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][0][0];
	}else if(level == 5 && currentlevels[4] != -1){
		selected_id = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1][currentlevels[4]][0][0];
	}
	
	document.getElementById('option' + level).value = selected_id;	

}

//Usage: Called when a swatch is clicked to update the display of the swatch, the selected label, and the hidden field option item ID.
function update_selected_swatch( level, past, current ){
	
	if(past != -1){
	
		document.getElementById('swatch' + level + '_' + past).className = "swatch_img_active";

	}
	
	document.getElementById('swatch' + level + '_' + current).className = "swatch_img_arrow";
	
	var selected_label = "";
	var selected_id = 0;
	
	if(level == 1){
		selected_label = myoptionitems[current][0][1];
		selected_id = myoptionitems[current][0][0];
	}else if(level == 2){
		selected_label = myoptionitems[currentlevels[0]][1][current][0][1];
		selected_id = myoptionitems[currentlevels[0]][1][current][0][0];
	}else if(level == 3){
		selected_label = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][current][0][1];
		selected_id = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][current][0][0];
	}else if(level == 4){
		selected_label = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][current][0][1];
		selected_id = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][current][0][0];
	}else if(level == 5){
		selected_label = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1][current][0][1];
		selected_id = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1][current][0][0];
	}
	
	document.getElementById('option' + level + 'label').innerHTML = selected_label;
	document.getElementById('option' + level).value = selected_id;
	
}

//Usage: When the image is to change based on the first option, call this to update the image to match the option item selected.
function update_image_display( ){
	
	var i = currentlevels[0];
	
	if( i == -1 ){
		
		i = first_available();
		
	}

	for(var j=0; j< myoptionitems.length; j++){
		
		if(j == i){
	
			document.getElementById('optionimages_'+j).style.display = "block";
		
		}else{
	
			document.getElementById('optionimages_'+j).style.display = "none";
		
		}
		
	}
			
}

//Usage: When an option is selected or changed, clear ALL options after the changed option.
function clear_future_levels( optnum ){
	
	var optavailable = true;
	
	for(var i=optnum; i<5; i++){
		
		if(optavailable){
			
			if(i==1 && !myoptionitems[0][1]){
				optavailable = false;
			}else if(i==2 && !myoptionitems[0][1][0][1]){
				optavailable = false;
			}else if(i==3 && !myoptionitems[0][1][0][1][0][1]){
				optavailable = false;
			}else if(i==4 && !myoptionitems[0][1][0][1][0][1][0][1]){
				optavailable = false;
			}else if(i==5 && !myoptionitems[0][1][0][1][0][1][0][1][0][1]){
				optavailable = false;
			}
			
			if(optavailable){
				
				currentlevels[optnum] = -1;
				
				//if is a swatch, clear swatch
				if(is_swatch(i+1)){
					<?php if($row_productRS['useQuantityTracking']){ ?>
					clear_swatch(i+1);
					<?php }?>
				//else if is a combo, clear combo
				}else if(is_combo(i+1)){
					<?php if($row_productRS['useQuantityTracking']){ ?>
					clear_combo(i+1);
					<?php }?>
				}//otherwise there is no option.
				
			}
			
		}
		
	}
}

//Usage: Checks to see if an option is a swatch selector
//Return: Returns true if the option is in fact a swatch.
function is_swatch( optnum ){
	
	if(optnum == 1 && myoptionitems[0][0][4].length > 0){
		
		return true;
	
	}else if(optnum == 2 && myoptionitems[0][1] && myoptionitems[0][1][0][0][4].length > 0){
	
		return true;
	
	}else if(optnum == 3 && myoptionitems[0][1][0][1] && myoptionitems[0][1][0][1][0][0][4].length > 0){
	
		return true;
	
	}else if(optnum == 4 && myoptionitems[0][1][0][1][0][1] && myoptionitems[0][1][0][1][0][1][0][0][4].length > 0){
	
		return true;
	
	}else if(optnum == 5 && myoptionitems[0][1][0][1][0][1][0][1] && myoptionitems[0][1][0][1][0][1][0][1][0][0][4].length > 0){
	
		return true;
	
	}else{
	
		return false;
	
	}

}

//Usage: Checks to see if an option is a combo
//Return: If it is a combo, then return true.
function is_combo( optnum ){
	
	if(document.getElementById('option'+optnum+'dd')){
		return true;
	}else{
		return false;
	}

}

//Usage: Set all swatches in the option of level to inactive (out of stock).
function clear_swatch( level ){
	
	if(level == 2){
	
		var numswatches = myoptionitems[0][1].length;
	
	}else if(level == 3){

		var numswatches = myoptionitems[0][1][0][1].length;

	}else if(level == 4){

		var numswatches = myoptionitems[0][1][0][1][0][1].length;

	}else if(level == 5){

		var numswatches = myoptionitems[0][1][0][1][0][1][0][1].length;

	}

	

	for(var i=0; i<numswatches; i++){

		document.getElementById('swatch'+level+'_'+i).className = "swatch_img_out_of_stock";

	}

}

//Usage: Set all combo items to hidden, also disable the combo.
function clear_combo( optnum ){
	
	document.getElementById('option'+optnum+'dd').disabled = "disabled";
	
	var numoptions = document.getElementById('option'+optnum+'dd').options.length;
	
	while(numoptions > 1){

		document.getElementById('option'+optnum+'dd').options[1] = null;
		
		numoptions = document.getElementById('option'+optnum+'dd').options.length;
	
	}
	
}

//Usage: Load the swatches to match the quantity values, either in or out of stock view.
function load_swatch( level ){
	
	if(level == 2){
			
		var numswatches = myoptionitems[currentlevels[0]][1].length;
		
		for(var i=0; i<numswatches; i++){
		
			if(	myoptionitems[currentlevels[0]][1][i][0][3] > 0){
		
				document.getElementById('swatch'+level+'_'+i).className = "swatch_img"
		
			}else{
		
				document.getElementById('swatch'+level+'_'+i).className = "swatch_img_out_of_stock"
		
			}
		
		}
		
		document.getElementById('option'+level+'label').innerHTML = "&nbsp;&nbsp;&nbsp;";
		
		document.getElementById('option'+level).value = 0;
		
	}else if(level == 3){
		
		var numswatches = myoptionitems[currentlevels[0]][1][currentlevels[1]][1].length;
		
		for(var i=0; i<numswatches; i++){
		
			if(	myoptionitems[currentlevels[0]][1][currentlevels[1]][1][i][0][3] > 0){
		
				document.getElementById('swatch'+level+'_'+i).className = "swatch_img"
		
			}else{
		
				document.getElementById('swatch'+level+'_'+i).className = "swatch_img_out_of_stock"
		
			}
		
		}
		
		document.getElementById('option'+level+'label').innerHTML = "&nbsp;&nbsp;&nbsp;";
		
		document.getElementById('option'+level).value = 0;
		
	}else if(level == 4){
		
		var numswatches = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1].length;
		
		for(var i=0; i<numswatches; i++){
		
			if(	myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][i][0][3] > 0){
		
				document.getElementById('swatch'+level+'_'+i).className = "swatch_img"
		
			}else{
		
				document.getElementById('swatch'+level+'_'+i).className = "swatch_img_out_of_stock"
		
			}
		
		}
		
		document.getElementById('option'+level+'label').innerHTML = "&nbsp;&nbsp;&nbsp;";
		
		document.getElementById('option'+level).value = 0;
		
	}else if(level == 5){
		
		var numswatches = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1].length;
		
		for(var i=0; i<numswatches; i++){
		
			if(	myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1][i][0][3] > 0){
		
				document.getElementById('swatch'+level+'_'+i).className = "swatch_img"
		
			}else{
		
				document.getElementById('swatch'+level+'_'+i).className = "swatch_img_out_of_stock"
		
			}
		
		}
		
		document.getElementById('option'+level+'label').innerHTML = "&nbsp;&nbsp;&nbsp;";
		
		document.getElementById('option'+level).value = 0;
	
	}
	
}

//Update the combo at level i to match stock quantities
function load_combo( i ){
	
	if(currentlevels[i-2] != -1){
		document.getElementById('option'+i+'dd').disabled = "";
	
		//We need to look at a different quantity value depending on which combo we just selected
		if(i==2){
			
			//Loop through all options for this option set
			for(var j=0; j<myoptionitems[currentlevels[0]][1].length; j++){
				
				//Add this item if it is in stock
				if(myoptionitems[currentlevels[0]][1][j][0][3] > 0){
					
					//Create the option to add
					var option = document.createElement("option");
					
					//Check for pricing adjustment
					if(myoptionitems[currentlevels[0]][1][j][0][2] != "0.00"){
						option.label = myoptionitems[currentlevels[0]][1][j][0][1] + " (" + myoptionitems[currentlevels[0]][1][j][0][2] + ")";
						option.text = myoptionitems[currentlevels[0]][1][j][0][1] + " (" + myoptionitems[currentlevels[0]][1][j][0][2] + ")";
					}else{
						option.label = myoptionitems[currentlevels[0]][1][j][0][1];
						option.text = myoptionitems[currentlevels[0]][1][j][0][1];
					}
					
					//add the value to the option
					option.value = j;
					
					//Add the option to the combo
					try{
				  		// for IE earlier than version 8
				  		document.getElementById('option'+i+'dd').add(option, document.getElementById('option'+i+'dd').options[null]);
				  	}catch (e){
						document.getElementById('option'+i+'dd').add(option, null);
				  	}//close try
					
				}//close quantity if
				
			}//close for
			
		}else if(i==3){
			
			//Loop through all options for this option set
			for(var j=0; j <= myoptionitems[currentlevels[0]][1][currentlevels[1]][1].length; j++){
				
				//Add this item if it is in stock
				if(myoptionitems[currentlevels[0]][1][currentlevels[1]][1][j][0][3] > 0){
					
					//Create the option to add
					var option=document.createElement("option");
					
					//Check for pricing adjustment
					if(myoptionitems[currentlevels[0]][1][currentlevels[1]][1][j][0][2] != "0.00"){
						option.label = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][j][0][1] + " (" + myoptionitems[currentlevels[0]][1][currentlevels[1]][1][j][0][2] + ")";
						option.text = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][j][0][1] + " (" + myoptionitems[currentlevels[0]][1][currentlevels[1]][1][j][0][2] + ")";
					}else{
						option.label = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][j][0][1];
						option.text = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][j][0][1];
					}
					
					//add the value to the option
					option.value = j;
					
					//Add the option to the combo
					try{
				  		// for IE earlier than version 8
				  		document.getElementById('option'+i+'dd').add(option, document.getElementById('option'+i+'dd').options[null]);
				  	}catch (e){
						document.getElementById('option'+i+'dd').add(option, null);
				  	}//close try
					
				}//close quantity if
				
			}//close for
			
		}else if(i==4){
			
			//Loop through all options for this option set
			for(var j=0; j <= myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1].length; j++){
				
				//Add this item if it is in stock
				if(myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][j][0][3] > 0){
					
					//Create the option to add
					var option=document.createElement("option");
					
					//Check for pricing adjustment
					if(myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][j][0][2] != "0.00"){
						option.label = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][j][0][1] + " (" + myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][j][0][2] + ")";
						option.text = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][j][0][1] + " (" + myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][j][0][2] + ")";
					}else{
						option.label = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][j][0][1];
						option.text = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][j][0][1];
					}
					
					//add the value to the option
					option.value = j;
					
					//Add the option to the combo
					try{
				  		// for IE earlier than version 8
				  		document.getElementById('option'+i+'dd').add(option, document.getElementById('option'+i+'dd').options[null]);
				  	}catch (e){
						document.getElementById('option'+i+'dd').add(option, null);
				  	}//close try
					
				}//close quantity if
				
			}//close for
			
		}else if(i==5){
			
			//Loop through all options for this option set
			for(var j=0; j <= myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1].length; j++){
				
				//Add this item if it is in stock
				if(myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1][j][0][3] > 0){
					
					//Create the option to add
					var option=document.createElement("option");
					
					//Check for pricing adjustment
					if(myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][j][0][2] != "0.00"){
						option.label = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1][j][0][1] + " (" + myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1][j][0][2] + ")";
						option.text = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1][j][0][1] + " (" + myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1][j][0][2] + ")";
					}else{
						option.label = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1][j][0][1];
						option.text = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1][j][0][1];
					}
					
					//add the value to the option
					option.value = j;
					
					//Add the option to the combo
					try{
				  		// for IE earlier than version 8
				  		document.getElementById('option'+i+'dd').add(option, document.getElementById('option'+i+'dd').options[null]);
				  	}catch (e){
						document.getElementById('option'+i+'dd').add(option, null);
				  	}//close try
					
				}//close quantity if
				
			}//close for
			
		}
	}
}

function update_quantity_text(level){
	
	document.getElementById('instock_quantity').innerHTML = "In Stock: " + getamountleft(level);

}

function getamountleft(level){
	
	var amountavailable = 0;

	if(level == 5){

		if(currentlevels[1] != -1){

			amountavailable = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][1][currentlevels[4]][0][3];

		}else{
		
			amountavailable = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][0][3];
			
		}

	}else if(level == 4){

		if(currentlevels[1] != -1){

			amountavailable = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][1][currentlevels[3]][0][3];

		}else{
		
			amountavailable = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][0][3];
			
		}

	}else if(level == 3){

		if(currentlevels[1] != -1){

			amountavailable = myoptionitems[currentlevels[0]][1][currentlevels[1]][1][currentlevels[2]][0][3];

		}else{
		
			amountavailable = myoptionitems[currentlevels[0]][1][currentlevels[1]][0][3];
			
		}

	}else if(level == 2){
		
		if(currentlevels[1] != -1){

			amountavailable = myoptionitems[currentlevels[0]][1][currentlevels[1]][0][3];

		}else{
		
			amountavailable = myoptionitems[currentlevels[0]][0][3];
			
		}

	}else if(level == 1){
		
		if(currentlevels[0] == -1){
			
			amountavailable = document.getElementById('totalquantity').value;
			
		}else{

			amountavailable = myoptionitems[currentlevels[0]][0][3];
		}
		
	}

	return amountavailable;

}

</script>

<style>
.l4photos ul.l4thumbs li{
	width: <?php echo get_option('l4_option_xsmall_width'); ?>px;	
	height: <?php echo get_option('l4_option_xsmall_height'); ?>px;	
}
</style>

<div class="bordertable_options">
	
    <div class="product_title"><?php echo $row_productRS['Title']; ?></div>
    
    <div class="divider"></div>

    <input type="hidden" value="<?php echo $row_settingsRS['currencySymbol']; ?>" id="CurrencySymbol">
    
    <?php if($row_productRS['isDonation']){?>

    <div class="floatleft">$<input type="text" value="<?php echo $row_productRS['Price']; ?>" id="Price" name="Price"></div>

    <?php }else{?>

    <input type="hidden" value="<?php echo $row_productRS['ListPrice']; ?>" id="ListPrice">

	<?php }?>
        
    <?php if(!$row_productRS['isDonation']){?>

		<?php if($row_productRS['ListPrice'] && $row_productRS['ListPrice'] != "0.00"){?>

        <div class="saleprice_text" id="currentprice"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo $row_productRS['Price']; ?> <span class="listprice_text"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo $row_productRS['ListPrice']; ?></span></div><?php }else{?>

        <div class="price_text" id="currentprice"><?php echo $row_settingsRS['currencySymbol']; ?><?php echo $row_productRS['Price']; ?></div>

        <?php }?>
        
        <?php if($row_productRS['ListPrice'] && $row_productRS['ListPrice'] != "0.00"){?><div class="sale_text">REDUCED PRICE <span class="savings_percentage">You Save <?php echo round(100 - 100*($row_productRS['Price']/$row_productRS['ListPrice'])); ?>%</span></div><?php }?>

    <?php }?>

    <?php if($row_productRS['allowreviews']){?>

    <div class="floatleft">

    <div class="prod_details_stars">

	<?php if($row_productRS['review_avg'] > .5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" /><?php }?>

    <?php if($row_productRS['review_avg'] > 1.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" /><?php }?>

    <?php if($row_productRS['review_avg'] > 2.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" /><?php }?>

    <?php if($row_productRS['review_avg'] > 3.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" /><?php }?>

    <?php if($row_productRS['review_avg'] > 4.5){?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-on.png" class="star_img" /><?php }else{?><img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/star-off.png" class="star_img" /><?php }?></div> <div class="total_reviews">(<?php echo $row_productRS['total_reviews']; ?>)</div></div>

    <?php }?>
    
    <div class="divider"></div>

    <div class="option_selection_error" id="option1error"><?php echo $row_option1RS['optionLabel']; ?></div>

    <div class="option_selection_error" id="option2error"><?php echo $row_option2RS['optionLabel']; ?></div>

    <div class="option_selection_error" id="option3error"><?php echo $row_option3RS['optionLabel']; ?></div>

    <div class="option_selection_error" id="option4error"><?php echo $row_option4RS['optionLabel']; ?></div>

    <div class="option_selection_error" id="option5error"><?php echo $row_option5RS['optionLabel']; ?></div>
   
	<?php 
	
	if(mysql_num_rows($option1RS) > 0){?>

		<?php $numoptionitems = mysql_num_rows($option1RS); 
		
		if ( $numoptionitems > 0 && $row_option1RS['optionitemicon']) { ?>
            
			<?php 
            
            if(isset($_GET['catid'])){ 

                $option1_sql = sprintf("SELECT * FROM optionitems, options WHERE options.optionID = %s AND optionitems.optionparentID = options.optionID AND optionitems.optionitemID = %s ORDER BY optionorder ASC", mysql_real_escape_string($row_option1RS['optionparentID']), mysql_real_escape_string($_GET['catid']));

                $option1_result = mysql_query($option1_sql);

                $option1_row = mysql_fetch_assoc($option1_result);

            }else{

                $option1_sql = sprintf("SELECT * FROM optionitems, options WHERE options.optionID = %s AND optionitems.optionparentID = options.optionID AND optionitems.optionitemID = %s ORDER BY optionorder ASC", mysql_real_escape_string($row_option1RS['optionparentID']), mysql_real_escape_string($row_option1RS['optionitemID']));

                $option1_result = mysql_query($option1_sql);

                $option1_row = mysql_fetch_assoc($option1_result);

            }
            
            ?>
         
            <div class="product_details_swatch_text_align" id="option1label"><?php echo $option1_row['optionitemname']; ?></div><input type="hidden" name="option1" id="option1" value="<?php echo $option1_row['optionitemID']; ?>"  />
            
            <div class="product_details_swatch_align">
            
            <?php $i=0; $usedActive=0;
            
            do { ?>
     			
                <?php 
								
					$optionitemquantity_sql = sprintf("SELECT SUM(optionitemquantity.Quantity) AS Quantity FROM optionitemquantity WHERE OptionItemID1 = '%s' AND ProductID = '%s'", $row_option1RS['optionitemID'], $row_productRS['ProductID']); 

					$optionitemquantity_result = mysql_query($optionitemquantity_sql);

					$optionitemquantity_row = mysql_fetch_assoc($optionitemquantity_result);

					$optionitemquantity = $optionitemquantity_row['Quantity'];

				?>
                
                <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/swatches/thumb_<?php echo get_option('l4_option_swatch_large_width'); ?>_<?php echo get_option('l4_option_swatch_large_height'); ?>_<?php echo $row_option1RS['optionitemicon']; ?>" alt="<?php echo $row_option1RS['optionitemname']; ?>" <?php if($row_productRS['useQuantityTracking']){ ?><?php if($optionitemquantity == 0){ echo " class=\"swatch_img_out_of_stock\""; }else if(isset($_GET['catid'])){ if($_GET['catid'] == $row_option1RS['optionitemID']){ echo " class=\"swatch_img_arrow\""; }else{ echo " class=\"swatch_img\""; } }else if($usedActive==0 && $optionitemquantity > 0){ $usedActive = 1; ?> class="swatch_img_arrow"<?php }else{ echo " class=\"swatch_img\""; } ?><?php if($optionitemquantity > 0){ ?> onclick="update_options_swatch(1, <?php echo $i; ?>)" <?php }?><?php }else{?> <?php if($_GET['catid'] == $row_option1RS['optionitemID']){ echo " class=\"swatch_img_arrow\""; ?><?php }else{?>class="swatch_img"<?php }?> onclick="update_options_swatch(1, <?php echo $i; ?>);"<?php }?> id="swatch1_<?php echo $i; ?>" />
                <?php }else{?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/swatches/images.php?max_width=<?php echo get_option('l4_option_swatch_large_width'); ?>&max_height=<?php echo get_option('l4_option_swatch_large_height'); ?>&imgfile=<?php echo $row_option1RS['optionitemicon']; ?>" alt="<?php echo $row_option1RS['optionitemname']; ?>" <?php if($row_productRS['useQuantityTracking']){ ?><?php if($optionitemquantity == 0){ echo " class=\"swatch_img_out_of_stock\""; }else if(isset($_GET['catid'])){ if($_GET['catid'] == $row_option1RS['optionitemID']){ echo " class=\"swatch_img_arrow\""; }else{ echo " class=\"swatch_img\""; } }else if($usedActive==0 && $optionitemquantity > 0){ $usedActive = 1; ?> class="swatch_img_arrow"<?php }else{ echo " class=\"swatch_img\""; } ?><?php if($optionitemquantity > 0){ ?> onclick="update_options_swatch(1, <?php echo $i; ?>)" <?php }?><?php }else{?> <?php if($_GET['catid'] == $row_option1RS['optionitemID']){ echo " class=\"swatch_img_arrow\""; ?><?php }else{?>class="swatch_img"<?php }?> onclick="update_options_swatch(1, <?php echo $i; ?>);"<?php }?> id="swatch1_<?php echo $i; ?>" />
                <?php }?>
     
            <?php $i++; 
            
            } while ($row_option1RS = mysql_fetch_assoc($option1RS)); 
			
			$rows1 = mysql_num_rows($option1RS);
	
			if($rows1 > 0) {

				mysql_data_seek($option1RS, 0);

				$row_option1RS = mysql_fetch_assoc($option1RS);

			}
		
			?>
            
            </div>
            
        <?php
			
		}else{ 
		
		$numoptionitems = mysql_num_rows($option1RS);

		?>
	
			<input type="hidden" name="option1" id="option1" value="0" />
            
            <select name="option1dd" id="option1dd" class="optionitem" onchange="update_options_combo(1);">
	
				<option value="-1"><?php echo $row_option1RS['optionLabel']; ?></option>
	
				<?php $i=0; do { ?>
                
                <?php 
								
					$optionitemquantity_sql = sprintf("SELECT SUM(optionitemquantity.Quantity) AS Quantity FROM optionitemquantity WHERE OptionItemID1 = '%s' AND ProductID = '%s'", $row_option1RS['optionitemID'], $row_productRS['ProductID']); 

					$optionitemquantity_result = mysql_query($optionitemquantity_sql);

					$optionitemquantity_row = mysql_fetch_assoc($optionitemquantity_result);

					$optionitemquantity = $optionitemquantity_row['Quantity'];
					
					if( !$row_productRS['useQuantityTracking'] || ($row_productRS['useQuantityTracking'] && $optionitemquantity > 0) ){ 

				?>
                
					<option label="<?php echo $row_option1RS['optionitemname']; if($row_option1RS['optionitemprice'] != "0.00"){ echo " (" . $row_option1RS['optionitemprice'] . ")"; } ?>" value="<?php echo $i; ?>"><?php echo $row_option1RS['optionitemname']; if($row_option1RS['optionitemprice'] != "0.00"){ echo " (" . $row_option1RS['optionitemprice'] . ")"; } ?></option>
	
				<?php 
					
					}else{?>
                    
                    <option label="<?php echo $row_option1RS['optionitemname']; if($row_option1RS['optionitemprice'] != "0.00"){ echo " (" . $row_option1RS['optionitemprice'] . ")"; } ?>" value="<?php echo $i; ?>" style="display:none;"><?php echo $row_option1RS['optionitemname']; if($row_option1RS['optionitemprice'] != "0.00"){ echo " (" . $row_option1RS['optionitemprice'] . ")"; } ?></option>
						
					<?php }
					
					$i++; 
				
				} while ($row_option1RS = mysql_fetch_assoc($option1RS));
	
					$rows1 = mysql_num_rows($option1RS);
	
					if($rows1 > 0) {
	
						mysql_data_seek($option1RS, 0);
	
						$row_option1RS = mysql_fetch_assoc($option1RS);
	
					}
	
				?>
	
			</select>
	
		<?php 
		
		} ?>
        
  	<?php 
	
	}else{ $rows1=0; } 
	
	?>  
            
	<?php if (mysql_num_rows($option2RS) > 0) { ?>
    
        <?php $numoptionitems = mysql_num_rows($option2RS); 
        
        if ( $numoptionitems > 0 && $row_option2RS['optionitemicon']) { ?>
            
            <div class="product_details_swatch_text_align" id="option2label">&nbsp;&nbsp;&nbsp;</div><input type="hidden" name="option2" id="option2" value="0" />
            
            <div class="product_details_swatch_align">
            
			<?php $i=0; 
            
            do { ?>
     			
                <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/swatches/thumb_<?php echo get_option('l4_option_swatch_large_width'); ?>_<?php echo get_option('l4_option_swatch_large_height'); ?>_<?php echo $row_option2RS['optionitemicon']; ?>" alt="<?php echo $row_option2RS['optionitemname']; ?>" class="swatch_img" onclick="update_options_swatch(2, <?php echo $i; ?>);" id="swatch2_<?php echo $i; ?>" />
                <?php }else{?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/swatches/images.php?max_width=<?php echo get_option('l4_option_swatch_large_width'); ?>&max_height=<?php echo get_option('l4_option_swatch_large_height'); ?>&imgfile=<?php echo $row_option2RS['optionitemicon']; ?>" alt="<?php echo $row_option2RS['optionitemname']; ?>" class="swatch_img" onclick="update_options_swatch(2, <?php echo $i; ?>);" id="swatch2_<?php echo $i; ?>" />
                <?php }?>
     
            <?php $i++; 
            
            } while ($row_option2RS = mysql_fetch_assoc($option2RS));  
			
			$rows2 = mysql_num_rows($option2RS);
	
			if($rows2 > 0) {

				mysql_data_seek($option2RS, 0);

				$row_option2RS = mysql_fetch_assoc($option2RS);

			}
			
			?>
            
            </div>
       
        <?php 

        }else{
			
			$numoptionitems = mysql_num_rows($option2RS);

			?>

			<input type="hidden" name="option2" id="option2" value="0" />

            <select name="option2dd" id="option2dd" onchange="update_options_combo(2);" class="optionitem"<?php if($row_productRS['useQuantityTracking']){ ?> disabled="disabled"<?php }?>>
    
                <option value="-1"><?php echo $row_option2RS['optionLabel']?></option>
    
                <?php $i=0; do { ?>
        
                    <option label="<?php echo $row_option2RS['optionitemname']; if($row_option2RS['optionitemprice'] != "0.00"){ echo " (" . $row_option2RS['optionitemprice'] . ")"; } ?>" value="<?php echo $i; ?>"><?php echo $row_option2RS['optionitemname']; if($row_option2RS['optionitemprice'] != "0.00"){ echo " (" . $row_option2RS['optionitemprice'] . ")"; } ?></option>
        
                <?php $i++; 
				
				} while ($row_option2RS = mysql_fetch_assoc($option2RS)); ?>
               
                <?php
    
				$rows2 = mysql_num_rows($option2RS);

				if($rows2 > 0) {

					mysql_data_seek($option2RS, 0);

					$row_option2RS = mysql_fetch_assoc($option2RS);

				}
    
                ?>
    
            </select>
           
        <?php 
        
        }?>

    <?php 
    
    }else{ $rows2=0; } ?>
            
	<?php 
    
    if (mysql_num_rows($option3RS) > 0) { ?>
    
    <?php $numoptionitems = mysql_num_rows($option3RS); 
        
        if ( $numoptionitems > 0 && $row_option3RS['optionitemicon']) { ?>
            
            <div class="product_details_swatch_text_align" id="option3label">&nbsp;&nbsp;&nbsp;</div><input type="hidden" name="option3" id="option3" value="0" />
            
            <div class="product_details_swatch_align">

            <?php $i=0; 
            
            do { ?>
     			
                <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/swatches/thumb_<?php echo get_option('l4_option_swatch_large_width'); ?>_<?php echo get_option('l4_option_swatch_large_height'); ?>_<?php echo $row_option3RS['optionitemicon']; ?>" alt="<?php echo $row_option3RS['optionitemname']; ?>" class="swatch_img" onclick="update_options_swatch(3, <?php echo $i; ?>);" id="swatch3_<?php echo $i; ?>" />
                <?php }else{?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/swatches/images.php?max_width=<?php echo get_option('l4_option_swatch_large_width'); ?>&max_height=<?php echo get_option('l4_option_swatch_large_height'); ?>&imgfile=<?php echo $row_option3RS['optionitemicon']; ?>" alt="<?php echo $row_option3RS['optionitemname']; ?>" class="swatch_img" onclick="update_options_swatch(3, <?php echo $i; ?>);" id="swatch3_<?php echo $i; ?>" />
                <?php }?>
     
            <?php $i++; 
            
            } while ($row_option3RS = mysql_fetch_assoc($option3RS)); 
			
			$rows3 = mysql_num_rows($option3RS);
	
			if($rows3 > 0) {

				mysql_data_seek($option3RS, 0);

				$row_option3RS = mysql_fetch_assoc($option3RS);

			}
			
			?>
            
            </div>
            
        <?php 
        
        }else{
			
			$numoptionitems = mysql_num_rows($option3RS);

			?>
            
            <input type="hidden" name="option3" id="option3" value="0" />

            <select name="option3dd" id="option3dd" onchange="update_options_combo(3);" class="optionitem"<?php if($row_productRS['useQuantityTracking']){ ?> disabled="disabled"<?php }?>>
    
                <option value="-1"><?php echo $row_option3RS['optionLabel']?></option>
    			
				<?php $i=0; do { ?>
    
                <option label="<?php echo $row_option3RS['optionitemname']; if($row_option3RS['optionitemprice'] != "0.00"){ echo " (" . $row_option3RS['optionitemprice'] . ")"; } ?>" value="<?php echo $i; ?>"><?php echo $row_option3RS['optionitemname']; if($row_option3RS['optionitemprice'] != "0.00"){ echo " (" . $row_option3RS['optionitemprice'] . ")"; } ?></option>
    
                <?php $i++; } while ($row_option3RS = mysql_fetch_assoc($option3RS)); ?>
				
                <?php    
	
					$rows3 = mysql_num_rows($option3RS);
    
                    if($rows3 > 0) {
    
                        mysql_data_seek($option3RS, 0);
    
                        $row_option3RS = mysql_fetch_assoc($option3RS);
    
                    }
    
                ?>
    
            </select>
            
        <?php 
        
        }?>

    <?php 
    
    }else{ $rows3=0; } ?>
        
    <?php 
    
    if (mysql_num_rows($option4RS) > 0) { ?>
    
        <?php $numoptionitems = mysql_num_rows($option4RS); 
        
        if ( $numoptionitems > 0 && $row_option4RS['optionitemicon']) { ?>
            
            <div class="product_details_swatch_text_align" id="option4label">&nbsp;&nbsp;&nbsp;</div><input type="hidden" name="option4" id="option4" value="0" />
            
            <div class="product_details_swatch_align">
            
            <?php $i=0; 
            
            do { ?>
     
     			<?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/swatches/thumb_<?php echo get_option('l4_option_swatch_large_width'); ?>_<?php echo get_option('l4_option_swatch_large_height'); ?>_<?php echo $row_option4RS['optionitemicon']; ?>" alt="<?php echo $row_option4RS['optionitemname']; ?>" class="swatch_img" onclick="update_options_swatch(4, <?php echo $i; ?>);" id="swatch4_<?php echo $i; ?>" />
                <?php }else{?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/swatches/images.php?max_width=<?php echo get_option('l4_option_swatch_large_width'); ?>&max_height=<?php echo get_option('l4_option_swatch_large_height'); ?>&imgfile=<?php echo $row_option4RS['optionitemicon']; ?>" alt="<?php echo $row_option4RS['optionitemname']; ?>" class="swatch_img" onclick="update_options_swatch(4, <?php echo $i; ?>);" id="swatch4_<?php echo $i; ?>" />
                <?php }?>
     
            <?php $i++; 
            
            } while ($row_option4RS = mysql_fetch_assoc($option4RS));  
			
			$rows4 = mysql_num_rows($option4RS);
	
			if($rows4 > 0) {

				mysql_data_seek($option4RS, 0);

				$row_option4RS = mysql_fetch_assoc($option4RS);

			}
			
			?>
            
            </div>
        
        <?php 
        
        }else{?>
        
        	<input type="hidden" name="option4" id="option4" value="0" />

            <select name="option4dd" id="option4dd" onchange="update_options_combo(4);" class="optionitem"<?php if($row_productRS['useQuantityTracking']){ ?> disabled="disabled"<?php }?>>
    
                <option value="-1"><?php echo $row_option4RS['optionLabel']?></option>
    
				<?php $i=0; do { ?>
    
                <option label="<?php echo $row_option4RS['optionitemname']; if($row_option4RS['optionitemprice'] != "0.00"){ echo " (" . $row_option4RS['optionitemprice'] . ")"; } ?>" value="<?php echo $i; ?>"><?php echo $row_option4RS['optionitemname']; if($row_option4RS['optionitemprice'] != "0.00"){ echo " (" . $row_option4RS['optionitemprice'] . ")"; } ?></option>
    
                <?php $i++; } while ($row_option4RS = mysql_fetch_assoc($option4RS)); ?>
    
                <?php 
				
				$rows4 = mysql_num_rows($option4RS);

                if($rows4 > 0) {

                    mysql_data_seek($option4RS, 0);

                    $row_option4RS = mysql_fetch_assoc($option4RS);

                }
    
                ?>
    
            </select>
            
        <?php 
        
        }?>

    <?php 
    
    }else{ $rows4=0; } ?>

    <?php 
    
    if (mysql_num_rows($option5RS) > 0) { ?>
    
        <?php $numoptionitems = mysql_num_rows($option5RS); 
        
        if ( $numoptionitems > 0 && $row_option5RS['optionitemicon']) { ?>
            
            <div class="product_details_swatch_text_align" id="option5label">&nbsp;&nbsp;&nbsp;</div><input type="hidden" name="option5" id="option5" value="0" />
            
            <div class="product_details_swatch_align">
            
            <?php $i=0; 
            
            do { ?>
     			
                <?php if(get_option('l4_option_use_pretty_image_names') == "1"){?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/swatches/thumb_<?php echo get_option('l4_option_swatch_large_width'); ?>_<?php echo get_option('l4_option_swatch_large_height'); ?>_<?php echo $row_option5RS['optionitemicon']; ?>" alt="<?php echo $row_option5RS['optionitemname']; ?>" class="swatch_img" onclick="update_options_swatch(5, <?php echo $i; ?>);" id="swatch5_<?php echo $i; ?>" />
                <?php }else{?>
                <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4store/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/products/swatches/images.php?max_width=<?php echo get_option('l4_option_swatch_large_width'); ?>&max_height=<?php echo get_option('l4_option_swatch_large_height'); ?>&imgfile=<?php echo $row_option5RS['optionitemicon']; ?>" alt="<?php echo $row_option5RS['optionitemname']; ?>" class="swatch_img" onclick="update_options_swatch(5, <?php echo $i; ?>);" id="swatch5_<?php echo $i; ?>" />
                <?php }?>
     
            <?php $i++; 
            
            } while ($row_option5RS = mysql_fetch_assoc($option5RS)); 
			
			$rows5 = mysql_num_rows($option5RS);
	
			if($rows5 > 0) {

				mysql_data_seek($option5RS, 0);

				$row_option5RS = mysql_fetch_assoc($option5RS);

			}
			
			?>
            
            </div>
        
        <?php 
        
        }else{?>

            <input type="hidden" name="option5" id="option5" value="0" />
            
            <select name="option5dd" id="option5dd" onchange="update_options_combo(5);" class="optionitem"<?php if($row_productRS['useQuantityTracking']){ ?> disabled="disabled"<?php }?>>

                <option value="-1"><?php echo $row_option5RS['optionLabel']?></option>
				
				<?php $i=0; do{ ?>

                <option label="<?php echo $row_option5RS['optionitemname']; if($row_option5RS['optionitemprice'] != "0.00"){ echo " (" . $row_option5RS['optionitemprice'] . ")"; } ?>" value="<?php echo $i; ?>"><?php echo $row_option5RS['optionitemname']; if($row_option5RS['optionitemprice'] != "0.00"){ echo " (" . $row_option5RS['optionitemprice'] . ")"; } ?></option>

                <?php $i++; } while ($row_option5RS = mysql_fetch_assoc($option5RS)); ?>
          
				<?php
               
                $rows5 = mysql_num_rows($option5RS);

                if($rows5 > 0) {

                mysql_data_seek($option5RS, 0);
				
                    $row_option5RS = mysql_fetch_assoc($option5RS);

                }

            	?>

            </select>
           
        <?php 
       
        }?>

    <?php 

    }else{ $rows5=0; } ?>
   
    <?php if(mysql_num_rows($option1RS) > 0){?>

		<div class="divider"></div>

	<?php }?>

	<div class="floatleft">
    	<div <?php if($row_productRS['isDownload'] == 1){ echo "class=\"hide_quantity\""; }else{?>class="quantity_text"<?php }?>>Quantity: <input type="text" name="Quantity" id="Quantity" value="1" style="width:50px;" /></div><div class="instock_text"<?php if(!$row_settingsRS['quantitytracking'] || $row_productRS['isDonation']){ echo " style=\"display:none;\""; } ?> id="instock_quantity">In Stock: <?php echo $row_productRS['quantity']; ?></div></div>

    <div class="buttonalignment">

        <input type="submit" class="l4store_button" value="ADD TO CART" onclick="checkaddtocartform('<?php echo $rows1; ?>', '<?php echo $rows2; ?>', '<?php echo $rows3; ?>', '<?php echo $rows4; ?>', '<?php echo $rows5; ?>', '<?php echo $row_productRS['quantity']; ?>'); return false;" name="AddToCart" id="AddToCart" />

    </div>

    <input name="ProductID" type="hidden" id="ProductID" value="<?php echo $row_productRS['ProductID']; ?>" />

    <input name="l4_action" type="hidden" id="l4_action" value="addtocart" />

    <input name="origprice" type="hidden" id="origprice" value="<?php echo $row_productRS['Price']; ?>" />

    <input name="currprice" type="hidden" id="currprice" value="<?php echo $row_productRS['Price']; ?>" />
    
    <input name="totalquantity" type="hidden" id="totalquantity" value="<?php echo $row_productRS['quantity']; ?>" />

    <input name="option1pricechange" type="hidden" id="option1pricechange" value="0.00" />

    <input name="option2pricechange" type="hidden" id="option2pricechange" value="0.00" />

    <input name="option3pricechange" type="hidden" id="option3pricechange" value="0.00" />

    <input name="option4pricechange" type="hidden" id="option4pricechange" value="0.00" />

    <input name="option5pricechange" type="hidden" id="option5pricechange" value="0.00" />

</div>

<script>

if(document.getElementById('option1dd')){
	update_options_combo(1);
}else{
	update_options_swatch(1, first_available());
}

</script>