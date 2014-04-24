<?php
class Wsu_Storepartitions_Model_Rewrite_AdminSystemStore extends Mage_Adminhtml_Model_System_Store {
    public function __construct() {
        parent::__construct();
        if (Mage::getSingleton('storepartitions/role')->isPermissionsEnabled()) {
            $this->setIsAdminScopeAllowed(false);
        }
    }
    protected function _loadWebsiteCollection() {
        $this->_websiteCollection = Mage::app()->getWebsites();
        $role                     = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled()) {
            foreach ($this->_websiteCollection as $id => $website) {
                if (!in_array($id, $role->getAllowedWebsiteIds())) {
                    unset($this->_websiteCollection[$id]);
                }
            }
        }
        return $this;
    }
	

    protected function _loadStoreCollection() {
        $this->_storeCollection = Mage::app()->getStores();
        $role                   = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled()) {
            foreach ($this->_storeCollection as $id => $store) {
                if (!in_array($id, $role->getAllowedStoreviewIds())) {
                    unset($this->_storeCollection[$id]);
                }
            }
        }
        return $this;
    }
	
    public function getWebsiteOptionHash($withDefault = false, $attribute = 'name'){
        $options = array();
		$role                   = Mage::getSingleton('storepartitions/role');
		$allowedWebsiteIds = $role->getAllowedWebsiteIds();
        foreach (Mage::app()->getWebsites((bool)$withDefault && $this->_isAdminScopeAllowed) as $website) {
			
			if(in_array($website->getId(),$allowedWebsiteIds)){
            	$options[$website->getId()] = $website->getDataUsingMethod($attribute);
			}
        }
        return $options;
    }
	
}