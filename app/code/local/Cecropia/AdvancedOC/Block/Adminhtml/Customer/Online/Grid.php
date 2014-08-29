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
 * Online Customer Grid Rewrite
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Cecropia_AdvancedOC_Block_Adminhtml_Customer_Online_Grid
	extends Mage_Adminhtml_Block_Customer_Online_Grid
{
	/**
	 * Prepare columns
	 *
	 * @return Mage_Adminhtml_Block_Customer_Online_Grid
	 */
	protected function _prepareColumns()
	{
		$this->addColumn('customer_id', array(
				'header'    => Mage::helper('customer')->__('ID'),
				'width'     => '40px',
				'align'     => 'right',
				'type'      => 'number',
				'default'   => Mage::helper('customer')->__('n/a'),
				'index'     => 'customer_id'
		));
		
		$this->addColumn('firstname', array(
				'header'    => Mage::helper('customer')->__('First Name'),
				'default'   => Mage::helper('customer')->__('Guest'),
				'index'     => 'customer_firstname'
		));
		
		$this->addColumn('lastname', array(
				'header'    => Mage::helper('customer')->__('Last Name'),
				'default'   => Mage::helper('customer')->__('n/a'),
				'index'     => 'customer_lastname'
		));
		
		$this->addColumn('email', array(
				'header'    => Mage::helper('customer')->__('Email'),
				'default'   => Mage::helper('customer')->__('n/a'),
				'index'     => 'customer_email'
		));
		
		$this->addColumn('ip_address', array(
				'header'    => Mage::helper('customer')->__('IP Address'),
				'default'   => Mage::helper('customer')->__('n/a'),
				'index'     => 'remote_addr',
				'renderer'  => 'cecropia_advancedoc/adminhtml_customer_online_grid_renderer_ip',
				'filter'    => false,
				'sort'      => false
		));
		
		$this->addColumn('session_start_time', array(
				'header'    => Mage::helper('customer')->__('Session Start Time'),
				'align'     => 'left',
				'width'     => '200px',
				'type'      => 'datetime',
				'default'   => Mage::helper('customer')->__('n/a'),
				'index'     =>'first_visit_at'
		));
		
		$this->addColumn('last_activity', array(
				'header'    => Mage::helper('customer')->__('Last Activity'),
				'align'     => 'left',
				'width'     => '200px',
				'type'      => 'datetime',
				'default'   => Mage::helper('customer')->__('n/a'),
				'index'     => 'last_visit_at'
		));
		
		$typeOptions = array(
				Mage_Log_Model_Visitor::VISITOR_TYPE_CUSTOMER => Mage::helper('customer')->__('Customer'),
				Mage_Log_Model_Visitor::VISITOR_TYPE_VISITOR  => Mage::helper('customer')->__('Visitor'),
		);
		
		$this->addColumn('type', array(
				'header'    => Mage::helper('customer')->__('Type'),
				'index'     => 'type',
				'type'      => 'options',
				'options'   => $typeOptions,
				'index'     => 'visitor_type'
		));
		
		$this->addColumn('customer_country', array(
				'header'    => Mage::helper('cecropia_advancedoc')->__('Country'),
				'default'   => Mage::helper('cecropia_advancedoc')->__('n/a'),
				'index'     => 'customer_country',
				'width' 	=> '160px',
				'renderer'  => 'cecropia_advancedoc/adminhtml_customer_online_grid_renderer_geoloc',
				'filter'    => false,
                'sortable'  => false,
				'sort'      => false
		));
		
		$this->addColumn('block_ip', array(
				'header'    => Mage::helper('cecropia_advancedoc')->__('Action'),
				'default'   => Mage::helper('cecropia_advancedoc')->__('n/a'),
				'index'     => 'block_ip',
				'width' 	=> '110px',
				'renderer'  => 'cecropia_advancedoc/adminhtml_customer_online_grid_renderer_blockIp',
				'filter'    => false,
				'sort'      => false
		));
		
		$this->addColumn('last_url', array(
				'header'    => Mage::helper('customer')->__('Last URL'),
				'type'      => 'wrapline',
				'lineLength' => '60',
				'default'   => Mage::helper('customer')->__('n/a'),
				'renderer'  => 'adminhtml/customer_online_grid_renderer_url',
				'index'     => 'last_url'
		));
		
		return Mage_Adminhtml_Block_Widget_Grid::_prepareColumns();
	}
}