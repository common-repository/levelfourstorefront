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



function numberWithCommas(x) {

    x = x.toString();

    var pattern = /(-?\d+)(\d{3})/;

    while (pattern.test(x))

        x = x.replace(pattern, "$1,$2");

    return x;

}



function roundNumber(num, dec) {

	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);

	return result;

}



function removecartitem(tempid){

	window.location = "../l4cartscripts/removecartitem.php?tempid=" + tempid;

}



function copybilltoship(){

	document.getElementById('ShippingAddress').value = document.getElementById('BillingAddress').value;

	document.getElementById('ShippingCity').value = document.getElementById('BillingCity').value;

	document.getElementById('ShippingState').value = document.getElementById('BillingState').value;

	document.getElementById('ShippingZip').value = document.getElementById('BillingZip').value;

	document.getElementById('ShippingCountry').selectedIndex = document.getElementById('BillingCountry').selectedIndex;

}



function copybilltoship2(){

	document.getElementById('ShippingName').value = document.getElementById('BillingName').value;

	document.getElementById('ShippingLastName').value = document.getElementById('BillingLastName').value;

	document.getElementById('ShippingAddress').value = document.getElementById('BillingAddress').value;

	document.getElementById('ShippingCity').value = document.getElementById('BillingCity').value;

	document.getElementById('ShippingState').value = document.getElementById('BillingState').value;

	document.getElementById('ShippingZip').value = document.getElementById('BillingZip').value;

	document.getElementById('ShippingPhone').value = document.getElementById('BillingPhone').value;

	document.getElementById('ShippingCountry').selectedIndex = document.getElementById('BillingCountry').selectedIndex;

}





function isEmail(email) {

	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

	if(!reg.test(email)) {

		return false;

	}else{

		return true;

	}

}



function isZip(zip) {

	//var reg = /(^\d{5}(-\d{4})?$)|(^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$)/;

	//if(!reg.test(zip)) {

	if(zip.length >= 10 || zip.length <= 0){

		return false;

	}else{

		return true;

	}

}



function isPhone(phone) {

	//var reg = /^\(?([2-9][0-8][0-9])\)?[-. ]?([2-9][0-9]{2})[-. ]?([0-9]{4})$/;

	//if(!reg.test(phone)) {

	if(phone.length < 7){

		return false;

	}else{

		return true;

	}

}



function isPassword(password) {

	var reg = /((?=^.{6,12}$))/;

	if(!reg.test(password)) {

		return false;

	}else{

		return true;

	}

}



function checksigninform(){

	var errors = 0;

	document.getElementById('SigninEmail').style.border = "solid 1px #CC0000";

	document.getElementById('SigninPassword').style.border = "solid 1px #CC0000";

	

	if(!isEmail(document.getElementById('SigninEmail').value)){

		document.getElementById('SigninEmail').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('SigninEmail').style.border = "solid 1px #666666";

	}

	

	if(!isPassword(document.getElementById('SigninPassword').value)){

		document.getElementById('SigninPassword').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('SigninPassword').style.border = "solid 1px #666666";

	}

	

	if(errors == 0){	

		document.forms["cart_signin_form"].submit();

	}else{

		document.getElementById('errortext2').style.display = "block";

	}

}



