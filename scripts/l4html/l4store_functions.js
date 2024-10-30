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

var storestartup = true;

var selectedOrder = 0;

function changesort(menuid, menu, submenu, subsubmenu, manufacturer, pricepoint, page, perpage, storeurl, divider){

	if(menu != ""){

		window.location = storeurl+divider+"menuid="+menuid+"&menu="+menu+"&manufacturer="+manufacturer+"&pricepoint="+pricepoint+"&pagenum="+page+"&perpage="+perpage+"&filternum="+document.getElementById('sortfield').value;

	}else if(submenu != ""){

		window.location = storeurl+divider+"submenuid="+menuid+"&submenu="+submenu+"&manufacturer="+manufacturer+"&pricepoint="+pricepoint+"&pagenum="+page+"&perpage="+perpage+"&filternum="+document.getElementById('sortfield').value;

	}else if(subsubmenu != ""){

		window.location = storeurl+divider+"subsubmenuid="+menuid+"&subsubmenu="+subsubmenu+"&manufacturer="+manufacturer+"&pricepoint="+pricepoint+"&pagenum="+page+"&perpage="+perpage+"&filternum="+document.getElementById('sortfield').value;

	}else{

		window.location = storeurl+divider+"manufacturer="+manufacturer+"&pricepoint="+pricepoint+"&pagenum="+page+"&perpage="+perpage+"&filternum="+document.getElementById('sortfield').value;

	}
	
}

function changesort2(menuid, menu, submenu, subsubmenu, manufacturer, pricepoint, page, perpage, storeurl, divider){

	if(menu != ""){

		window.location = storeurl+divider+"menuid="+menuid+"&menu="+menu+"&manufacturer="+manufacturer+"&pricepoint="+pricepoint+"&pagenum="+page+"&perpage="+perpage+"&filternum="+document.getElementById('sortfield2').value;

	}else if(submenu != ""){

		window.location = storeurl+divider+"submenuid="+menuid+"&submenu="+submenu+"&manufacturer="+manufacturer+"&pricepoint="+pricepoint+"&pagenum="+page+"&perpage="+perpage+"&filternum="+document.getElementById('sortfield2').value;

	}else if(subsubmenu != ""){

		window.location = storeurl+divider+"subsubmenuid="+menuid+"&subsubmenu="+subsubmenu+"&manufacturer="+manufacturer+"&pricepoint="+pricepoint+"&pagenum="+page+"&perpage="+perpage+"&filternum="+document.getElementById('sortfield2').value;

	}else{

		window.location = storeurl+divider+"manufacturer="+manufacturer+"&pricepoint="+pricepoint+"&pagenum="+page+"&perpage="+perpage+"&filternum="+document.getElementById('sortfield2').value;

	}
	
}

function submit_review(postURL, prodid){

	var score = 0;
	
	if(document.getElementById('review_1').checked){
		score = 1;
	}else if(document.getElementById('review_2').checked){
		score = 2;
	}else if(document.getElementById('review_3').checked){
		score = 3;
	}else if(document.getElementById('review_4').checked){
		score = 4;
	}else if(document.getElementById('review_5').checked){
		score = 5;
	}

	jQuery.post(postURL + "/l4store/product_details/submit_review.php", {productid : prodid, rating : score, reviewtitle : document.getElementById('review_title').value, reviewdescription : document.getElementById('review_description').value}, function(data){

		if (data.length>0){ 

			document.getElementById('product_review_container').style.display = "none";

			document.getElementById('review_success').style.display = "block";
			
			document.getElementById('review_1').checked = false;
			
			document.getElementById('review_2').checked = false;
			
			document.getElementById('review_3').checked = false;
			
			document.getElementById('review_4').checked = false;
			
			document.getElementById('review_5').checked = false;
			
			document.getElementById('review_title').value = "";

			document.getElementById('review_description').value = "";
			
		}else{

			document.getElementById('product_review_container').style.display = "none";

			document.getElementById('review_failed').style.display = "block";

		}

	})

}

function showreview(){

	document.getElementById('product_review_container').style.display = "block";

}

function hidereview(){

	document.getElementById('product_review_container').style.display = "none";

}

function process_coupon_code(){

	alert("process the coupon here");

}

function update_quantity(tempid){

	var opts = {

  		lines: 8, // The number of lines to draw

  		length: 7, // The length of each line

  		width: 4, // The line thickness

  		radius: 10, // The radius of the inner circle

  		color: '#000', // #rgb or #rrggbb

  		speed: 1, // Rounds per second

  		trail: 60, // Afterglow percentage

  		shadow: false, // Whether to render a shadow

  		hwaccel: false // Whether to use hardware acceleration

	};

	var target = document.getElementById('product_loader');

	while (target.hasChildNodes()) {

		target.removeChild(node.lastChild);

	}
	
	var spinner = new Spinner(opts).spin(target);

	$.post("../l4cartscripts/updatecartitem.php", {Quantity: document.getElementById('Quantity_'+tempid).value, tempcartid : tempid, jquery_version : "yes"}, function(data){

		get_cart();

	})

}

