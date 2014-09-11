<?php
class Wsu_Storepartitions_Block_Adminhtml_Permissions_Tab_Product_Editor extends Mage_Adminhtml_Block_Catalog_Category_Tree {
    public function __construct() {
        parent::__construct();
        $this->setTemplate('storepartitions/product/editor.phtml');
    }
    protected function _prepareLayout(){
        $this->setChild('tabs', $this->getLayout()->createBlock('storepartitions/adminhtml_permissions_tab_product_editor_tabs', 'productEditorTabs'));
        $this->setChild('attribute', $this->getLayout()->createBlock('storepartitions/adminhtml_permissions_tab_product_editor_attribute', 'productEditorAttribute'));
        return $this;
    }
}