function check_billing_shipping_information(isguest){

	var errors = 0;

	//ERROR CHECK THE BILLING INFORMATION

	if(document.getElementById('BillingName').value.length == 0){

		document.getElementById('BillingName').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('BillingName').style.border = "solid 1px #666";

	}

	

	if(document.getElementById('BillingLastName').value.length == 0){

		document.getElementById('BillingLastName').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('BillingLastName').style.border = "solid 1px #666";

	}

	

	if(document.getElementById('BillingAddress').value.length == 0){

		document.getElementById('BillingAddress').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('BillingAddress').style.border = "solid 1px #666";

	}

	

	if(document.getElementById('BillingCity').value.length == 0){

		document.getElementById('BillingCity').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('BillingCity').style.border = "solid 1px #666";

	}

	

	if(document.getElementById('BillingState').value.length == 0 || document.getElementById('BillingState').value == 0){

		document.getElementById('BillingState').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('BillingState').style.border = "solid 1px #666";

	}

	

	if(!isZip(document.getElementById('BillingZip').value)){

		document.getElementById('BillingZip').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('BillingZip').style.border = "solid 1px #666";

	}

	

	if(!isPhone(document.getElementById('BillingPhone').value)){

		document.getElementById('BillingPhone').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('BillingPhone').style.border = "solid 1px #666";

	}
	
	if(document.getElementById('BillingCountry').value.length == 0 || document.getElementById('BillingCountry').value == 0){

		document.getElementById('BillingCountry').style.border = "solid 1px #CC0000";

		errors++;

	}else{

		document.getElementById('BillingCountry').style.border = "solid 1px #666";

	}

	

	//IF WE ARE NOT USING BILLING FOR SHIPPING, CHECK SHIPPING INFORMATION

	if(document.getElementById('UseShippingForShipping').checked){

		if(document.getElementById('ShippingName').value.length == 0){

			document.getElementById('ShippingName').style.border = "solid 1px #CC0000";

			errors++;

		}else{

			document.getElementById('ShippingName').style.border = "solid 1px #666";

		}

		

		if(document.getElementById('ShippingLastName').value.length == 0){

			document.getElementById('ShippingLastName').style.border = "solid 1px #CC0000";

			errors++;

		}else{

			document.getElementById('ShippingLastName').style.border = "solid 1px #666";

		}

		

		if(document.getElementById('ShippingAddress').value.length == 0){

			document.getElementById('ShippingAddress').style.border = "solid 1px #CC0000";

			errors++;

		}else{

			document.getElementById('ShippingAddress').style.border = "solid 1px #666";

		}

		

		if(document.getElementById('ShippingCity').value.length == 0){

			document.getElementById('ShippingCity').style.border = "solid 1px #CC0000";

			errors++;

		}else{

			document.getElementById('ShippingCity').style.border = "solid 1px #666";

		}

		

		if(document.getElementById('ShippingState').value.length == 0 || document.getElementById('ShippingState').value == 0){

			document.getElementById('ShippingState').style.border = "solid 1px #CC0000";

			errors++;

		}else{

			document.getElementById('ShippingState').style.border = "solid 1px #666";

		}

		

		if(!isZip(document.getElementById('ShippingZip').value)){

			document.getElementById('ShippingZip').style.border = "solid 1px #CC0000";

			errors++;

		}else{

			document.getElementById('ShippingZip').style.border = "solid 1px #666";

		}

		

		if(!isPhone(document.getElementById('ShippingPhone').value)){

			document.getElementById('ShippingPhone').style.border = "solid 1px #CC0000";

			errors++;

		}else{

			document.getElementById('ShippingPhone').style.border = "solid 1px #666";

		}
		
		
		
		if(document.getElementById('ShippingCountry').value.length == 0 || document.getElementById('ShippingCountry').value == 0){

			document.getElementById('ShippingCountry').style.border = "solid 1px #CC0000";

			errors++;

		}else{

			document.getElementById('ShippingCountry').style.border = "solid 1px #666";

		}


	}

	

	if(document.getElementById('usedynamic').value == "1"){

		if(document.getElementById('shippingRate').value == "0"){

			document.getElementById('shippingRate').style.border = "solid 1px #CC0000";

			errors++;

		}else{

			document.getElementById('shippingRate').style.border = "solid 1px #666";

		}

	}

	

	

	if(errors == 0){

		return true;

	}else{

		document.getElementById('errortext').style.display = "block";

		document.getElementById('errortext2').style.display = "block";
		
		return false;

	}

}



