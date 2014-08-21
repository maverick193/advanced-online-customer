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
 * Blocked Ip Form
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Cecropia_AdvancedOC_Block_Adminhtml_Blockedip_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('blockedip_form');
        $this->setTitle(Mage::helper('cecropia_advancedoc')->__('Blocked Ip Information'));
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('current_blockedip');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))), 'method' => 'post')
        );

        $form->setHtmlIdPrefix('blockedip_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('cecropia_advancedoc')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }

        $fieldset->addField('ip', 'text', array(
            'name'      => 'ip',
            'label'     => Mage::helper('cecropia_advancedoc')->__('Ip Address'),
            'title'     => Mage::helper('cecropia_advancedoc')->__('Ip Address'),
            'required'  => true,
        ));

        $fieldset->addField('comment', 'editor', array(
            'name'      => 'comment',
            'label'     => Mage::helper('cecropia_advancedoc')->__('Comment'),
            'title'     => Mage::helper('cecropia_advancedoc')->__('Comment'),
            'style'     => 'height:36em',
            'required'  => false
        ));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}