function delete_cart_item(tempid){

	var opts = {

  		lines: 8, // The number of lines to draw

  		length: 7, // The length of each line

  		width: 4, // The line thickness

  		radius: 10, // The radius of the inner circle

  		color: '#000', // #rgb or #rrggbb

  		speed: 1, // Rounds per second

  		trail: 60, // Afterglow percentage

  		shadow: false, // Whether to render a shadow

  		hwaccel: false // Whether to use hardware acceleration

	};

	var target = document.getElementById('product_loader');

	while (target.hasChildNodes()) {

		target.removeChild(node.lastChild);

	}

	var spinner = new Spinner(opts).spin(target);

	$.post("../l4cartscripts/removecartitem.php", {tempcartid : tempid}, function(data){

		spinner.stop();

		get_cart();

	})

}

function get_cart(){

	$.post("cart/cart.php", {}, function(data){

		if (data.length>0){

			$("#cart").html(data); 

		}else{

			$("#cart").html("Error Retrieving Cart...");

		}

	})

}

function updateshippingtotal(expressprice, subtotal, expeditedshipprice, shippingprice){

	if(document.getElementById('ShipExpress').checked == true){

		var shippingp = subtotal;

		var expediteshippingp = expeditedshipprice;

		var price = shippingp + expediteshippingp;

		price = price.toFixed(2);

	}else{

		var price = Number(shippingprice).toFixed(2);

	}

	document.getElementById('shippingtotal').innerHTML = "$" + numberWithCommas(price);

	document.getElementById('shipping').value = price;

	setgrandtotal();

}

function updatediscounts(coupondiscount){    

	var totaloff = "0";

	var subtotal = document.getElementById('subtotal').value;

	var shippingPrice = document.getElementById('shipping').value;

	var discount = (roundNumber(subtotal*totaloff/100, 2) + coupondiscount).toFixed(2);

	if(discount > ( Number(subtotal) + Number(shippingPrice) ) ){

		discount = ( Number(subtotal) + Number(shippingPrice) ).toFixed(2);

	}

	var discountpercent = Number(discount) / Number(subtotal) * 100;

	document.getElementById('totaldiscounts').innerHTML = "$"+numberWithCommas(discount);

	document.getElementById('discounts').value = discount;

	setgrandtotal();

}

function loadNewPage(temp) {

	var req = new XMLHttpRequest();

	req.open("GET", temp, false);

	req.send(null);

	var page = req.responseText;

	document.getElementById("maincontent").innerHTML = page;

};

var originalprice = 0;

function setoriginalprice(price) {

  originalprice = Number(price);	

}

