<?php
class Wsu_Storeuser_Helper_Data extends Mage_Core_Helper_Abstract {
    public function isShowingAllProducts() {
        return Mage::getStoreConfig('adminusers/general/showallproducts');
    }
    public function isShowingAllCustomers() {
        return Mage::getStoreConfig('adminusers/general/showallcustomers');
    }
    public function isAllowedDeletePerWebsite() {
        return Mage::getStoreConfig('adminusers/general/allowdelete_perwebsite');
    }
    public function isAllowedDeletePerStoreview() {
        return Mage::getStoreConfig('adminusers/general/allowdelete');
    }
    /**
     * backward compatibility with Shopping Assistant
     */
    public function getAllowedCategories() {
        return Mage::getSingleton('storeuser/role')->getAllowedCategoryIds();
    }
}