function check_submit_form(isguest, grandtotal){

	var errors = 0;

	if(grandtotal > 0){

		if(document.getElementById('PaymentType').value == 1){
			
			//Skip cc validation for PayPal
			
		}else{

			var re_visa = new RegExp(/^4[0-9]{12}(?:[0-9]{3})?$/);
	
			var re_discover = new RegExp(/^6(?:011|5[0-9]{2})[0-9]{12}$/);
	
			var re_mastercard = new RegExp(/^5[1-5][0-9]{14}$/);
	
			var re_amex = new RegExp(/^(3[47][0-9]{13})*$/);
	
			var re_diners = new RegExp(/^(3(?:0[0-5]|[68][0-9])[0-9]{11})*$/);
	
			var re_jcb = new RegExp(/^(?:2131|1800|35\d{3})\d{11}$/);
	
			
	
			if(document.getElementById('PaymentType').value == 0){
	
				document.getElementById('PaymentTypeError').style.display = "block";
	
				errors++;
	
			}else{
	
				document.getElementById('PaymentTypeError').style.display = "none";
	
			}
	
			
	
			if( ( 	document.getElementById('PaymentType').value == 2 && !document.getElementById('CardNumber').value.match(re_visa) 		) || 
	
				(	document.getElementById('PaymentType').value == 3 && !document.getElementById('CardNumber').value.match(re_discover) 	) || 
	
				(	document.getElementById('PaymentType').value == 4 && !document.getElementById('CardNumber').value.match(re_mastercard)	) || 
	
				(	document.getElementById('PaymentType').value == 5 && !document.getElementById('CardNumber').value.match(re_amex)		) || 
	
				(	document.getElementById('PaymentType').value == 6 && !document.getElementById('CardNumber').value.match(re_diners)		) || 
	
				(	document.getElementById('PaymentType').value == 7 && !document.getElementById('CardNumber').value.match(re_jcb)			)
				
			){
	
					document.getElementById('CardNumber').style.border = "solid 1px #CC0000";
	
					errors++;
	
			}else{
	
				document.getElementById('CardNumber').style.border = "solid 1px #666666";
	
			}
	
			
	
			if(document.getElementById('SecurityNumber').value.length < 3){
	
				document.getElementById('SecurityNumber').style.border = "solid 1px #CC0000";
	
				errors++;
	
			}else{
	
				document.getElementById('SecurityNumber').style.border = "solid 1px #666666";
	
			}
	
		}
	
	}
		
	
	if(isguest){

		if(!isEmail(document.getElementById('EmailNew').value)){

			document.getElementById('EmailNew').style.border = "solid 1px #CC0000";

			errors++;

		}else{

			document.getElementById('EmailNew').style.border = "solid 1px #666666";

		}

		

		if(!isEmail(document.getElementById('EmailNewRetype').value)){

			document.getElementById('EmailNewRetype').style.border = "solid 1px #CC0000";

			errors++;

		}else{

			document.getElementById('EmailNewRetype').style.border = "solid 1px #666666";

		}

		

		if(document.getElementById('EmailNewRetype').value != document.getElementById('EmailNew').value){

			document.getElementById('EmailNewRetype').style.border = "solid 1px #CC0000";

			document.getElementById('EmailNew').style.border = "solid 1px #CC0000";

			errors++;

		}else{

			document.getElementById('EmailNewRetype').style.border = "solid 1px #CC0000";

			document.getElementById('EmailNew').style.border = "solid 1px #666666";

		}

			

		if(document.getElementById('CreateAccount').checked){

			if(!isPassword(document.getElementById('PasswordNew').value)){

				document.getElementById('PasswordNew').style.border = "solid 1px #CC0000";

				errors++;

			}else{

				document.getElementById('PasswordNew').style.border = "solid 1px #666666";

			}

			

			if(!isPassword(document.getElementById('RetypePasswordNew').value)){

				document.getElementById('RetypePasswordNew').style.border = "solid 1px #CC0000";

				errors++;

			}else{

				document.getElementById('RetypePasswordNew').style.border = "solid 1px #666666";

			}

			

			if(document.getElementById('RetypePasswordNew').value != document.getElementById('PasswordNew').value){

				document.getElementById('RetypePasswordNew').style.border = "solid 1px #CC0000";

				document.getElementById('PasswordNew').style.border = "solid 1px #CC0000";

				errors++;

			}else{

				document.getElementById('RetypePasswordNew').style.border = "solid 1px #666666";

				document.getElementById('PasswordNew').style.border = "solid 1px #666666";

			}

		}

	}
	
		
	
	if(!document.getElementById('AgreeTerms').checked){

		document.getElementById('AgreeToTermsError').style.display = "block";

		errors++;

	}else{

		document.getElementById('AgreeToTermsError').style.display = "none";

	}

	

	if(errors == 0){

		document.forms["order_form"].submit();

	}else{

		document.getElementById('errortext').style.display = "block";

		return false;

	}
	

}



function update_show_account_form(){

	if(document.getElementById('CreateAccount').checked){

		document.getElementById('new_account').style.display = "block";

	}else{

		document.getElementById('new_account').style.display = "none";

	}

}