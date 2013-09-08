<?php
class Wsu_Storeuser_Block_Rewrite_AdminCatalogProductEditActionAttributeTabWebsites extends Mage_Adminhtml_Block_Catalog_Product_Edit_Action_Attribute_Tab_Websites {
    public function getWebsiteCollection() {
        $websites = parent::getWebsiteCollection();
        $role     = Mage::getSingleton('storeuser/role');
        if ($role->isPermissionsEnabled()) {
            foreach ($websites as $key => $website) {
                if (!in_array($website->getId(), $role->getAllowedWebsiteIds())) {
                    unset($websites[$key]);
                }
            }
        }
        return $websites;
    }
}