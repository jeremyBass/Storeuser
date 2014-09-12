<?php
class Wsu_Storepartitions_Block_Rewrite_DownloadableAdminhtmlCatalogProductEditTabDownloadableLinks extends Mage_Downloadable_Block_Adminhtml_Catalog_Product_Edit_Tab_Downloadable_Links {
    public function getPurchasedSeparatelySelect() {
        $html = parent::getPurchasedSeparatelySelect();
        $role = Mage::getSingleton('storepartitions/role');
        if (!Mage::app()->isSingleStoreMode() && $role->isPermissionsEnabled() && !$role->canEditGlobalAttributes()) {
            $html = str_replace('<select', '<select disabled ', $html);
        }
        return $html;
    }
}