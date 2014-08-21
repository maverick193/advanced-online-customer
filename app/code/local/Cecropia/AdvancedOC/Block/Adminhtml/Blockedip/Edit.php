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
 * Blocked Ip Edit Block
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Cecropia_AdvancedOC_Block_Adminhtml_Blockedip_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Create the outer form wrapper
     * $this->_blockGroup . '/' . $this->_controller . '_' . $this->_mode . '_form'
     */
    public function __construct()
    {    	      
        $this->_objectId    = 'id';
		$this->_blockGroup  = 'cecropia_advancedoc';
		$this->_controller  = 'adminhtml_blockedip';
        
        parent::__construct();
        
        $this->_addButton('saveandcontinue', array(
        		'label'     => Mage::helper('cecropia_advancedoc')->__('Save and Continue Edit'),
        		'onclick'   => 'saveAndContinueEdit()',
        		'class'     => 'save',
        ), -100);
        
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
	
    /**
     * Retrieve currently edited blocked ip object
     *
     * @return Cecropia_AdvancedOC_Model_Blockedip
     */
    public function getBlockedIp()
    {
    	return Mage::registry('current_blockedip');
    }
    
    /**
     * Return the title string to show above the form
     *
     * @return string
     */
   
    public function getHeaderText()
    {
    	$model = $this->getBlockedIp();
    	if ($model->getId()) {
    		return $this->__('Edit Ip #%s | Blocked on %s', $this->htmlEscape($model->getIp()), $this->htmlEscape($model->getCreatedAt()));
    	}
    	else {
    		return Mage::helper('cecropia_advancedoc')->__('New Ip To Block');
    	}
    }
}