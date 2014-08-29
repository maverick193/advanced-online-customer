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
 * Model Observer
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Cecropia_AdvancedOC_Model_Observer
{
    /**
     * Check if the current visitor if he is blocks
     *
     * @param Varien_Event_Observer $observer
     */
    public function checkIpAddress(Varien_Event_Observer $observer)
	{
        /* @var $controller Mage_Core_Controller_Front_Action */
        $controller         = $observer->getEvent()->getControllerAction();
		$customerIpAddress  = Mage::helper('core/http')->getRemoteAddr();
        $model              = Mage::getModel('cecropia_advancedoc/blockedip');
		$id                 = $model->getIdByIp($customerIpAddress);

        // Check if Ip is blocked
		if ($id !== false) {
            $this->_refuseAccess($id, $controller);
            return;
		}

        // If automatic IP blocking rules
        if (Mage::helper('cecropia_advancedoc')->rulesEnabled()) {
            // Validate rules
            $rule   = Mage::getModel('cecropia_advancedoc/rule');
            $result = $rule->validate();

            if ($result !== true) {
                $model->setIp($customerIpAddress)
                    ->setSkipIncrement(true)
                    ->setComment($result)
                    ->save();

                $this->_refuseAccess($model->getId(), $controller);
            }
        }
	}

    protected function _refuseAccess($id, $controller)
    {
        $model = Mage::getModel('cecropia_advancedoc/blockedip');
        //increment nbr_times and update updated_at date
        //@see _beforeSave() in Cecropia_AdvancedOC_Model_Blockedip
        if (!$model->getSkipIncrement()) {
            $model->load($id);
            $model->setNbrTimes($model->getNbrTimes() + 1)->save();
        }

        $controller->getResponse()->setHeader('HTTP/1.1','403 Forbidden');//header("HTTP/1.1 403 Forbidden");
        $controller->getResponse()->setHeader('Status', '403 Forbidden');//header("Status: 403 Forbidden");
        $controller->getResponse()->setHeader('Content-Type', 'text/html; charset=UTF-8');//header("Content-type: text/html");
        $controller->getResponse()->setBody('Access denied !!');//exit("Access denied");
        $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
    }
}