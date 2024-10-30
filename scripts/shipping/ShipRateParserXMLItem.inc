<?php

/*

 *

 * Copyright (c) Paid, Inc.  All rights reserved.

 *

 * $Id: ShipRateParserXMLItem.inc,v 1.3 2005/05/25 12:54:36 jmartin Exp $

 *

 * This program is part of the Paid Shipping Rate API toolkit for PHP and is responsible for parsing certain XML

 * elements that are returned by the rate engine.

 *

 */



class ShipRateParserXMLItem extends ShipRateParserXML

{

   var $_rate_cnt = 0;

   var $debug = false;



   /**

    * Default Constructor

    * @access public

    */

   function ShipRateParserXMLItem()

   {

      parent::ShipRateParserXML();

   }



   ### --------------------------------------------------------------------

   ### XML Parser Functions

   ### --------------------------------------------------------------------



   /**

    * Handle start element

    *

    * @access private

    * @param  resource  xml parser resource

    * @param  string    name of the element

    * @param  array     attributes

    */

   function startHandler($xp, $name, $attribs)

   {

      $this->_current_tag = $name;

      $attribs = array_change_key_case($attribs,CASE_LOWER);



      if ($this->debug) echo " + startHandler() : $name<br>";



      switch ($name) {

         case 'ItemShipRate': $this->dom = array();

                              break;

         case 'ShipRateList': xml_set_character_data_handler($this->parser,'cdataHandler_ShipRate');

                              $this->dom['ShipRate'] = array();

                              break;

         case 'ShipRate':     $this->dom['ShipRate'][$this->_rate_cnt] = array();

                              break;

         default:             parent::startHandler($xp, $name, $attribs);

      }

   }



   /**

    * Handle end element

    *

    * @access private

    * @param  resource  xml parser resource

    * @param  string    name of the element

    */

   function endHandler($xp, $name)

   {

      $this->_current_tag = null; // <<<<< WATCH THIS, cdataHandlers called 3 times: tag space and \n

      if ($this->debug) echo " + endHandler() : $name<br>";



      switch ($name) {

         case 'ItemShipRate': xml_set_character_data_handler($this->parser,'cdataHandler');

                              break;

         case 'ShipRateList': xml_set_character_data_handler($this->parser,'cdataHandler');

                              break;

         case 'ShipRate':     $this->_rate_cnt++;

                              break;

         default:             parent::endHandler($xp, $name);

      }

   }

   

   //////////////////////////////////////////////////////////////////////////

   // Custom CDATA Handlers

   //////////////////////////////////////////////////////////////////////////



   /**

    * Handle character data within ORIGINATION element

    * 

    * @access private

    * @param  resource  xml parser resource

    * @param  string    value of the resource

    */

   function cdataHandler_ShipRate($xp, $val)

   {

      static $map;

      if ($this->_err_state || empty($this->_current_tag)) return;

      if (!isset($map)) {

         $map = array(

            'valid'       => 'Valid',

            'carriercode' => 'CarrierCode',

            'servicecode' => 'ServiceCode',

            'servicename' => 'ServiceName',

            'calcmethod'  => 'CalcMethod',

            'rate'        => 'Rate');

      }

      $this->cdataAdapter($val, $map, $this->_rate_cnt, $this->dom['ShipRate']);

   }



   /**

    * Handle character data within ItemShipRate element

    *

    * @access private

    * @param  resource  xml parser resource

    * @param  string    value of the resource

    */

   function cdataHandler($xp, $val)

   {

      static $map;

      if ($this->_err_state || empty($this->_current_tag)) return;

      $map = array('currency' => 'Currency');

      $this->cdataAdapter($val, $map, null, $this->dom);   

   }

}



?>