function checkaddtocartform(opt1, opt2, opt3, opt4, opt5, stock){
	
	var errors = 0;
	
	//check to see if there is an option 1
	if(opt1 > 0){
		
		//check to see if option 1 has been selected, if not, then we need to access the error
		if(document.getElementById('option1').value == "0" || document.getElementById('option1').value == ""){
			
			//check to see if it is a drop down
			if(document.getElementById('option1dd') ){
				
				document.getElementById('option1dd').className = "productoptionerror";
			
				document.getElementById('option1error').style.display = "block";

				errors++;
			
			//is a swatch
			}else{
			
				document.getElementById('option1error').style.display = "block";
				
				errors++;
			
			}
		
		//no error, remove error displays
		}else{
			
			//check if drop down, remove error
			if(document.getElementById('option1dd') ){
				
				document.getElementById('option1dd').className = "productoptioncorrect";
			
				document.getElementById('option1error').style.display = "none";
				
			}else{ 
			
				//this is a swatch
			
				document.getElementById('option1error').style.display = "none";
				
			}
			
		}

	}

	//check to see if there is an option 2
	if(opt2 > 0){
		
		//check to see if option 2 has been selected, if not, then we need to access the error
		if(document.getElementById('option2').value == "0" || document.getElementById('option2').value == ""){
			
			//check to see if it is a drop down
			if(document.getElementById('option2dd') ){
				
				document.getElementById('option2dd').className = "productoptionerror";
			
				document.getElementById('option2error').style.display = "block";

				errors++;
			
			//is a swatch
			}else{
			
				document.getElementById('option2error').style.display = "block";
				
				errors++;
			
			}
		
		//no error, remove error displays
		}else{
			
			//check if drop down, remove error
			if(document.getElementById('option2dd') ){
				
				document.getElementById('option2dd').className = "productoptioncorrect";
			
				document.getElementById('option2error').style.display = "none";
				
			}else{ 
			
				//this is a swatch
			
				document.getElementById('option2error').style.display = "none";
				
			}
			
		}

	}

	//check to see if there is an option 3
	if(opt3 > 0){
		
		//check to see if option 3 has been selected, if not, then we need to access the error
		if(document.getElementById('option3').value == "0" || document.getElementById('option3').value == ""){
			
			//check to see if it is a drop down
			if(document.getElementById('option3dd') ){
				
				document.getElementById('option3dd').className = "productoptionerror";
			
				document.getElementById('option3error').style.display = "block";

				errors++;
			
			//is a swatch
			}else{
			
				document.getElementById('option3error').style.display = "block";
				
				errors++;
			
			}
		
		//no error, remove error displays
		}else{
			
			//check if drop down, remove error
			if(document.getElementById('option3dd') ){
				
				document.getElementById('option3dd').className = "productoptioncorrect";
			
				document.getElementById('option3error').style.display = "none";
				
			}else{ 
			
				//this is a swatch
			
				document.getElementById('option3error').style.display = "none";
				
			}
			
		}

	}

	//check to see if there is an option 4
	if(opt4 > 0){
		
		//check to see if option 4 has been selected, if not, then we need to access the error
		if(document.getElementById('option4').value == "0" || document.getElementById('option4').value == ""){
			
			//check to see if it is a drop down
			if(document.getElementById('option4dd') ){
				
				document.getElementById('option4dd').className = "productoptionerror";
			
				document.getElementById('option4error').style.display = "block";

				errors++;
			
			//is a swatch
			}else{
			
				document.getElementById('option4error').style.display = "block";
				
				errors++;
			
			}
		
		//no error, remove error displays
		}else{
			
			//check if drop down, remove error
			if(document.getElementById('option4dd') ){
				
				document.getElementById('option4dd').className = "productoptioncorrect";
			
				document.getElementById('option4error').style.display = "none";
				
			}else{ 
			
				//this is a swatch
			
				document.getElementById('option4error').style.display = "none";
				
			}
			
		}

	}

	//check to see if there is an option 5
	if(opt5 > 0){
		
		//check to see if option 5 has been selected, if not, then we need to access the error
		if(document.getElementById('option5').value == "0" || document.getElementById('option5').value == ""){
			
			//check to see if it is a drop down
			if(document.getElementById('option5dd') ){
				
				document.getElementById('option5dd').className = "productoptionerror";
			
				document.getElementById('option5error').style.display = "block";

				errors++;
			
			//is a swatch
			}else{
			
				document.getElementById('option5error').style.display = "block";
				
				errors++;
			
			}
		
		//no error, remove error displays
		}else{
			
			//check if drop down, remove error
			if(document.getElementById('option5dd') ){
				
				document.getElementById('option5dd').className = "productoptioncorrect";
			
				document.getElementById('option5error').style.display = "none";
				
			}else{ 
			
				//this is a swatch
			
				document.getElementById('option5error').style.display = "none";
				
			}
			
		}

	}

	if(isNaN(document.getElementById('Quantity').value) || document.getElementById('Quantity').value < 1 || Number(document.getElementById('instock_quantity').innerHTML.split("In Stock: ")[1]) < document.getElementById('Quantity').value){

		document.getElementById('instock_quantity').style.color = "#00a8ff";
		
		document.getElementById('Quantity').style.border = "1px solid #FF0000";

		errors++;

	}else{

		document.getElementById('instock_quantity').style.color = "#999999";
		
		document.getElementById('Quantity').style.border = "none";

	}

	if(document.getElementById('isGiftCard').value == "1"){

		if(document.getElementById('textmessage').value.length == 0){

			document.getElementById('textmessage').className = "giftcarderrorfield";

			errors++;

		}else{

			document.getElementById('textmessage').className = "giftcard_textfield";

		}

		if(document.getElementById('toname').value.length == 0){

			document.getElementById('toname').className = "giftcarderrorfield";

			errors++;

		}else{

			document.getElementById('toname').className = "giftcard_textfield";

		}

		if(document.getElementById('fromname').value.length == 0){

			document.getElementById('fromname').className = "giftcarderrorfield";

			errors++;

		}else{

			document.getElementById('fromname').className = "giftcard_textfield";

		}

		if(document.getElementById('deliverymethod').selectedIndex == 0){

			document.getElementById('deliverymethod').className = "giftcarderrorfield";

			errors++;

		}else{

			document.getElementById('deliverymethod').className = "giftcard_textfield";

		}

	}
	
	if(errors == 0){	

		document.forms["addtocartform"].submit();

	}else{

	}

}

