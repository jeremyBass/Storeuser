<?php
class Wsu_Storeuser_Model_Rewrite_CatalogCategory extends Mage_Catalog_Model_Category {
    protected function _beforeSave() {
        if (!$this->getId() && !Mage::registry('wsuemails_category_is_new')) {
            Mage::register('wsuemails_category_is_new', true);
        }
        return parent::_beforeSave();
    }
    protected function _afterSave() {
        $role = Mage::getSingleton('storeuser/role');
        if ($role->isPermissionsEnabled()) {
            $role->addAllowedCategoryId($this->getId(), $this->_getCurrentStoreId());
            if (true === Mage::registry('wsuemails_category_is_new')) {
                Mage::unregister('wsuemails_category_is_new');
                $this->setStoreId(0);
                $this->setIsActive(false);
                $this->save();
            }
        }
        return parent::_afterSave();
    }
    private function _getCurrentStoreId() {
        $storeviewId = Mage::app()->getRequest()->getParam('store');
        return Mage::getModel('core/store')->load($storeviewId)->getGroupId();
    }
}