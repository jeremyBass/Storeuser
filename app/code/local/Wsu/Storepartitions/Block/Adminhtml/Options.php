<?php
class Wsu_Storepartitions_Block_Adminhtml_Options extends Mage_Core_Block_Template {
    public function __construct() {
        parent::__construct();
        $this->setTemplate('storepartitions/options.phtml');
    }
    public function canEditGlobalAttributes() {
        return Mage::getModel('storepartitions/advancedrole')->canEditGlobalAttributes($this->_getRoleId());
    }
    public function canEditOwnProductsOnly() {
        return Mage::getModel('storepartitions/advancedrole')->canEditOwnProductsOnly($this->_getRoleId());
    }
    public function canAddStoreViews() {
        return Mage::getModel('storepartitions/advancedrole')->canAddStoreViews($this->_getRoleId());
    }
    public function canEditStoreViews() {
        return Mage::getModel('storepartitions/advancedrole')->canEditStoreViews($this->_getRoleId());
    }	
    public function canAddStoreGroups() {
        return Mage::getModel('storepartitions/advancedrole')->canAddStoreGroups($this->_getRoleId());
    }		
    public function canEditStoreGroups() {
        return Mage::getModel('storepartitions/advancedrole')->canEditStoreGroups($this->_getRoleId());
    }		
	
	
    private function _getRoleId() {
        return Mage::app()->getRequest()->getParam('rid');
    }
}