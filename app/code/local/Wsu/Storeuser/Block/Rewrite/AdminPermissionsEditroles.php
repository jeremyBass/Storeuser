<?php
class Wsu_Storeuser_Block_Rewrite_AdminPermissionsEditroles extends Mage_Adminhtml_Block_Permissions_Editroles {
    protected function _prepareLayout() {
        parent::_prepareLayout();
        $id              = $this->getRequest()->getParam('rid');
        $storeCategories = Mage::getResourceModel('storeuser/advancedrole_collection')->loadByRoleId($id);
        Mage::register('store_categories', $storeCategories);
        $this->addTab('advanced', array(
            'label' => Mage::helper('storeuser')->__('Advanced Permissions'),
            'content' => $this->getLayout()->createBlock('storeuser/adminhtml_permissions_tab_advanced')->toHtml()
        ));
        return $this;
    }
}