function optionchange(optnum){
	
	//Create Array for option combos
	var optddval = Array();
	
	//Depending on which combo was selected, create array of all options selected so far.
	if(optnum == 1){
		
		if(document.getElementById('option1dd')){
			optddval[0] = document.getElementById('option1dd').value;
		}else{
			optddval[0] = myoptionitems[optnum][0][1] + "+=+" + myoptionitems[optnum][0][0] + "+=+" + currentlevel1 + "+=+" + myoptionitems[optnum][0][3] + "+=+" + myoptionitems[optnum][0][2];
		}
		
	}else if(optnum == 2){
		
		optddval[0] = document.getElementById('option1dd').value;
		optddval[1] = document.getElementById('option2dd').value;
	
	}else if(optnum == 3){
	
		optddval[0] = document.getElementById('option1dd').value;
		optddval[1] = document.getElementById('option2dd').value;
		optddval[2] = document.getElementById('option3dd').value;
	
	}else if(optnum == 4){
	
		optddval[0] = document.getElementById('option1dd').value;
		optddval[1] = document.getElementById('option2dd').value;
		optddval[2] = document.getElementById('option3dd').value;
		optddval[3] = document.getElementById('option4dd').value;
	
	}else if(optnum == 5){
	
		optddval[0] = document.getElementById('option1dd').value;
		optddval[1] = document.getElementById('option2dd').value;
		optddval[2] = document.getElementById('option3dd').value;
		optddval[3] = document.getElementById('option4dd').value;
		optddval[4] = document.getElementById('option5dd').value;
	
	}
	
	//Create var for option price values
	var optiontotal = 0;
	
	//Loop through and make sub arrays from each selected item
	for(i=0;i<optddval.length;i++){
		var temparr = new Array();
		temparr = optddval[i].split("+=+");
		optddval[i] = new Array();
		optddval[i] = temparr;
		
		//Update the price change values, create the option total
		document.getElementById("option" + (i+1) + "pricechange").value = Number(optddval[i][4]);
		optiontotal = optiontotal + Number(optddval[i][4]);
		
	}
	
	//If we actually have values (didn't select the first option, and selected a real value).
	if(optddval[optnum-1].length > 1){
		
		//set the selected option id to the option hidden field
		document.getElementById('option'+optnum).value = optddval[optnum-1][1];

		//Get some values
		var originalprice = document.getElementById('origprice').value;
		var listprice = document.getElementById('ListPrice').value;
		var newtotal = Number(originalprice) + Number(optiontotal);
		var newlistprice = Number(listprice) + Number(optiontotal);

		//Update the total
		document.getElementById('currprice').value = newtotal.toFixed(2);
	
		//If there is a list price, then we need to update the text differently
		if(listprice != "0.00"){
			document.getElementById('currentprice').innerHTML = document.getElementById('CurrencySymbol').value + newtotal.toFixed(2) + " <span class=\"listprice_text\">" + document.getElementById('CurrencySymbol').value + newlistprice.toFixed(2) + "</span>";
		}else{
			document.getElementById('currentprice').innerHTML = document.getElementById('CurrencySymbol').value + newtotal.toFixed(2);
		}
		
		//Update Stock Text
		if(optnum == 1){
			document.getElementById('instock_quantity').innerHTML = "In Stock: " + myoptionitems[Number(optddval[0][2])][0][3];
			
			if(document.getElementById('option2dd')){
			
				document.getElementById('option2dd').disabled = "";
			
			}
			
		}else if(optnum == 2){
			document.getElementById('instock_quantity').innerHTML = "In Stock: " + myoptionitems[Number(optddval[0][2])][1][Number(optddval[1][2])][0][3];
			
			if(document.getElementById('option3dd')){
			
				document.getElementById('option3dd').disabled = "";
			
			}
			
		}else if(optnum == 3){
			document.getElementById('instock_quantity').innerHTML = "In Stock: " + myoptionitems[Number(optddval[0][2])][1][Number(optddval[1][2])][1][Number(optddval[2][2])][0][3];
			
			if(document.getElementById('option4dd')){
			
				document.getElementById('option4dd').disabled = "";
			
			}
			
		}else if(optnum == 4){
			document.getElementById('instock_quantity').innerHTML = "In Stock: " + myoptionitems[Number(optddval[0][2])][1][Number(optddval[1][2])][1][Number(optddval[2][2])][1][Number(optddval[3][2])][0][3];
			
			if(document.getElementById('option5dd')){
			
				document.getElementById('option5dd').disabled = "";
			
			}
			
		}else if(optnum == 5){
			document.getElementById('instock_quantity').innerHTML = "In Stock: " + myoptionitems[Number(optddval[0][2])][1][Number(optddval[1][2])][1][Number(optddval[2][2])][1][Number(optddval[3][2])][1][Number(optddval[4][2])][0][3];
			
		}
		
		//Now Loop through and update all combos we haven't touched yet.
		for(var i=optnum+1; i<=5; i++){
			
			if(document.getElementById('option'+i+'dd')){
			
				//All combos left to work with should be set to the first value
				document.getElementById('option'+i+'dd').selectedIndex = 0;
				
				//If this combo is NOT the next combo to select, then disable it
				if(i>optnum+1){
					document.getElementById('option'+i+'dd').disabled = "disabled";
				
				//Otherwise we need to update possible options based on quantity
				}else{
					
					//Loop through each option
					for(var j=1; j<document.getElementById('option'+i+'dd').options.length; j++){
						
						//We need to look at a different quantity value depending on which combo we just selected
						if(i==2){
							//Show or hide the option depending on if quanity is available
							if(myoptionitems[optddval[0][2]][1][j-1][0][3] > 0){
								document.getElementById('option'+i+'dd').options[j].style.display = "block";
							}else{
								document.getElementById('option'+i+'dd').options[j].style.display = "none";
							}
						}else if(i==3){
							
							//Show or hide the option depending on if quanity is available
							if(myoptionitems[optddval[0][2]][1][optddval[1][2]][1][j-1][0][3] > 0){
								document.getElementById('option'+i+'dd').options[j].style.display = "block";
							}else{
								document.getElementById('option'+i+'dd').options[j].style.display = "none";
							}
						
						}else if(i==4){
							
							//Show or hide the option depending on if quanity is available
							if(myoptionitems[optddval[0][2]][1][optddval[1][2]][1][optddval[2][2]][1][j-1][0][3] > 0){
								document.getElementById('option'+i+'dd').options[j].style.display = "block";
							}else{
								document.getElementById('option'+i+'dd').options[j].style.display = "none";
							}
						
						}else if(i==5){
							
							//Show or hide the option depending on if quanity is available
							if(myoptionitems[optddval[0][2]][1][optddval[1][2]][1][optddval[2][2]][1][optddval[3][2]][1][j-1][0][3] > 0){
								document.getElementById('option'+i+'dd').options[j].style.display = "block";
							}else{
								document.getElementById('option'+i+'dd').options[j].style.display = "none";
							}
						
						}
					}
				}
			}
		}
	
	//This option is used if first item selected
	}else{
		
		//Get some values
		var originalprice = Number(document.getElementById('origprice').value);
		var listprice = Number(document.getElementById('ListPrice').value);
		
		//If a list price is used
		if(listprice != "0.00"){
			document.getElementById('currentprice').innerHTML = document.getElementById('CurrencySymbol').value + originalprice.toFixed(2) + " <span class=\"listprice_text\">" + document.getElementById('CurrencySymbol').value + listprice.toFixed(2) + "</span>";
			
		//No list price used
		}else{
			document.getElementById('currentprice').innerHTML = document.getElementById('CurrencySymbol').value + originalprice.toFixed(2);
		
		}
		
		//Reset combo boxes past the current combo that was reset.
		if(optnum == 1){
			
			document.getElementById('instock_quantity').innerHTML = "In Stock: " + document.getElementById('totalquantity').value;
			
			if(document.getElementById('option2dd')){
			
				document.getElementById('option2dd').selectedIndex = 0;
			
				document.getElementById('option2dd').disabled = "disabled";
			
			}else{
				
				shownoswatches(2);
					
			}
			
			if(document.getElementById('option3dd')){
			
				document.getElementById('option3dd').selectedIndex = 0;
				
				document.getElementById('option3dd').disabled = "disabled";
			
			}else{
				
				shownoswatches(3);
					
			}
			
			if(document.getElementById('option4dd')){
			
				document.getElementById('option4dd').selectedIndex = 0;
			
				document.getElementById('option4dd').disabled = "disabled";
				
			}else{
				
				shownoswatches(4);
					
			}
			
			if(document.getElementById('option5dd')){
			
				document.getElementById('option5dd').selectedIndex = 0;
			
				document.getElementById('option5dd').disabled = "disabled";
			
			}else{
				
				shownoswatches(5);
					
			}
		
		}else if(optnum == 2){
			
			document.getElementById('instock_quantity').innerHTML = "In Stock: " + myoptionitems[optddval[0][2]][0][3];
			
			if(document.getElementById('option3dd')){
			
				document.getElementById('option3dd').selectedIndex = 0;
				
				document.getElementById('option3dd').disabled = "disabled";
			
			}else{
				
				shownoswatches(3);
					
			}
			
			if(document.getElementById('option4dd')){
			
				document.getElementById('option4dd').selectedIndex = 0;
			
				document.getElementById('option4dd').disabled = "disabled";
				
			}else{
				
				shownoswatches(4);
					
			}
			
			if(document.getElementById('option5dd')){
			
				document.getElementById('option5dd').selectedIndex = 0;
			
				document.getElementById('option5dd').disabled = "disabled";
			
			}else{
				
				shownoswatches(5);
					
			}
			
		}else if(optnum == 3){
			
			document.getElementById('instock_quantity').innerHTML = "In Stock: " + myoptionitems[optddval[0][2]][1][optddval[1][2]][0][3];
			
			if(document.getElementById('option4dd')){
			
				document.getElementById('option4dd').selectedIndex = 0;
			
				document.getElementById('option4dd').disabled = "disabled";
				
			}else{
				
				shownoswatches(4);
					
			}
			
			if(document.getElementById('option5dd')){
			
				document.getElementById('option5dd').selectedIndex = 0;
			
				document.getElementById('option5dd').disabled = "disabled";
			
			}else{
				
				shownoswatches(5);
					
			}
			
		}else if(optnum == 4){
			
			document.getElementById('instock_quantity').innerHTML = "In Stock: " + myoptionitems[optddval[0][2]][1][optddval[1][2]][1][optddval[2][2]][0][3];
			
			if(document.getElementById('option5dd')){
			
				document.getElementById('option5dd').selectedIndex = 0;
			
				document.getElementById('option5dd').disabled = "disabled";
			
			}else{
				
				shownoswatches(5);
					
			}
			
		}else if(optnum == 5){
			
			document.getElementById('instock_quantity').innerHTML = "In Stock: " + myoptionitems[optddval[0][2]][1][optddval[1][2]][1][optddval[2][2]][1][optddval[3][2]][0][3];
			
		}

	}
	
	swapproductimages(optddval[optnum-1][0], optddval[optnum-1][1], optddval[optnum-1][2], optddval[optnum-1][3], optnum);
	
}

