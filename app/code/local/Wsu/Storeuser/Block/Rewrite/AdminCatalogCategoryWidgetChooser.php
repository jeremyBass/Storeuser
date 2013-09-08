<?php
class Wsu_Storeuser_Block_Rewrite_AdminCatalogCategoryWidgetChooser extends Mage_Adminhtml_Block_Catalog_Category_Widget_Chooser {
    public function getCategoryCollection() {
        $collection = parent::getCategoryCollection();
        $role       = Mage::getSingleton('storeuser/role');
        if ($role->isPermissionsEnabled()) {
            $collection->addIdFilter($role->getAllowedCategoryIds());
        }
        return $collection;
    }
}