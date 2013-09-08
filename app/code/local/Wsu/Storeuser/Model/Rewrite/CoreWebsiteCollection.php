<?php
class Wsu_Storeuser_Model_Rewrite_CoreWebsiteCollection extends Mage_Core_Model_Mysql4_Website_Collection {
    public function toOptionHash() {
        $role = Mage::getSingleton('storeuser/role');
        if ($role->isPermissionsEnabled()) {
            $this->addFieldToFilter('website_id', array(
                'in' => $role->getAllowedWebsiteIds()
            ));
        }
        return parent::toOptionHash();
    }
}