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
 * Adminhtml Customers Online Grid Block Item Renderer to Block Ip.
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Cecropia_AdvancedOC_Block_Adminhtml_Customer_Online_Grid_Renderer_BlockIp
	extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
	public function render(Varien_Object $row)
	{
		$ip   = long2ip($row->getRemoteAddr());
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			$html = '<a href="' . Mage::helper("adminhtml")->getUrl('*/ip/block', array('ip' => $ip)) . '">' . Mage::helper('cecropia_advancedoc')->__('Block This Ip') . '</a>';
		} else {
			$html = Mage::helper('cecropia_advancedoc')->__('Invalid Ip');
		}
		
		return $html;
	}
}