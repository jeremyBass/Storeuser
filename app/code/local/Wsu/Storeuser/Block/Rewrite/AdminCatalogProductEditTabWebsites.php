<?php
class Wsu_Storeuser_Block_Rewrite_AdminCatalogProductEditTabWebsites extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Websites {
    public function getWebsiteCollection() {
        $collection = Mage::getModel('core/website')->getResourceCollection();
        $role       = Mage::getSingleton('storeuser/role');
        if ($role->isPermissionsEnabled()) {
            $collection->addIdFilter($role->getAllowedWebsiteIds());
        }
        return $collection->load();
    }
}