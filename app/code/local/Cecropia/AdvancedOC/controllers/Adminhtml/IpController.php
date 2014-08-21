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
 * Ip Adminhtml Controller
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */
 
class Cecropia_AdvancedOC_Adminhtml_IpController extends  Mage_Adminhtml_Controller_Action
{
    /**
     * Initialize IP address data
     */
    protected function _initIp()
	{
		$ipInfo = new Varien_Object();
		if ($ip = $this->getrequest()->getParam('ip')) {
			$info = Mage::helper('cecropia_advancedoc/geoloc')->getInfoByIp($ip);
			$ipInfo->setXmlInfo($info);
		}
		
		Mage::register('ip_info', $ipInfo);
	}

    /**
     * IP address information action
     */
    public function infoAction()
	{
		$this->_initIp();
		$this->_title($this->__('Ip'))->_title($this->__('Ip'));
	
		$this->loadLayout();
	
		$this->_setActiveMenu('customer/online');
	
		$this->_addBreadcrumb(Mage::helper('cecropia_advancedoc')->__('Ip'), Mage::helper('cecropia_advancedoc')->__('Ip'));
		$this->_addBreadcrumb(Mage::helper('cecropia_advancedoc')->__('Geolocation'), Mage::helper('cecropia_advancedoc')->__('Geolocation'));
	
		$this->renderLayout();
	}

    /**
     * Block a IP address
     */
    public function blockAction()
	{
		try {
			if ($ip = $this->getRequest()->getParam('ip')) {
				$model = Mage::getModel('cecropia_advancedoc/blockedip')->loadByIp($ip);
				if (!$model->getId()) {
					$model->setIp($ip)
						  ->setComment(Mage::helper('cecropia_advancedoc')->__('Ip Address Blocked From Online Customer Grid'))
						  ->save();				
					$this->_getSession()->addSuccess(Mage::helper('cecropia_advancedoc')->__('Ip Address has been succefully blocked, please wait until grid refresh'));
				} else {
					$this->_getSession()->addError(Mage::helper('cecropia_advancedoc')->__('Ip address already blocked, please wait until grid refresh and try again'));
					Mage::log(Mage::helper('cecropia_advancedoc')->__('Ip "%s" were blocked on %s but still can connect to your website', $ip, $model->getCreatedAt()));
				}
			} else {
				$this->_getSession()->addError(Mage::helper('cecropia_advancedoc')->__('Cannot retrieve Ip to block.'));
			}
		} catch (Mage_Core_Exception $e) {
        	$this->_getSession()->addError($e->getMessage());
            $this->_redirect('*/customer_online/index');
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
            $this->_redirect('*/customer_online/index');
        }
		$this->_redirect('*/customer_online/index');
		return;	
	} 
}