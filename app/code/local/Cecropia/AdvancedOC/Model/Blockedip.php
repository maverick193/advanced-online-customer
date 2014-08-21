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
 * Blocked Ip Model
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Cecropia_AdvancedOC_Model_Blockedip extends Mage_Core_Model_Abstract
{
	/**
	 * Bind class to resource model
	 * @see Varien_Object::_construct()
	 */
	protected function _construct()
	{
		$this->_init('cecropia_advancedoc/blockedip');
	}
	
	/**
	 * Set created_at & updated_at values before saving
	 *
	 * @return Cecropia_AdvancedOC_Model_Blockedip
	 */
	protected function _beforeSave()
	{
		parent::_beforeSave();

        $date = Mage::getModel('core/date')->date('Y-m-d H:i:s');
		if ($this->isObjectNew()) {
			$this->setCreatedAt($date);
			$this->setUpdatedAt($date);
		} else {
			$this->setUpdatedAt($date);
		}	
		
		return $this;
	}

    /**
     * Get entity id by IP address
     *
     * @param $ip
     * @return string
     */
    public function getIdByIp($ip)
	{
		return $this->_getResource()->getIdByIp($ip);
	}

    /**
     * Load entity by IP address
     *
     * @param $ip
     * @return Cecropia_AdvancedOC_Model_Blockedip
     */
    public function loadByIp($ip)
	{
		return $this->getCollection()->addFieldToFilter('ip', array('eq' => $ip))->getFirstItem();
	}
}