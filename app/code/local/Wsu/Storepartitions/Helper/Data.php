<?php
class Wsu_Storepartitions_Helper_Data extends Mage_Core_Helper_Abstract {
    public function isShowingAllProducts() {
        return Mage::getStoreConfig('storepartitions/general/showallproducts');
    }
    public function isShowingAllCustomers() {
        return Mage::getStoreConfig('storepartitions/general/showallcustomers');
    }
    public function isAllowedDeletePerWebsite() {
        return Mage::getStoreConfig('storepartitions/general/allowdelete_perwebsite');
    }
    public function isAllowedDeletePerStoreview() {
        return Mage::getStoreConfig('storepartitions/general/allowdelete');
    }
    /**
     * backward compatibility with Shopping Assistant
     */
    public function getAllowedCategories() {
        return Mage::getSingleton('storepartitions/role')->getAllowedCategoryIds();
    }
}