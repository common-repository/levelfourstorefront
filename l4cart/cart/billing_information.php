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

    <div class="form_row">

	    <div class="checkout_form_label">&nbsp;&nbsp;&nbsp;</div>

        <div class="checkout_form_input input_header">Billing Information:</div>

    </div>

    <div class="form_row">

	    <div class="checkout_form_label">First Name:</div>

		<div class="checkout_form_input">

        	<input type="text" name="BillingName" id="BillingName" value="<?php if(isset($_SESSION['BillingName']) && $_SESSION['BillingName'] != ""){ echo $_SESSION['BillingName']; }else{ echo $accountinforow['BillName']; }?>" class="checkout_form_email_input" />

        </div>

    </div>

    <div class="form_row">

	    <div class="checkout_form_label">Last Name:</div>

    	<div class="checkout_form_input">

        	<input type="text" name="BillingLastName" id="BillingLastName" value="<?php if(isset($_SESSION['BillingLastName']) && $_SESSION['BillingLastName'] != ""){ echo $_SESSION['BillingLastName']; }else{ echo $accountinforow['BillLastName']; }?>" class="checkout_form_email_input" />

        </div>

	</div>

    <div class="form_row">

	    <div class="checkout_form_label">Address:</div>

    	<div class="checkout_form_input">

        	<input type="text" name="BillingAddress" id="BillingAddress" value="<?php if(isset($_SESSION['BillingAddress']) && $_SESSION['BillingAddress'] != ""){ echo $_SESSION['BillingAddress']; }else{ echo $accountinforow['BillAddress']; }?>" class="checkout_form_email_input" />
            
        </div>

	</div>

    <div class="form_row">

	    <div class="checkout_form_label">City:</div>

    	<div class="checkout_form_input">

        	<input type="text" name="BillingCity" id="BillingCity" value="<?php if(isset($_SESSION['BillingCity']) && $_SESSION['BillingCity'] != ""){ echo $_SESSION['BillingCity']; }else{ echo $accountinforow['BillCity']; }?>" class="checkout_form_email_input" />
            
        </div>

	</div>

    <div class="form_row">

	    <div class="checkout_form_label">State:</div>

    	<div class="checkout_form_input">

			<?php if($row_settingsRS['usestate']){?>
                
                <?php
				$billstate_sql = "SELECT * FROM states ORDER BY sortorder";
				$billstate_result = mysql_query($billstate_sql);
				?>
                <select name="BillingState" id="BillingState" class="checkout_form_email_select">
                  <option value="0">Select a State</option>
                  	<?php while($billstate = mysql_fetch_assoc($billstate_result)){ ?>
						<option value="<?php echo $billstate['code_sta']; ?>"<?php if( ( isset($_SESSION['BillingState']) && strtoupper($billstate['code_sta']) == strtoupper($_SESSION['BillingState']) ) || ( strtoupper($billstate['code_sta']) == strtoupper($accountinforow['BillState'])) ){?> selected="selected"<?php }?>><?php echo $billstate['name_sta']; ?></option>
					<?php }?>
                </select>
                <?php }else{ ?>

        	<input type="text" name="BillingState" id="BillingState" value="<?php if(isset($_SESSION['BillingState']) && $_SESSION['BillingState'] != ""){ echo $_SESSION['BillingState']; }else{ echo $accountinforow['BillState']; }?>" class="checkout_form_email_input" />

			<?php }?>

        </div>

	</div>

    <div class="form_row">

	    <div class="checkout_form_label">Postal Code:</div>

    	<div class="checkout_form_input">

        	<input type="text" name="BillingZip" id="BillingZip" value="<?php if(isset($_SESSION['BillingZip']) && $_SESSION['BillingZip'] != ""){ echo $_SESSION['BillingZip']; }else{ echo $accountinforow['BillZip']; }?>" class="checkout_form_email_input" />

        </div>

	</div>

    <div class="form_row">

	    <div class="checkout_form_label">Phone:</div>

    	<div class="checkout_form_input">

        	<input type="text" name="BillingPhone" id="BillingPhone" value="<?php if(isset($_SESSION['BillingPhone']) && $_SESSION['BillingPhone'] != ""){ echo $_SESSION['BillingPhone']; }else{ echo $accountinforow['BillPhone']; }?>" class="checkout_form_email_input" />

        </div>

	</div>
    
    <div class="form_row">

	    <div class="checkout_form_label">Country:</div>

    	<div class="checkout_form_input">
        
        <?php if($row_settingsRS['usecountry']){?>
                
			<?php
            $billcountry_sql = "SELECT * FROM countries ORDER BY sortorder";
            $billcountry_result = mysql_query($billcountry_sql);
            ?>
            <select name="BillingCountry" id="BillingCountry" class="checkout_form_email_select">
              <option value="0">Select a Country</option>
                <?php while($billcountry = mysql_fetch_assoc($billcountry_result)){ ?>
                    <option value="<?php echo $billcountry['iso2_cnt']; ?>"<?php if( ( isset($_SESSION['BillingCountry']) &&  $billcountry['iso2_cnt'] == $_SESSION['BillingCountry'] ) || ( $billcountry['iso2_cnt'] == $accountinforow['BillCountry'] ) ){?> selected="selected"<?php }?>><?php echo $billcountry['name_cnt']; ?></option>
                <?php }?>
            </select>
            
        <?php }else{ ?>
        
        	<input type="text" name="BillingCountry" id="BillingCountry" value="<?php if(isset($_SESSION['BillingCountry']) && $_SESSION['BillingState'] != ""){ echo $_SESSION['BillingCountry']; }else{ echo $accountinforow['BillCountry']; }?>" class="checkout_form_email_input" />
        
        <?php }?>
        
        </div>

    </div>

</div>