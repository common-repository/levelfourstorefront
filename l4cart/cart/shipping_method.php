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

<div class="l4store_header">Select Shipping Method</div>

<div class="checkout_form_content">

	<div class="checkout_form_holder_wide">

		<?php 
    
        $settings_sql = "SELECT * FROM settings";
    
        $settings_result = mysql_query($settings_sql);
    
        $settings_row = mysql_fetch_assoc($settings_result);
    
         ?>	
    
        <input type="hidden" name="usedynamic" id="usedynamic" value="<?php echo $settings_row['shippingusedynamic']; ?>"  />
    
        <input type="hidden" name="useweight" id="useweight" value="<?php echo $settings_row['shippinguseweighttriggers']; ?>"  />
    
        <input type="hidden" name="useprice" id="useprice" value="<?php echo $settings_row['shippingusetriggers']; ?>"  />
    
        <?php if($settings_row['shippingusedynamic'] == "1"){?>
    
            <div class="form_row">
    
                <div class="checkout_form_label">Shipping Method:</div>
    
                <div class="checkout_form_input">
    
                <?php 
    
                if(isset($_SESSION['ShippingZip']) && $_SESSION['ShippingZip'] != ""){
    
                    $shipxmldata = calculateshipping($Cart, $shippable_subtotal, $totalweight, "0", "US", $_SESSION['ShippingZip']); 
    
                }else if(isset($accountinforow['ShipZip']) && $accountinforow['ShipZip'] != ""){
    
                    $shipxmldata = calculateshipping($Cart, $shippable_subtotal, $totalweight, "0", "US", $accountinforow['ShipZip']);
    
                }else{
    
                    $shipxmldata = calculateshipping($Cart, $shippable_subtotal, $totalweight, "0", "US", "97801"); //use US and random zip to determine the shipping options, not pricing;
    
                }?>
    
                <select name="ShippingRate" id="ShippingRate">
    
                    <option value="0">Select One</option>
    
                    <?php 
    
                    if($shipxmldata != "error"){
    
                        for($i=0; $i<count($shipxmldata); $i++){?>
    
                            <option value="<?php echo $shipxmldata[$i]['ServiceName']; ?>"<?php if(isset($_SESSION['ShippingRate']) && $_SESSION['ShippingRate'] == $shipxmldata[$i]['ServiceName']){?> selected="selected"<?php }?>><?php echo $shipxmldata[$i]['ServiceName']; if( (isset($_SESSION['ShippingZip']) && $_SESSION['ShippingZip'] != "") || ( isset($accountinforow['ShipZip']) && $accountinforow['ShipZip'] != "") ){ echo " (". $row_settingsRS['currencySymbol'] .  $shipxmldata[$i]['Rate'] . ")"; }?></option> 
    
                         <?php } 
    
                    }?>
    
                </select>
    
                </div>
    
            </div>
    
        <?php }else{?>
    
        <div class="checkout_form_padding">
    
            <div class="checkout_form_radio_button"><input name="group2" type="radio" value="1" checked="checked" />Standard Shipping (<?php  echo $row_settingsRS['currencySymbol']; echo calculateshipping($Cart, $subtotal, $totalweight, false, "", ""); ?>)</div>
    
            <div class="checkout_form_radio_button"><input type="checkbox" name="ShipExpress" id="ShipExpress" value="true" onchange="updateshippingtotal('<?php echo getexpeditedshipping(); ?>')"<?php if($_SESSION['ShipExpress'] == "true"){?> checked="checked"<?php }?> /> Ship Express(+<?php  echo $row_settingsRS['currencySymbol']; echo getexpeditedshipping(); ?>)</div>
    
        </div>
    
        <?php }?>
        
    </div>

</div>