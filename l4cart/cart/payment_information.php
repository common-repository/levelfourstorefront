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

<div class="l4store_header">Enter Payment Information</div>

<div class="checkout_form_content">

    <div  class="checkout_form_holder_wide">

        <div id="shipping_form">
			
             <?php require_once(WP_PLUGIN_DIR . "/" .  L4_PLUGIN_DIRECTORY . "/scripts/l4html/validation.php"); ?>
             
             <?php $validate = new Validate; ?>
             
             <?php if(!$validate->validated($row_settingsRS['regcode'])){ ?>
             
             <div style="text-align:center; width:100%;">You will be manually billed once the order is complete.</div>
             
             <input type="hidden" name="PaymentType" id="PaymentType" value="0" />
             
             <?php }else{?>
             
        	 <?php if($GrandTotalPrice > 0){?>

            <div id="PaymentTypeError" class="errortext_full">Please select a payment type</div>

            <div class="form_row">

                <div class="checkout_form_label">&nbsp;&nbsp;&nbsp;</div>

                <div class="checkout_form_input input_header">Payment Information:</div>

            </div>

            <div class="form_row" id="credit_card_drop_down">

                <div class="checkout_form_label">Payment Type:</div>

                <div class="checkout_form_input"><select name="PaymentType" id="PaymentType" onchange="updatediscounts()" class="payment_input">

                                        <option value="0" selected="selected">Please Select...</option>

                                        <?php if($row_settingsRS['usepaypal']){?><option value="1"<?php if($row_settingsRS['usepaypal'] && !$row_settingsRS['ccvisa'] && !$row_settingsRS['ccmastercard'] && !$row_settingsRS['ccdiscover'] && !$row_settingsRS['ccamex'] && !$row_settingsRS['ccdiners'] && !$row_settingsRS['ccjbc']){?> selected="selected"<?php }?>>PayPal</option><?php }?>

										<?php if($row_settingsRS['ccvisa']){?><option value="2">Visa</option><?php }?>

                                        <?php if($row_settingsRS['ccdiscover']){?><option value="3">Discover</option><?php }?>

                                        <?php if($row_settingsRS['ccmastercard']){?><option value="4">MasterCard</option><?php }?>

										<?php if($row_settingsRS['ccamex']){?><option value="5">American Express</option><?php }?>

                                        <?php if($row_settingsRS['ccdiners']){?><option value="6">Diners Club</option><?php }?>

                                        <?php if($row_settingsRS['ccjbc']){?><option value="7">JCB</option><?php }?>

                                    </select>

                                    </div>

            </div>

            

            <div class="form_row_checkout_credit_card_images l4inactive" id="credit_card_images">

                

                <div class="checkout_credit_card_image_label">Payment Type:</div>

                <div class="checkout_credit_card_images">

					<?php if($row_settingsRS['usepaypal']){?>

                        <div id="paypal_image" class="hovercursor floatleft_creditcard">

                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/paypal.png" onclick="choose_cctype('0');" />

                        </div>

                        <div id="paypal_image_inactive" class="hovercursor photo_inactive floatleft_creditcard">

                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/paypal_inactive.png" onclick="choose_cctype('0');" />

                        </div>

                    <?php }?>

                    <?php if($row_settingsRS['ccvisa']){?>

                        <div id="visa_image" class="hovercursor floatleft_creditcard">

                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/visa.png" onclick="choose_cctype('1');" />

                        </div>

                        <div id="visa_image_inactive" class="hovercursor photo_inactive floatleft_creditcard">

                            <img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/visa_inactive.png" onclick="choose_cctype('1');" />

                        </div>

                    <?php }?>

                     <?php if($row_settingsRS['ccdiscover']){?>

                    	<div id="discover_image" class="hovercursor floatleft_creditcard">

                    		<img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/discover.png" onclick="choose_cctype('2');" />

                    	</div>

                    	<div id="discover_image_inactive" class="hovercursor photo_inactive floatleft_creditcard">

                    		<img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/discover_inactive.png" onclick="choose_cctype('2');" />

                    	</div>

                    <?php }?>

					<?php if($row_settingsRS['ccmastercard']){?>

                    	<div id="mastercard_image" class="hovercursor floatleft_creditcard">

                    		<img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/mastercard.png" onclick="choose_cctype('3');" />

                    	</div>

                    	<div id="mastercard_image_inactive" class="hovercursor photo_inactive floatleft_creditcard">

                    		<img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/mastercard_inactive.png" onclick="choose_cctype('3');" />

                    	</div>

                    <?php }?>

                    <?php if($row_settingsRS['ccamex']){?>

                    	<div id="american_express_image" class="hovercursor floatleft_creditcard">

                    		<img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/american_express.png" onclick="choose_cctype('4');" />

                    	</div>

                    	<div id="american_express_image_inactive" class="hovercursor photo_inactive floatleft_creditcard">

                    		<img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/american_express_inactive.png" onclick="choose_cctype('4');" />

                    	</div>

                    <?php }?>

                    <?php if($row_settingsRS['ccdiners']){?>

                    	<div id="diners_image" class="hovercursor floatleft_creditcard">

                    		<img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/diners.png" onclick="choose_cctype('5');" />

                    	</div>

                    	<div id="diners_image_inactive" class="hovercursor photo_inactive floatleft_creditcard">

                    		<img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/diners_inactive.png" onclick="choose_cctype('5');" />

                    	</div>

                    <?php }?>

                    <?php if($row_settingsRS['ccjbc']){?>

                    	<div id="jcb_image" class="hovercursor floatleft_creditcard">

                    		<img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/jcb.png" onclick="choose_cctype('6');" />

                    	</div>

                    	<div id="jcb_image_inactive" class="hovercursor photo_inactive floatleft_creditcard">

                    		<img src="<?php echo str_replace("levelfourstorefront/", "", str_replace("l4cart/", "", plugin_dir_url(__DIR__) ) ); ?>levelfourstorefront/images/jcb_inactive.png" onclick="choose_cctype('6');" />

                    	</div>

                    <?php }?>

                    

				</div>

            </div>

            

            <?php if($row_settingsRS['usepaypal']){ ?>

                <div class="form_row" id="paypalmessage_nojavascript">
    
                    <div class="checkout_form_paypal_message">If you choose to pay with PayPal, then do not fill out your credit card information on this page.</div>
    
                </div>
			
				<?php if($row_settingsRS['usepaypal'] && !$row_settingsRS['ccvisa'] && !$row_settingsRS['ccmastercard'] && !$row_settingsRS['ccdiscover'] && !$row_settingsRS['ccamex'] && !$row_settingsRS['ccdiners'] && !$row_settingsRS['ccjbc']){?>
                 
                 <div class="checkout_form_paypal_message">We use PayPal as our payment gateway. Once you submit your order, you will be directed to PayPal to complete your order.</div>
                 
                 <div id="paypalmessage"></div>
                 
                <?php }else{?>
                
                    <div class="l4inactive" id="paypalmessage">
            
                        <div class="checkout_form_paypal_message">You have chosen PayPal as your payment method. Once you submit your order, you will be directed to PayPal to complete your order.</div>
                        
                    </div>
                    
                
                <?php }?>

            

            <?php }?>

            <div id="credit_card_information">

                <div class="form_row">

                    <div class="checkout_form_label">Card Number:</div>

                    <div class="checkout_form_input">

                    	<input type="text" name="CardNumber" id="CardNumber" autocomplete="off" class="payment_input" />

                    	

                    </div>

                </div>

                <div class="form_row"> 

                    <div class="checkout_form_label">Expiration Date:</div>

                    <div class="checkout_form_input">

                      <select name="ExpirationDateMonth" id="ExpirationDateMonth" class="payment_input">

                        <?php $i=0; while($i<12){$i++; ?>

                        <option value="<?php if($i<10){ echo "0" . $i; }else{ echo $i; } ?>"><?php if($i<10){ echo "0" . $i; }else{ echo $i; } ?></option>

                        <?php }?>

                      </select>

                      <select name="ExpirationDateYear" id="ExpirationDateYear" class="payment_input">

                        <?php $curryear=date('Y'); $i=$curryear; while($i<($curryear+25)){ ?>

                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>

                        <?php $i++;}?>

                      </select>

                    </div>

                </div>

                <div class="form_row">

                    <div class="checkout_form_label">Security Number:</div>

                    <div class="checkout_form_input">

                    	<input type="text" name="SecurityNumber" id="SecurityNumber" maxlength="4" autocomplete="off" class="payment_input" />

                  	</div>

                </div>

            </div>  

            

            <?php }else{?>

            

            <div class="form_row">



                <div class="checkout_form_label">&nbsp;&nbsp;&nbsp;</div>



                <div class="checkout_form_input input_header">This Order is Free</div>



            </div>

                      

            <?php }?>

            <?php }?>      

        </div>

    </div>

