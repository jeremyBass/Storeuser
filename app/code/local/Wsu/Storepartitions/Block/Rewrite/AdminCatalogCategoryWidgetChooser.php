<?php
class Wsu_Storepartitions_Block_Rewrite_AdminCatalogCategoryWidgetChooser extends Mage_Adminhtml_Block_Catalog_Category_Widget_Chooser {
    public function getCategoryCollection() {
        $collection = parent::getCategoryCollection();
        $role       = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled()) {
            $collection->addIdFilter($role->getAllowedCategoryIds());
        }
        return $collection;
    }
}