<?php
class Wsu_Storeuser_Block_Adminhtml_Options extends Mage_Core_Block_Template {
    public function __construct() {
        parent::__construct();
        $this->setTemplate('storeuser/options.phtml');
    }
    public function canEditGlobalAttributes() {
        return Mage::getModel('storeuser/advancedrole')->canEditGlobalAttributes($this->_getRoleId());
    }
    public function canEditOwnProductsOnly() {
        return Mage::getModel('storeuser/advancedrole')->canEditOwnProductsOnly($this->_getRoleId());
    }
    private function _getRoleId() {
        return Mage::app()->getRequest()->getParam('rid');
    }
}