</div>



<script type="text/javascript">

	<?php if($row_settingsRS['usepaypal']){ ?>

		document.getElementById('paypalmessage_nojavascript').style.display = "none";

		document.getElementById('paypalmessage').style.display = "none";

	<?php }?>

	document.getElementById('credit_card_images').style.display = "block";

	document.getElementById('credit_card_drop_down').style.display = "none";

	document.getElementById('credit_card_information').style.display = "none";

	function choose_cctype(cctype){

		document.getElementById('credit_card_information').style.display = "block";

		document.getElementById('PaymentType').value = String( Number( cctype ) + 1 );

		document.getElementById('PaymentTypeError').style.display = "none";

		<?php if($row_settingsRS['usepaypal']){?>

		if(cctype == 0){	

			document.getElementById('paypal_image').style.display = "block";

			document.getElementById('paypal_image_inactive').style.display = "none";

			document.getElementById('credit_card_information').style.display = "none";

			document.getElementById('paypalmessage').style.display = "block";

		}else{

			document.getElementById('paypal_image').style.display = "none";

			document.getElementById('paypal_image_inactive').style.display = "block";

			document.getElementById('credit_card_information').style.display = "block";

			document.getElementById('paypalmessage').style.display = "none";

		}

		<?php }?>

		

		<?php if($row_settingsRS['ccvisa']){?>

		if(cctype == 1){	

			document.getElementById('visa_image').style.display = "block";

			document.getElementById('visa_image_inactive').style.display = "none";

		}else{

			document.getElementById('visa_image').style.display = "none";

			document.getElementById('visa_image_inactive').style.display = "block";

		}

		<?php }?>

		

		<?php if($row_settingsRS['ccdiscover']){?>

		if(cctype == 2){	

			document.getElementById('discover_image').style.display = "block";

			document.getElementById('discover_image_inactive').style.display = "none";

		}else{

			document.getElementById('discover_image').style.display = "none";

			document.getElementById('discover_image_inactive').style.display = "block";

		}

		<?php }?>

		

		<?php if($row_settingsRS['ccmastercard']){?>

		if(cctype == 3){	

			document.getElementById('mastercard_image').style.display = "block";

			document.getElementById('mastercard_image_inactive').style.display = "none";
			
		}else{

			document.getElementById('mastercard_image').style.display = "none";

			document.getElementById('mastercard_image_inactive').style.display = "block";

		}

		<?php }?>

		

		<?php if($row_settingsRS['ccamex']){?>

		if(cctype == 4){

			document.getElementById('american_express_image').style.display = "block";

			document.getElementById('american_express_image_inactive').style.display = "none";

		}else{

			document.getElementById('american_express_image').style.display = "none";

			document.getElementById('american_express_image_inactive').style.display = "block";

		}

		<?php }?>

		

		<?php if($row_settingsRS['ccdiners']){?>

		if(cctype == 5){	

			document.getElementById('diners_image').style.display = "block";

			document.getElementById('diners_image_inactive').style.display = "none";

		}else{

			document.getElementById('diners_image').style.display = "none";

			document.getElementById('diners_image_inactive').style.display = "block";

		}

		<?php }?>

		

		<?php if($row_settingsRS['ccjbc']){?>

		if(cctype == 6){

			document.getElementById('jcb_image').style.display = "block";

			document.getElementById('jcb_image_inactive').style.display = "none";

		}else{

			document.getElementById('jcb_image').style.display = "none";

			document.getElementById('jcb_image_inactive').style.display = "block";

		}

		<?php }?>

	}
	
</script>