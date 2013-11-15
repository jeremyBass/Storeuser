<?php
class Wsu_Storeuser_Model_Rewrite_CatalogProduct extends Mage_Catalog_Model_Product {
    protected function _beforeSave() {
        parent::_beforeSave();
        $role = Mage::getSingleton('storeuser/role');
        if ($role->isPermissionsEnabled() && Mage::getStoreConfig('adminusers/su/enable') && !$this->getCreatedAt()) {
            $this->setStatus(Wsu_Storeuser_Model_Rewrite_CatalogProductStatus::STATUS_AWAITING);
            Mage::getModel('storeuser/notification')->send($this);
        }
        if ($this->getId() && $this->getStatus()) {
            Mage::getModel('storeuser/approve')->approve($this->getId(), $this->getStatus());
        }
        $request = Mage::app()->getRequest();
        if ($request->getPost('simple_product') && $request->getQuery('isAjax') && $role->isScopeStore()) {
            $this->_setParentCategoryIds($request->getParam('product'));
        }
        return $this;
    }
    private function _setParentCategoryIds($parentId) {
        $configurableProduct = Mage::getModel('catalog/product')->setStoreId(0)->load($parentId);
        if ($configurableProduct->isConfigurable()) {
            if (!$this->getData('category_ids')) {
                $categoryIds = (array) $configurableProduct->getData('category_ids');
                if ($categoryIds) {
                    $this->setData('category_ids', $categoryIds);
                }
            }
        }
    }
    protected function _afterSave() {
        parent::_afterSave();
        if ($this->getData('entity_id') && Mage::getStoreConfig('adminusers/su/enable') && $this->getStatus()) {
            Mage::getModel('storeuser/approve')->approve($this->getData('entity_id'), $this->getStatus());
        }
    }
    protected function _beforeDelete() {
        parent::_beforeDelete();
        $role = Mage::getSingleton('storeuser/role');
        if ($role->isPermissionsEnabled()) {
            $product = Mage::getModel('catalog/product')->load(Mage::app()->getRequest()->getParam('id'));
            if (($role->canEditOwnProductsOnly() && !$role->isOwnProduct($product)) || !$role->isAllowedToEditProduct($product)) {
                Mage::throwException(Mage::helper('storeuser')->__('Sorry, you have no permissions to delete this product. For more details please contact site administrator.'));
            }
        }
        return $this;
    }
    /**
     * @refactor ?
     * check if following bug reproduces when commented
     * 0027984: Admin (allowed manage own products only) can manage all products by direct URL.
     */
    //    protected function _afterLoad()
    //    {
    //        parent::_afterLoad();
    //        $controller = Mage::app()->getRequest()->getControllerName();
    //        if (Mage::helper('storeuser')->isPermissionsEnabled() &&
    //            Mage::helper('storeuser/access')->isAllowManageEntity('product') &&
    //            Mage::app()->getStore()->isAdmin() &&
    //            ($this->getCreatedBy() !== Mage::getSingleton('admin/session')->getUser()->getUserId()) &&
    //            (!in_array($controller, array('sales_order_edit', 'sales_order_create'))))
    //        {
    //            $this->unsetData();
    //        }
    //
    //        return $this;
    //    }
}