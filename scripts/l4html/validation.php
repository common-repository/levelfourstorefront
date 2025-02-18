<?php

/**

* Validation Class

* v3.0

* Last Updated: Mar 28, 2011

*

* Changelog:

* v2 now works with PHP 5.3 and up

* v3 is easy to intergrate into CI as a library (renamed) + bug fixes

**/

class Validate {

  /**

  * If an email is Valid it returns the parameter

  * other wise it will return false 

  * $email is the email address

  **/

  function isEmail($email) {


    $email =  strtolower($email);

    //check if email seems valid

    if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)) {

      return $email;

    }

    return false;

  }

  /**

  * Checks if there are 7 or 10 numbers, if so returns cleaned parameter(no formating just numbers)

  * other wise it will return false 

  * $phone is the phone number

  * $ext if set to true return an array with extension separated

  **/

  function isPhone($phone, $ext = false) {

    //remove everything but numbers

    $numbers = preg_replace("%[^0-9]%", "", $phone );

    //how many numbers are supplied

    $length = strlen($numbers);

    if ( $length == 10 || $length == 7 ) { //Everything is find and dandy

      $cleanPhone = $numbers;

      if ( $ext ) {

        $clean['phone'] = $cleanPhone;

        return $clean;

      } else {

        return $cleanPhone;

      }

    } elseif ( $length > 10 ) { //must be extension

      //checks if first number is 1 (this may be a bug for you)

      if ( substr($numbers,0,1 ) == 1 ) {

        $clean['phone'] = substr($numbers,0,11);

        $clean['extension'] = substr($numbers,11);

      } else {

        $clean['phone'] = substr($numbers,0,10);

        $clean['extension'] = substr($numbers,10);

      }

      if (!$ext) { //return string

        if (!empty($clean['extension'])) {

          $clean = implode("x",$clean);

        } else {

          $clean = $clean['phone'];

        } 

        return $clean;

      } else { //return array

        return $clean;

      }

    } 

    return false;

  }

  /**

  * Canadian Postal code

  * thanks to: http://roshanbh.com.np/2008/03/canda-postal-code-validation-php.html

  **/

  function isPostalCode($postal) {

    //$regex = "/^([a-ceghj-npr-tv-z]){1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}$/i";

    //remove spaces

    //$postal = str_replace(' ', '', $postal);

    //if ( preg_match( $regex , $postal ) ) {

	if( count($postal) > 0 && count($postal) < 10){

      return $postal;

    } else {

      return false;

    }

  }

  /** 

  * Checks for a 5 digit zip code

  * Clears extra characters

  * returns clean zip

  **/

  function isZipCode($zip) {

    //remove everything but numbers

    //$numbers = preg_replace("[^0-9]", "", $zip );

    //how many numbers are supplied

    //$length = strlen($numbers);

    if( count($zip) > 0 && count($zip) < 10){

      return $zip;

    } else {

      return false;

    }
  }

  function isPassword($Password) {

	$pwd = $Password;

	if( strlen($pwd) < 6 ) {

		return false; //no less than 6 chars

	}else if( strlen($pwd) > 12 ) {

		return false; //no more than 12 chars

	}else {

		return true;

	}

  }

  function isMatch($Password1, $Password2){

	if($Password1 == $Password2){

		return true;

	}else{

		return false;

	}

  }

  function isFirstName($FirstName){

	  if(strlen($FirstName) > 0){

		  return true;

	  }else{

		  return false;

	  }

  }

  function isLastName($LastName){

	  if(strlen($LastName) > 0){

		  return true;

	  }else{

		  return false;

	  }

  }

  function isAddress($Address){

	  if(strlen($Address) > 0){

		  return true;

	  }else{

		  return false;

	  }

  }

  function isCity($City){

	  if(strlen($City) > 0){

		  return true;

	  }else{

		  return false;

	  }

  }

  function isState($State){

	  if($State != "0"){

		  return true;

	  }else{

		  return false;

	  }

  }

  function isCountry($Country){

	  if($Country != "0"){

		  return true;

	  }else{

		  return false;

	  }

  }

  function isVisa($CardNumber){

  	  if(!preg_match("/^4[0-9]{12}(?:[0-9]{3})?$/", $CardNumber)){

    	  return false;  
	
	  }else{

		  return true;

	  }

  }

  function isDiscover($CardNumber){

  	  if(!preg_match("/^6(?:011|5[0-9]{2})[0-9]{12}$/", $CardNumber)){

	      return false;  

	  }else{

		  return true;

	  }

  }

  function isMastercard($CardNumber){

  	  if(!preg_match("/^5[1-5][0-9]{14}$/", $CardNumber)){

	      return false;  

	  }else{

		  return true;

	  }

  }

  function isAmex($CardNumber){

  	  if(!preg_match("/^3[47][0-9]{13}$/", $CardNumber)){

	      return false;  

	  }else{

		  return true;

	  }
	  
  }

  function isDiners($CardNumber){

  	  if(!preg_match("/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/", $CardNumber)){

	      return false;  

	  }else{

		  return true;

	}

  }

 function isJcb($CardNumber){

  	  if(!preg_match("/^(?:2131|1800|35\d{3})\d{11}$/", $CardNumber)){

	      return false;

	  }else{

		  return true;

	  }

  }

  function isRealLocation($City, $State, $ZipCode){

		$address = array(

			'city' => $City,

			'state' => $State,

			'zip_code' => $ZipCode,

		); // end address

		$validation = new UpsAPI_USAddressValidation($address);

		$xml = $validation->buildRequest();

		// returns an array

		$response = $validation->sendRequest($xml, false);

		return $response;

  }

	function validated($code){

		return checklicense($code);	

	}

}

require_once("license.php");

/** End Validation **/
?>