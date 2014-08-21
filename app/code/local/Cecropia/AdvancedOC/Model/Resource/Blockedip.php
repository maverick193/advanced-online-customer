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
 * Blocked Ip Resource Model
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Cecropia_AdvancedOC_Model_Resource_Blockedip extends Mage_Core_Model_Mysql4_Abstract
{
	/**
	 * 'id' is the FK of "cecropia_blocked_ip" table
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 */
	protected function _construct()
	{
		$this->_init('cecropia_advancedoc/blockedip','id');
	}
	
	/**
	 * Get row identifier by ip
	 *
	 * @param string $ip
	 * @return string
	 */
	public function getIdByIp($ip)
	{
		$adapter = $this->_getReadAdapter();
	
		$select = $adapter->select()
		->from($this->getMainTable(), 'id')
		->where('ip = :ip');
	
		$bind = array(':ip' => (string)$ip);
	
		return $adapter->fetchOne($select, $bind);
	}
}