<?php
/**
 * Cecropia Advanced Online Customers Extension
 *
 * NOTICE OF LICENSE
 *
 *
 * @version     0.1.0
 * @category    Cecropia
 * @package     Cecropia_AdvancedOC
 * @copyright   Copyright (c) 2013
 * @license
 */

/**
 * Geolocation Helper
 * @see 		http://freegeoip.net/
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

 class Cecropia_AdvancedOC_Helper_Geoloc extends Mage_Core_Helper_Abstract
 {
 	protected $_webservice_url = 'http://freegeoip.net/xml/';

     /**
      * Get IP address information
      *
      * @param $ip
      * @return bool|SimpleXMLElement
      */
     public function getInfoByIp($ip)
 	{   
 		if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) || $ip == '127.0.0.1') {
 			return false;
 		}
 		
 		$request 	= $this->_webservice_url . $ip;    		     
        $session 	= curl_init($request);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		$response 	= curl_exec($session);
		curl_close($session);	
		
		$badRequest = strpos($response, '400: Bad Request');
		$notFound	= strpos($response, '404: Not Found');
		
		if (($badRequest !== false) || ($notFound !== false)) {
			return false;
		} else {
			return simplexml_load_string($response);
		}
 	}
 }