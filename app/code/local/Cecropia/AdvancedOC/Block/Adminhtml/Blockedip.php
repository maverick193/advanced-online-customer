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
 * Blocked Ip Block Container
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Cecropia_AdvancedOC_Block_Adminhtml_Blockedip extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	/**
	 * Initialize grid container settings
	 */
	protected function _construct() {
		/**
		 * Child gird block class :
		 * $this->_blockGroup . '/' . $this->_controller . '_grid'
		 */
		$this->_blockGroup = 'cecropia_advancedoc';
		$this->_controller = 'adminhtml_blockedip';
		$this->_headerText = $this->__('Blocked Ip Addresses');
		$this->_addButtonLabel = $this->__('Block Ip Address');
		parent::_construct();
	}
}