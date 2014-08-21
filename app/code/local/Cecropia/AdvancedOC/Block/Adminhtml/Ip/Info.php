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
 * Ip Geolocation and Additional Info Block
 * @see cecropia/advancedoc/ip/info.phtml
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Cecropia_AdvancedOc_Block_Adminhtml_Ip_Info extends Mage_Adminhtml_Block_Widget_Container
{
    /**
     * @var bool|SimpleXMLElement
     */
    protected $_xmlInfo;
	
    /**
     * Set template
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('cecropia/advancedoc/ip/info.phtml');
        if ($ipInfo = Mage::registry('ip_info')) {
        	$this->_xmlInfo = $ipInfo->getXmlInfo();
        } else {
        	$this->_xmlInfo = false;
        }
    }
    
    /**
     * Prepare button and grid
     *
     * @return Mage_Adminhtml_Block_Catalog_Product
     */
    protected function _prepareLayout()
    {
    	if ($this->_xmlInfo) {
    		if ($ip = (string)$this->_xmlInfo->Ip) {
		    	$this->_addButton('block_ip', array(
		    			'label'   => Mage::helper('catalog')->__('Block This Ip Address'),
		    			'onclick' => "setLocation('{$this->getUrl('*/*/block', array('ip' => $ip))}')",
		    			'class'   => 'add'
		    					));
    		}
    	}
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
    	if ($this->_xmlInfo) {
    		$title = Mage::helper('cecropia_advancedoc')->__('Info & Geolocation of %s', $this->_xmlInfo->Ip);
    	} else {
    		$title = Mage::helper('cecropia_advancedoc')->__('Info & Geolocation');
    	}
    	return $title;
    }
    
    public function getIframe()
    {
    	$html = '';
    	if ($this->_xmlInfo) {
    		if ($this->_xmlInfo->CountryName && $this->_xmlInfo->City &&
    				$this->_xmlInfo->Latitude && $this->_xmlInfo->Longitude) {
    			$html  = '<iframe width="800" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.fr/maps?f=q&amp;source=s_q&amp;hl=fr&amp;geocode=&amp;q=';
    			$html .= $this->_xmlInfo->CountryName . ',+' . $this->_xmlInfo->City . '&amp;aq=0&amp;oq=' . $this->_xmlInfo->City;
    			$html .= '&amp;ie=UTF8&amp;hq=&amp;hnear=' . $this->_xmlInfo->City . ',+' . $this->_xmlInfo->CountryName;
    			$html .= '&amp;t=m&amp;z=11&amp;ll=' . $this->_xmlInfo->Latitude . ',' . $this->_xmlInfo->Longitude . '&amp;output=embed"></iframe>';
    		}
    	}
    	
    	if (empty($html)) {
    		$html = Mage::helper('cecropia_advancedoc')->__('Cannot Retrieve Ip Geolocation');
    	}
    	
    	return $html;
    }
    
    public function getAdditionalInfo()
    {
    	$html = '';
    	if ($this->_xmlInfo) {
    		$info = array('Ip', 'CountryCode', 'CountryName', 'RegionCode', 'RegionName', 
    					  'City', 'ZipCode', 'Latitude', 'Longitude');
    		
    		foreach ($info as $i) {
    			$row = (string)$this->_xmlInfo->$i;
    			if ($row && !empty($row)) {
    				$html .= '<p>' . '<strong>' . $i . ': ' . '</strong>' . $row . '</p>';
    			}
    		}
    	} else {
    		$html = '<p>' . Mage::helper('cecropia_advancedoc')->__('Cannot Retrieve Information') . '</p>';
    	}
    	return $html;
    }
}