function validateoptions() {

if(document.getElementById("option1") != undefined && document.paypal.option1.value == 'false') {

	alert("Please select all of the options before adding this item to your shopping cart.");

}else  if(document.getElementById("option2") != undefined && document.paypal.option2.value == 'false') {

	alert("Please select all of the options before adding this item to your shopping cart.");

} else  if(document.getElementById("option3") != undefined && document.paypal.option3.value == 'false') {

	alert("Please select all of the options before adding this item to your shopping cart.");	   

} else  if(document.getElementById("option4") != undefined && document.paypal.option4.value == 'false') {

	alert("Please select all of the options before adding this item to your shopping cart.");		

} else  if(document.getElementById("option5") != undefined && document.paypal.option5.value == 'false') {

	alert("Please select all of the options before adding this item to your shopping cart.");

} else {

	 document.paypal.submit();

}

}

function formatCurrency(num) {

  num = num.toString().replace(/\$|\,/g,'');

  if(isNaN(num))

  num = "0";

  sign = (num == (num = Math.abs(num)));

  num = Math.floor(num*100+0.50000000001);

  cents = num%100;

  num = Math.floor(num/100).toString();

  if(cents<10)

  cents = "0" + cents;

  for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)

  num = num.substring(0,num.length-(4*i+3))+','+

  num.substring(num.length-(4*i+3));

  return (((sign)?'':'-') +  num + '.' + cents);

}

