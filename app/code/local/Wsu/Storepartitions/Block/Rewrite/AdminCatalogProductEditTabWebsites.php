<?php
class Wsu_Storepartitions_Block_Rewrite_AdminCatalogProductEditTabWebsites extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Websites {
    public function getWebsiteCollection() {
        $collection = Mage::getModel('core/website')->getResourceCollection();
        $role       = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled()) {
            $collection->addIdFilter($role->getAllowedWebsiteIds());
        }
        return $collection->load();
    }
}