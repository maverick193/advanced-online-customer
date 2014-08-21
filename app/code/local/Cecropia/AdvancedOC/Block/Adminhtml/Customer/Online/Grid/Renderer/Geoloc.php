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
 * Adminhtml Customers Online Grid Block Item Renderer by Geolocation.
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Cecropia_AdvancedOC_Block_Adminhtml_Customer_Online_Grid_Renderer_Geoloc
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
		$html = '';
		$ip = long2ip($row->getRemoteAddr());
		$ipInfo = Mage::helper('cecropia_advancedoc/geoloc')->getInfoByIp($ip);
		if ($ipInfo && $ipInfo->CountryName && $ipInfo->CountryCode) {
			$imageFile = $this->getSkinUrl('images/cecropia/advancedoc/flags/' . strtolower((string)$ipInfo->CountryCode) . '.gif');
			if (@GetImageSize($imageFile)) {
				$html .= '<img src="' . $imageFile . '" /> ';
			}
			return $html . strtoupper((string)$ipInfo->CountryName);
		} else {
			$html = '--';
		}
		
		return $html;
	}
}