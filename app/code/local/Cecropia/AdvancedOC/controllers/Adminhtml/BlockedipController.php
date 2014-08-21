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
 * Blocked Ip Adminhtml Controller
*
* @category   Cecropia
* @package    Cecropia_AdvancedOC
* @author     Mohammed NAHHAS <m.nahhas@live.fr>
*/

class Cecropia_AdvancedOC_Adminhtml_BlockedipController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Check the permission to run it
	 *
	 * @return boolean
	 */
	protected function _isAllowed()
	{
		return Mage::getSingleton('admin/session')->isAllowed('customer/blockedip');
	}
	
    /**
     * Init actions
     *
     * @return Cecropia_AdvancedOC_Adminhtml_BlockedipController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('customer/blockedip')
			->_addBreadcrumb(
                Mage::helper('cecropia_advancedoc')->__('Customers'),
                Mage::helper('cecropia_advancedoc')->__('Customers')
            )
			->_addBreadcrumb(
                Mage::helper('cecropia_advancedoc')->__('Blocked Ip Addresses'),
                Mage::helper('cecropia_advancedoc')->__('Blocked Ip Addresses')
            )
	
        ;
        return $this;
    }

    /**
     * Grid page
     */
    public function indexAction()
	{
		$this->_title($this->__('Customers'))->_title($this->__('Blocked Ip Addresses'));
		$this->loadLayout();

		$this->_setActiveMenu('customer/blockedip');
		$this->_addBreadcrumb(
            Mage::helper('cecropia_advancedoc')->__('Customers'),
            Mage::helper('cecropia_advancedoc')->__('Customers')
        );
		$this->_addBreadcrumb(
            Mage::helper('cecropia_advancedoc')->__('Blocked Ip Addresses'),
            Mage::helper('cecropia_advancedoc')->__('Blocked Ip Addresses')
        );
	
		$this->renderLayout();
	}
	
	/**
	 * Grid action for ajax requests
	 * in rma grid on order page
	 */
	public function gridAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}
	
	/**
	 * Create new CMS block
	 */
	public function newAction()
	{
		// the same form is used to create and edit
		$this->_forward('edit');
	}
	
	/**
	 * Edit blocked Ip Addresses
	 */
	public function editAction()
	{
		$this->_title($this->__('Cecropia'))->_title($this->__('Blocked Ip'));
	
		// Get ID and create model
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('cecropia_advancedoc/blockedip');
	
		// Initial checking
		if ($id) {
			$model->load($id);
			if (! $model->getId()) {
				Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('cecropia_advancedoc')->__('This item no longer exists.')
                );
				$this->_redirect('*/*/');
				return;
			}
		}
	
		$this->_title($model->getId() ? $model->getTitle() : $this->__('Block New Ip Address'));
	
		// Set entered data if was error when we do save
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (! empty($data)) {
			$model->setData($data);
		}
	
		// Register model to use later in blocks
		Mage::register('current_blockedip', $model);
	
		// Build edit form
		$this->_initAction()
		->_addBreadcrumb($id ? Mage::helper('cecropia_advancedoc')->__('Edit Blocked Ip') : Mage::helper('cecropia_advancedoc')->__('New Ip To Block'), $id ? Mage::helper('cecropia_advancedoc')->__('Edit Blocked Ip') : Mage::helper('cecropia_advancedoc')->__('New Ip To Block'))
		->renderLayout();
	}
	
    /**
     * Delete action
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('id')) {
            $ip = "";
            try {
                // init model and delete
                $model = Mage::getModel('cecropia_advancedoc/blockedip');
                $model->load($id);
                $ip = $model->getIp();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('cecropia_advancedoc')->__('The item with ip #%s has been deleted.', $ip));
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cecropia_advancedoc')->__('Unable to find item to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
    
    /**
     * Save action
     */
    public function saveAction()
    {
    	// check if data sent
    	if ($data = $this->getRequest()->getPost()) {
    
    		$id     = $this->getRequest()->getParam('id');
    		$model  = Mage::getModel('cecropia_advancedoc/blockedip')->load($id);
    		if (!$model->getId() && $id) {
    			Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('cecropia_advancedoc')->__('This item no longer exists.')
                );
    			$this->_redirect('*/*/');
    			return;
    		}
    
    		// init model and set data   
    		$model->setData($data);
    		// try to save it
    		try {
    			// save the data
    			$model->save();
    			// display success message
    			Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('cecropia_advancedoc')->__('The item has been successfully saved.')
                );
    			// clear previously saved data from session
    			Mage::getSingleton('adminhtml/session')->setFormData(false);
    
    			// check if 'Save and Continue'
    			if ($this->getRequest()->getParam('back')) {
    				$this->_redirect('*/*/edit', array('id' => $model->getId()));
    				return;
    			}
    			// go to grid
    			$this->_redirect('*/*/');
    			return;
    
    		} catch (Exception $e) {
    			// display error message
    			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    			// save data in session
    			Mage::getSingleton('adminhtml/session')->setFormData($data);
    			// redirect to edit form
    			$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
    			return;
    		}
    	}
    	$this->_redirect('*/*/');
    }
}