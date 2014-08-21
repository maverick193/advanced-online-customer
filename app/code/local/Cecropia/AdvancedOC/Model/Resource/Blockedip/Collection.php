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
 * Blocked Ip Collection
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Cecropia_AdvancedOC_Model_Resource_Blockedip_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	/**
	 * Specify the entity and resource model to collection data
	 * @see Mage_Core_Model_Resource_Db_Collection_Abstract::_construct()
	 */
	protected function _construct()
	{
		$this->_init('cecropia_advancedoc/blockedip');
	}
}