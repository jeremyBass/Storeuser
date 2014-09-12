<?php
class Wsu_Storepartitions_Block_Rewrite_AdminPermissionsEditroles extends Mage_Adminhtml_Block_Permissions_Editroles {
    protected function _prepareLayout() {
        parent::_prepareLayout();
        $id              = $this->getRequest()->getParam('rid');
        $storeCategories = Mage::getResourceModel('storepartitions/advancedrole_collection')->loadByRoleId($id);
        Mage::register('store_categories', $storeCategories);
        $this->addTab('advanced', array(
            'label'     => Mage::helper('storepartitions')->__('Advanced Permissions'),
            'content' => $this->getLayout()->createBlock('storepartitions/adminhtml_permissions_tab_advanced', 'adminhtml.permissions.tab.advanced')->toHtml()
        ));
        $this->addTab('product_editor', array(
            'label'     => Mage::helper('storepartitions')->__('Product Edit Permission'),
            'content' => $this->getLayout()->createBlock('storepartitions/adminhtml_permissions_tab_product_editor', 'adminhtml.permissions.tab.product.editor')->toHtml()
        ));
        $this->addTab('product_create', array(
            'label'     => Mage::helper('storepartitions')->__('Product Create Permission'),
            'content' => $this->getLayout()->createBlock('storepartitions/adminhtml_permissions_tab_product_create')->toHtml()           
        ));
        return $this;
    }
}