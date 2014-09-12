<?php
class Wsu_Storepartitions_Adminhtml_CategoriesController extends Mage_Adminhtml_Controller_Action {
    /*
     * @refactor
     * $storeCategories is not really store categories
     * make getCategoryIds method
     */
    protected function _init() {
        $id              = $this->getRequest()->getParam('rid');
        $storeCategories = Mage::getResourceModel('storepartitions/advancedrole_collection')->loadByRoleId($id);
        Mage::register('store_categories', $storeCategories);
    }
    /*
     * @refactor
     * using block "adminhtml_store_switcher" is not right
     * use smth like "adminhtml_roleedit_categories"
     */
    public function categoriesJsonAction() {
        $this->_init();
        $this->getResponse()->setBody($this->getLayout()->createBlock('storepartitions/adminhtml_store_switcher')->getCategoryChildrenJson($this->getRequest()->getParam('category'), $this->getRequest()->getParam('store')));
    }
    /*
     * @refactor
     * seems not used, remove
     */
    public function categoriesAction() {
        $this->_init();
        $this->getResponse()->setBody($this->getLayout()->createBlock('storepartitions/adminhtml_permissions_tab_advanced')->toHtml());
    }
}