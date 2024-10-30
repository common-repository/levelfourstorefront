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

<div class="checkout_form_holder_wide">

    <div class="checkout_form_radio_button">

        <div class="floatleft"><input id="UseBillingForShipping" name="UseBilling" type="radio" value="true"<?php if($_SESSION['UseBilling'] != "false"){?> checked="checked"<?php }?> onchange="update_use_billing()" />Same as Billing Address</div>

    </div>

    <div class="checkout_form_radio_button">

        <div class="floatleft"><input id="UseShippingForShipping" name="UseBilling" type="radio" value="false"<?php if($_SESSION['UseBilling'] == "false"){?> checked="checked"<?php }?> onchange="update_use_shipping()" />Different Than Billing Address</div>

    </div>
	
	<div id="shipping_form">

        <div class="form_row">

            <div class="checkout_form_label">First Name:</div>

            <div class="checkout_form_input">

                <input type="text" name="ShippingName" id="ShippingName"<?php if(isset($_SESSION['ShippingName'])){?> value="<?php echo $_SESSION['ShippingName'];?>"<?php }else{ ?> value="<?php echo $accountinforow['ShipName']; ?>"<?php }?> class="checkout_form_email_input" />

            </div>

        </div>

        <div class="form_row">

            <div class="checkout_form_label">Last Name:</div>

            <div class="checkout_form_input">

                <input type="text" name="ShippingLastName" id="ShippingLastName"<?php if(isset($_SESSION['ShippingLastName'])){?> value="<?php echo $_SESSION['ShippingLastName'];?>"<?php }else{ ?> value="<?php echo $accountinforow['ShipLastName']; ?>"<?php }?> class="checkout_form_email_input" />

            </div>

        </div>

        <div class="form_row">

            <div class="checkout_form_label">Address:</div>
            
            <div class="checkout_form_input">

                <input type="text" name="ShippingAddress" id="ShippingAddress"<?php if(isset($_SESSION['ShippingAddress'])){?> value="<?php echo $_SESSION['ShippingAddress'];?>"<?php }else{ ?> value="<?php echo $accountinforow['ShipAddress']; ?>"<?php }?> class="checkout_form_email_input" />
				
            </div>
            
        </div>

        <div class="form_row">

            <div class="checkout_form_label">City:</div>

            <div class="checkout_form_input">

                <input type="text" name="ShippingCity" id="ShippingCity"<?php if(isset($_SESSION['ShippingCity'])){?> value="<?php echo $_SESSION['ShippingCity'];?>"<?php }else{ ?> value="<?php echo $accountinforow['ShipCity']; ?>"<?php }?> class="checkout_form_email_input" />

            </div>

        </div>

        <div class="form_row">

            <div class="checkout_form_label">State:</div>

            <div class="checkout_form_input">

				<?php if($row_settingsRS['usestate']){?>
                
                <?php
				$shipstate_sql = "SELECT * FROM states ORDER BY sortorder";
				$shipstate_result = mysql_query($shipstate_sql);
				?>
                <select name="ShippingState" id="ShippingState" class="checkout_form_email_select">
                  <option value="0">Select a State</option>
                  	<?php while($shipstate = mysql_fetch_assoc($shipstate_result)){ ?>
						<option value="<?php echo $shipstate['code_sta']; ?>"<?php if( ( isset($_SESSION['ShippingState']) && $shipstate['code_sta'] == $_SESSION['ShippingState'] ) || ( $shipstate['code_sta'] == $accountinforow['ShipState'] ) ){?> selected="selected"<?php }?>><?php echo $shipstate['name_sta']; ?></option>
					<?php }?>
                </select>
                <?php }else{ ?>

                <input type="text" name="ShippingState" id="ShippingState" value="<?php if(isset($_SESSION['ShippingState']) && $_SESSION['ShippingState'] != ""){ echo $_SESSION['ShippingState']; }else{ echo $accountinforow['ShipState']; }?>" class="checkout_form_email_input" />
                
                <?php }?>

            </div>

        </div>

        <div class="form_row">

            <div class="checkout_form_label">Postal Code:</div>

            <div class="checkout_form_input">

                <input type="text" name="ShippingZip" id="ShippingZip"<?php if(isset($_SESSION['ShippingZip'])){?> value="<?php echo $_SESSION['ShippingZip'];?>"<?php }else{ ?> value="<?php echo $accountinforow['ShipZip']; ?>"<?php }?> class="checkout_form_email_input" />
                
            </div>

        </div>

        <div class="form_row">

            <div class="checkout_form_label">Phone:</div>

            <div class="checkout_form_input">

                <input type="text" name="ShippingPhone" id="ShippingPhone"<?php if(isset($_SESSION['ShippingPhone'])){?> value="<?php echo $_SESSION['ShippingPhone'];?>"<?php }else{ ?> value="<?php echo $accountinforow['ShipPhone']; ?>"<?php }?> class="checkout_form_email_input" />

            </div>

        </div>

        <div class="form_row">

            <div class="checkout_form_label">Country:</div>

            <div class="checkout_form_input">
            
            <?php if($row_settingsRS['usecountry']){?>
                
                <?php
				$shipcountry_sql = "SELECT * FROM countries ORDER BY sortorder";
				$shipcountry_result = mysql_query($shipcountry_sql);
				?>
                <select name="ShippingCountry" id="ShippingCountry" class="checkout_form_email_select">
                  <option value="0">Select a Country</option>
                  	<?php while($shipcountry = mysql_fetch_assoc($shipcountry_result)){ ?>
						<option value="<?php echo $shipcountry['iso2_cnt']; ?>"<?php if( ( isset($_SESSION['ShippingCountry']) && $shipcountry['iso2_cnt'] == $_SESSION['ShippingCountry'] ) || ( $shipcountry['iso2_cnt'] == $accountinforow['ShipCountry'] ) ){?> selected="selected"<?php }?>><?php echo $shipcountry['name_cnt']; ?></option>
					<?php }?>
                </select>
                
            <?php }else{ ?>
            
            	<input type="text" name="ShippingCountry" id="ShippingCountry" value="<?php if(isset($_SESSION['ShippingCountry']) && $_SESSION['ShippingCountry'] != ""){ echo $_SESSION['ShippingCountry']; }else{ echo $accountinforow['ShipCountry']; }?>" class="checkout_form_email_input" />
            
            
            <?php }?>
            
            </div>

        </div>

    </div>

</div>

<script>
<?php if(isset($_SESSION['UseBilling']) && $_SESSION['UseBilling'] == "false"){?>
update_use_shipping();
<?php }else{?>
update_use_billing();
<?php }?>
</script>