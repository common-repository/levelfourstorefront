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


if(userloggedin()){

	$accountinfosql=sprintf("SELECT * FROM clients WHERE Email='%s' and Password='%s'", mysql_real_escape_string($_SESSION['l4username']), mysql_real_escape_string($_SESSION['l4password']));

	$accountinforesult=mysql_query($accountinfosql);

	$accountinforow = mysql_fetch_assoc($accountinforesult);

	$accountinfototalrows=mysql_num_rows($accountinforesult);

}

?>



<script type="text/javascript">

function check_shipping_form(f){

	var errors = 0;

	if(document.getElementById('FirstName').value.length == 0){

		document.getElementById('FirstName').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('FirstName').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('LastName').value.length == 0){

		document.getElementById('LastName').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('LastName').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('Address').value.length == 0){

		document.getElementById('Address').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('Address').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('ZipCode').value.length == 0){

		document.getElementById('ZipCode').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('ZipCode').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('City').value.length == 0){

		document.getElementById('City').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('City').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('State').value.length == 0){

		document.getElementById('State').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('State').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('Country').value.length == 0){

		document.getElementById('Country').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('Country').style.border = "solid 1px #666666";

	}

	

	if(document.getElementById('Phone').value.length == 0){

		document.getElementById('Phone').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('Phone').style.border = "solid 1px #666666";

	}

	

	if(errors == 0){	

		document.getElementById('errortext2').style.display = "none";
		
		
		f.submit();

		
		return false;

	}else{

		document.getElementById('errortext2').style.display = "block";
		
		return false;

	}

}

</script>



<div class="dashboard_header_full">

	<div id="errortext2" class="errortext_full">Please make corrections to the highlighted fields.</div>

    <div class="l4store_title">Your Shipping Address</div>

    <div class="dashboard_head_content">Please note: Changes made to your account information, including shipping addresses, will only affect new orders. All previously placed orders will be sent to the address listed on the date of purchase.</div>

</div>

    

<div class="dashboard_full">

	<div class="register_content_small">*Required Information</div>

    <form id="registerForm" name="registerForm" method="post" action="<?php echo $accountpage; ?>" onsubmit="return check_shipping_form(this); return false;">

            <div class="register_row"><div class="register_label">*First Name: </div><div class="register_field_align"><input type="text" name="FirstName" id="FirstName" class="login_field" value="<?php echo $accountinforow['ShipName']; ?>"></div></div>

            <div class="register_row"><div class="register_label">*Last Name: </div><div class="register_field_align"><input type="text" name="LastName" id="LastName" class="login_field" value="<?php echo $accountinforow['ShipLastName']; ?>"></div></div>

            <div class="register_row"><div class="register_label">*Address: </div><div class="register_field_align"><input type="text" name="Address" id="Address" class="login_field" value="<?php echo $accountinforow['ShipAddress']; ?>"></div></div>

            <div class="register_row"><div class="register_label">*City: </div><div class="register_field_align"><input type="text" name="City" id="City" class="login_field" value="<?php echo $accountinforow['ShipCity']; ?>"></div></div>

          <div class="register_row"><div class="register_label">*State: </div><div class="register_field_align">
            <?php if($row_settingsRS['usestate']){?>
                
                <?php
				$shipstate_sql = "SELECT * FROM states ORDER BY sortorder";
				$shipstate_result = mysql_query($shipstate_sql);
				?>
                <select name="State" id="State" class="login_field">
                  <option value="0">Select a State</option>
                  	<?php while($shipstate = mysql_fetch_assoc($shipstate_result)){ ?>
						<option value="<?php echo $shipstate['code_sta']; ?>"<?php if( strtoupper($shipstate['code_sta']) == strtoupper($accountinforow['ShipState']) ){?> selected="selected"<?php }?>><?php echo $shipstate['name_sta']; ?></option>
					<?php }?>
                </select>
                <?php }else{ ?>

        		<input type="text" name="State" id="State" class="login_field" value="<?php echo $accountinforow['ShipState']; ?>">

			<?php }?>
            </div></div>

           <div class="register_row"><div class="register_label">*Zip/Postal Code: </div><div class="register_field_align"><input type="text" name="ZipCode" id="ZipCode" class="login_field" value="<?php echo $accountinforow['ShipZip']; ?>"></div></div>

           <div class="register_row"><div class="register_label">*Country: </div><div class="register_field_align">
			<?php if($row_settingsRS['usecountry']){?>
                
				<?php
                $shipcountry_sql = "SELECT * FROM countries ORDER BY sortorder";
                $shipcountry_result = mysql_query($shipcountry_sql);
                ?>
                <select name="Country" id="Country" class="login_field">
                  <option value="0">Select a Country</option>
                    <?php while($shipcountry = mysql_fetch_assoc($shipcountry_result)){ ?>
                        <option value="<?php echo $shipcountry['iso2_cnt']; ?>"<?php if( $shipcountry['iso2_cnt'] == $accountinforow['ShipCountry'] ){?> selected="selected"<?php }?>><?php echo $shipcountry['name_cnt']; ?></option>
                    <?php }?>
                </select>
                
            <?php }else{ ?>
            
                <input type="text" name="Country" id="Country" value="<?php echo $accountinforow['ShipCountry']; ?>" class="login_field" />
            
            <?php }?>
        	</div></div>

           <div class="register_row"><div class="register_label">*Phone: </div><div class="register_field_align"><input type="text" name="Phone" id="Phone" class="login_field" value="<?php echo $accountinforow['ShipPhone']; ?>"></div></div>

			<input type="hidden" name="l4_action" value="shippinginfo" />

           <div class="register_label">&nbsp;&nbsp;</div><div class="register_field_align"><input type="submit" name="updateinfo" id="updateinfo" value="Update" class="l4store_button">&nbsp;&nbsp;&nbsp;&nbsp;or <a href="<?php echo $accountpage; ?>" class="l4store_link">cancel</a></div>

        </form>

</div>