function numberWithCommas(x) {

    x = x.toString();

    var pattern = /(-?\d+)(\d{3})/;

    while (pattern.test(x))

        x = x.replace(pattern, "$1,$2");

    return x;

}

function startupfunc(){

	updatetaxtotal();

	updatediscounts();

}

function roundNumber(num, dec) {

	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);

	return result;

}

function setgrandtotal(){

	var subtotal = Number(document.getElementById('subtotal').value);

	var discount = Number(document.getElementById('discounts').value);

	var tax = Number(document.getElementById('tax').value);

	var shipping = Number(document.getElementById('shipping').value);

	var gt = subtotal + tax + shipping - discount;

	document.getElementById('grandtotal').innerHTML = "$" + numberWithCommas(gt.toFixed(2));

	document.getElementById('total').value = gt.toFixed(2);

}

function updatetaxtotal(){

	if(document.getElementById('taxtype').value == "1"){

		if(document.getElementById('BillingState').value.toUpperCase() == document.getElementById('taxid').value){

			document.getElementById('taxtotal').style.display = "block";

			document.getElementById('notax').style.display = "none";

			document.getElementById('tax').value = totaldiscountvalue;

		}else{

			document.getElementById('taxtotal').style.display = "none";

			document.getElementById('notax').style.display = "block";

			document.getElementById('tax').value = 0;

		}

	}else if(document.getElementById('taxtype').value == "2"){

	}else if(document.getElementById('taxtype').value == "3"){

		document.getElementById('taxtotal').style.display = "block";

		document.getElementById('notax').style.display = "none";

		document.getElementById('tax').value = totaldiscountvalue;

	}else{

		document.getElementById('taxtotal').style.display = "none";

		document.getElementById('notax').style.display = "block";

		document.getElementById('tax').value = 0;

	}

	setgrandtotal();

}

function update_use_billing(){

	document.getElementById('shipping_form').style.display = "none";

}

