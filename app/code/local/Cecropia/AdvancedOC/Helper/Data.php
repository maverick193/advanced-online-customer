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
 * Helper Data
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

 class Cecropia_AdvancedOC_Helper_Data extends Mage_Core_Helper_Abstract
 {
     const XML_PATH_ENABLE_AUTOMATIC_RULES  = 'advancedoc/blocking_rules/enabled';
     const XML_PATH_WHITE_LIST              = 'advancedoc/blocking_rules/whitelist';
     const XML_PATH_MAXIMUM_SIMULTANEOUS    = 'advancedoc/blocking_rules/max_at_once';
     const XML_PATH_MAXIMUM_PER_DAY         = 'advancedoc/blocking_rules/max_per_day';

     /**
      * Return whether automatic ip blocking rules are enabled
      *
      * @return bool
      */
     public function rulesEnabled()
     {
         return (bool) Mage::getStoreConfig(self::XML_PATH_ENABLE_AUTOMATIC_RULES);
     }

     /**
      * Return IP white list
      *
      * @return array
      */
     public function getWhiteList()
     {
         return explode("\r\n", Mage::getStoreConfig(self::XML_PATH_WHITE_LIST));
     }

     /**
      * Get maximum simultaneous connections
      *
      * return string
      */
     public function getMaxSimultConn()
     {
        return Mage::getStoreConfig(self::XML_PATH_MAXIMUM_SIMULTANEOUS);
     }

     /**
      * Get maximum connections per day
      *
      * @return mixed
      */
     public function getMaxPerDay()
     {
         return Mage::getStoreConfig(self::XML_PATH_MAXIMUM_PER_DAY);
     }
 }