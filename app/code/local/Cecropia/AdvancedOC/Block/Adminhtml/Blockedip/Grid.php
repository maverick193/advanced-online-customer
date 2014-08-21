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
 * Blocked Ip Grid Block
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Cecropia_AdvancedOC_Block_Adminhtml_Blockedip_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Initialize grid settings
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setId('cecropia_advancedoc_blocked_ip');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
    }
    
    /**
     * Prepare rma collection
     *
     * @return Cecropia_AdvancedOC_Block_Adminhtml_Blockedip_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('cecropia_advancedoc/blockedip_collection');
        				
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }
    
    /**
     * Prepare grid columns
     *
     * @return Cecropia_AdvancedOC_Block_Adminhtml_Blockedip_Grid
     */
    protected function _prepareColumns()
    {
    	$this->addColumn('ip', array(
            'header' => Mage::helper('cecropia_advancedoc')->__('IP Address'),
            'index'  => 'ip',
    		'filter' => false,
    		'sort'   => false
        ));

        $this->addColumn('nbr_times', array(
            'header' => Mage::helper('cecropia_advancedoc')->__('Number of Attempted Connections'),
            'type'   => 'number',
            'index'  => 'nbr_times'
        ));
        
        $this->addColumn('created_at', array(
            'header'            => Mage::helper('cecropia_advancedoc')->__('Blocked At'),
            'index'             => 'created_at',
            'type'              => 'datetime',
            'html_decorators'   => array('nobr'),
            'width'             => '200px',
        ));

        $this->addColumn('updated_at', array(
            'header'            => Mage::helper('cecropia_advancedoc')->__('Last Attempt Date'),
            'index'             => 'updated_at',
            'type'              => 'datetime',
            'html_decorators'   => array('nobr'),
            'width'             => '200px',
        ));

        $this->addColumn('comment', array(
            'header'    => Mage::helper('cecropia_advancedoc')->__('Comment'),
            'index'     => 'comment',
        ));

        $this->addColumn('action', array(
            'header'    => $this->__('Action'),
            'width'     => '100px',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => $this->__('Delete'),
                    'url'       => array('base' => '*/*/delete'),
                    'field'     => 'id',
                	'confirm'   => Mage::helper('cecropia_advancedoc')->__(
                            'Are you sure? This Ip address will be able to connect to your website'
                        )
                ),
            ),
            'filter' => false,
            'sortable' => false,
        ));

        return parent::_prepareColumns();
    }
    
    /**
     * Return URL where to send the user when he clicks on a row
     */
    public function getRowUrl($row)
    {
    	return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * Return Grid URL for AJAX query
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}