function update_use_shipping(){

	document.getElementById('shipping_form').style.display = "block";

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

function clearship(){

	document.getElementById('ShippingName').value = "";

	document.getElementById('ShippingLastName').value = "";

	document.getElementById('ShippingAddress').value = "";

	document.getElementById('ShippingCity').value = "";

	document.getElementById('ShippingState').value = "";

	document.getElementById('ShippingZip').value = "";

	document.getElementById('ShippingPhone').value = "";

	document.getElementById('ShippingCountry').selectedIndex = "";

}

function checkupdateemailform(){

	var errors = 0;

	if(document.getElementById('EmailAddress').value.length == 0){

		document.getElementById('EmailAddress').className = "errorfield";

		errors++;

	}else{

		document.getElementById('EmailAddress').className = "correctfield";

	}

	if(document.getElementById('PasswordOld').value.length == 0){

		document.getElementById('PasswordOld').className = "errorfield";

		errors++;

	}else{

		document.getElementById('PasswordOld').className = "correctfield";

	}

	if(document.getElementById('PasswordNew').value.length != 0 && document.getElementById('PasswordNew').value != document.getElementById('PasswordNew2').value){

		document.getElementById('PasswordNew').className = "errorfield";

		document.getElementById('PasswordNew2').className = "errorfield";

		errors++;
		
	}else{

		document.getElementById('PasswordNew').className = "correctfield";

		document.getElementById('PasswordNew2').className = "correctfield";

	}

	if(errors == 0){	

		document.forms["updateemailform"].submit();

	}else{

		document.getElementById('errortext').style.display = "block";

	}

}

function checkretrievepasswordform(){

	var errors = 0;

	if(document.getElementById('EmailAddress').value.length == 0){

		document.getElementById('EmailAddress').className = "errorfield";

		errors++;

	}else{

		document.getElementById('EmailAddress').className = "correctfield";

	}

	if(errors == 0){	

		document.forms["retrievepasswordform"].submit();

	}else{

		document.getElementById('errortext').style.display = "block";

	}

}

function cancelchanges(pageid){

	window.location = "?page_id="+pageid;

}

function retrievepassword(pageid){

	window.location = "?page_id=" + pageid + "&page=retrievepassword";

}

function checkcheckoutform(){

	var errors = 0;

	if(document.getElementById('BillingPhone').value.length == 0 || isNaN(document.getElementById('BillingPhone').value)){

		document.getElementById('BillingPhone').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingPhone').className = "correctfield";

	}

	if(document.getElementById('ShippingPhone').value.length == 0 || isNaN(document.getElementById('ShippingPhone').value)){

		document.getElementById('ShippingPhone').className = "errorfield";

		errors++;

	}else{

		document.getElementById('ShippingPhone').className = "correctfield";

	}

	if(document.getElementById('BillingName').value.length == 0){

		document.getElementById('BillingName').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingName').className = "correctfield";

	}

	if(document.getElementById('BillingLastName').value.length == 0){

		document.getElementById('BillingLastName').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingLastName').className = "correctfield";

	}

	if(document.getElementById('ShippingName').value.length == 0){

		document.getElementById('ShippingName').className = "errorfield";

		errors++;

	}else{

		document.getElementById('ShippingName').className = "correctfield";

	}

	if(document.getElementById('ShippingLastName').value.length == 0){

		document.getElementById('ShippingLastName').className = "errorfield";
		
		errors++;

	}else{

		document.getElementById('ShippingLastName').className = "correctfield";

	}

	if(document.getElementById('BillingAddress').value.length == 0){

		document.getElementById('BillingAddress').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingAddress').className = "correctfield";

	}

	if(document.getElementById('BillingCity').value.length == 0){

		document.getElementById('BillingCity').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingCity').className = "correctfield";

	}

	if(document.getElementById('BillingState').value.length == 0){

		document.getElementById('BillingState').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingState').className = "correctfield";

	}

	if(document.getElementById('BillingZip').value.length == 0){

		document.getElementById('BillingZip').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingZip').className = "correctfield";

	}

	if(document.getElementById('ShippingAddress').value.length == 0){

		document.getElementById('ShippingAddress').className = "errorfield";

		errors++;

	}else{

		document.getElementById('ShippingAddress').className = "correctfield";

	}

	if(document.getElementById('ShippingCity').value.length == 0){

		document.getElementById('ShippingCity').className = "errorfield";

		errors++;

	}else{

		document.getElementById('ShippingCity').className = "correctfield";

	}

	if(document.getElementById('ShippingState').value.length == 0){

		document.getElementById('ShippingState').className = "errorfield";

		errors++;

	}else{

		document.getElementById('ShippingState').className = "correctfield";

	}

	if(document.getElementById('ShippingZip').value.length == 0){

		document.getElementById('ShippingZip').className = "errorfield";

		errors++;

	}else{

		document.getElementById('ShippingZip').className = "correctfield";

	}

	if(errors == 0){

		checkrestofform();

	}else{

		document.getElementById('errortext').style.display = "block";

	}

}

function checkrestofform(){

	var errors = 0;

	if(document.getElementById('PaymentType').selectedIndex == 5){

		//do not process cc stuff

	}else{

		if(document.getElementById('PaymentType').selectedIndex == 0){

			document.getElementById('PaymentType').className = "errorfield";

			errors++;

		}else{

			document.getElementById('PaymentType').className = "correctfield";

		}

		if( ( document.getElementById('CardNumber').value.substring(0,4) != "XXXX" || document.getElementById('CardNumber').value.length != 8) && (document.getElementById('CardNumber').value.length == 0 || isNaN(document.getElementById('CardNumber').value))){

			document.getElementById('CardNumber').className = "errorfield";

			errors++;

		}else{

			document.getElementById('CardNumber').className = "correctfield";
			
		}

		if(document.getElementById('ExpirationDate').value != "XXXX" && document.getElementById('ExpirationDate').value.length != 7){

			document.getElementById('ExpirationDate').className = "errorfield";

			errors++;

		}else{

			document.getElementById('ExpirationDate').className = "correctfield";

		}

		if(document.getElementById('SecurityNumber').value.length != 3 && document.getElementById('SecurityNumber').value.length != 4){

			document.getElementById('SecurityNumber').className = "errorfield";

			errors++;

		}else{

			document.getElementById('SecurityNumber').className = "correctfield";

		}

	}

	if(document.getElementById('AgreeTerms').checked == false){

		document.getElementById('accepttermserror').style.display = "block";

		errors++;

	}else{

		document.getElementById('accepttermserror').style.display = "none";

	}


	if(errors == 0){

		document.forms["form3"].submit();	

	}else{

		document.getElementById('errortext').style.display = "block";

	}

}

function copybilltoship_accountinfo(){

	document.getElementById('ShippingFirstName2').value = document.getElementById('BillingFirstName2').value;

	document.getElementById('ShippingLastName2').value = document.getElementById('BillingLastName2').value;

	document.getElementById('ShippingAddress2').value = document.getElementById('BillingAddress2').value;

	document.getElementById('ShippingCity2').value = document.getElementById('BillingCity2').value;

	document.getElementById('ShippingState2').value = document.getElementById('BillingState2').value;

	document.getElementById('ShippingZip2').value = document.getElementById('BillingZip2').value;

	document.getElementById('ShippingPhone2').value = document.getElementById('BillingPhone2').value;

	document.getElementById('ShippingCountry2').selectedIndex = document.getElementById('BillingCountry2').selectedIndex;

}

function checkupdateaccountinfoform(){

	var errors = 0;

	if(document.getElementById('BillingPhone2').value.length == 0){

		document.getElementById('BillingPhone2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingPhone2').className = "correctfield";

	}

	if(document.getElementById('ShippingPhone2').value.length == 0){

		document.getElementById('ShippingPhone2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('ShippingPhone2').className = "correctfield";

	}

	if(document.getElementById('BillingFirstName2').value.length == 0){

		document.getElementById('BillingFirstName2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingFirstName2').className = "correctfield";

	}

	if(document.getElementById('BillingLastName2').value.length == 0){

		document.getElementById('BillingLastName2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingLastName2').className = "correctfield";

	}

	if(document.getElementById('ShippingFirstName2').value.length == 0){

		document.getElementById('ShippingFirstName2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('ShippingFirstName2').className = "correctfield";

	}

	if(document.getElementById('ShippingLastName2').value.length == 0){

		document.getElementById('ShippingLastName2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('ShippingLastName2').className = "correctfield";

	}

	if(document.getElementById('BillingAddress2').value.length == 0){

		document.getElementById('BillingAddress2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingAddress2').className = "correctfield";

	}

	if(document.getElementById('BillingCity2').value.length == 0){

		document.getElementById('BillingCity2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingCity2').className = "correctfield";

	}

	if(document.getElementById('BillingState2').value.length == 0){

		document.getElementById('BillingState2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingState2').className = "correctfield";

	}

	if(document.getElementById('BillingZip2').value.length == 0){

		document.getElementById('BillingZip2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('BillingZip2').className = "correctfield";

	}

	if(document.getElementById('ShippingAddress2').value.length == 0){

		document.getElementById('ShippingAddress2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('ShippingAddress2').className = "correctfield";

	}

	if(document.getElementById('ShippingCity2').value.length == 0){

		document.getElementById('ShippingCity2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('ShippingCity2').className = "correctfield";

	}

	if(document.getElementById('ShippingState2').value.length == 0){

		document.getElementById('ShippingState2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('ShippingState2').className = "correctfield";

	}

	if(document.getElementById('ShippingZip2').value.length == 0){

		document.getElementById('ShippingZip2').className = "errorfield";

		errors++;

	}else{

		document.getElementById('ShippingZip2').className = "correctfield";

	}

	if(errors == 0){

		document.forms["updateaccountinfoform"].submit();

	}else{

		document.getElementById('errortext').style.display = "block";

	}

}

function closedetails(pageid){

	window.location = "?page_id=" + pageid + "page=pastorders";

}

function submitsignout(){

	document.forms["logoutuserform"].submit();

}

function isPhone(phonenum){

	if(phonenum.length == 0 || isNaN(phonenum)){

		return false;

	}else{

		return true;
		
	}

}

function checkloginform(){

	var errors = 0;

	if(document.getElementById('SigninEmail').value.length == 0){

		document.getElementById('SigninEmail').className = "errorfield";

		errors++;

	}else{

		document.getElementById('SigninEmail').className = "correctfield";

	}

	if(document.getElementById('SigninPassword').value.length == 0){

		document.getElementById('SigninPassword').className = "errorfield";

		errors++;

	}else{

		document.getElementById('SigninPassword').className = "correctfield";

	}

	if(errors == 0){	

		document.forms["loginform"].submit();

	}

}

function checknewaccountform(){

	var errors = 0;
	
	if(document.getElementById('EmailNew').value.length == 0){

		document.getElementById('EmailNew').className = "errorfield";

		errors++;

	}else{

		document.getElementById('EmailNew').className = "correctfield";

	}

	if(document.getElementById('PasswordNew').value.length == 0){

		document.getElementById('PasswordNew').className = "errorfield";

		errors++;

	}else{

		document.getElementById('PasswordNew').className = "correctfield";

	}

	if(document.getElementById('RetypePasswordNew').value.length == 0){

		document.getElementById('RetypePasswordNew').className = "errorfield";

		errors++;

	}else{

		document.getElementById('RetypePasswordNew').className = "correctfield";

	}

	if((document.getElementById('PasswordNew').value.length == 0 && document.getElementById('RetypePasswordNew').value.length == 0) || document.getElementById('RetypePasswordNew').value != document.getElementById('PasswordNew').value){

		document.getElementById('RetypePasswordNew').className = "errorfield";

		document.getElementById('PasswordNew').className = "errorfield";

		errors++;

	}else{

		document.getElementById('RetypePasswordNew').className = "correctfield";

		document.getElementById('PasswordNew').className = "correctfield";

	}

	if(errors == 0){	

		document.forms["newaccountform"].submit();

	}	
	
}