<?php
class Wsu_Storepartitions_Model_Rewrite_CatalogProduct extends Mage_Catalog_Model_Product {
    protected function _beforeSave() {
        parent::_beforeSave();
        $role = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled() && Mage::getStoreConfig('storepartitions/su/enable') && !$this->getCreatedAt()) {
            $this->setStatus(Wsu_Storepartitions_Model_Rewrite_CatalogProductStatus::STATUS_AWAITING);
            Mage::getModel('storepartitions/notification')->send($this);
        }
        if ($this->getId() && $this->getStatus()) {
            Mage::getModel('storepartitions/approve')->approve($this->getId(), $this->getStatus());
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
        if ($this->getData('entity_id') && Mage::getStoreConfig('storepartitions/su/enable') && $this->getStatus()) {
            Mage::getModel('storepartitions/approve')->approve($this->getData('entity_id'), $this->getStatus());
        }
    }
    protected function _beforeDelete() {
        parent::_beforeDelete();
        $role = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled()) {
            $product = Mage::getModel('catalog/product')->load(Mage::app()->getRequest()->getParam('id'));
            if (($role->canEditOwnProductsOnly() && !$role->isOwnProduct($product)) || !$role->isAllowedToEditProduct($product)) {
                Mage::throwException(Mage::helper('storepartitions')->__('Sorry, you have no permissions to delete this product. For more details please contact site administrator.'));
            }
        }
        return $this;
    }
	
	//this is used for the to applie the right url
	//to the product from the store it belones to 
    public function getProductUrl($useSid = NULL){
		$_proId =  $this->getId();
		$product= Mage::getModel('catalog/product')->load($_proId); 
		$stores = $product->getStoreIds();
		$pstore_id = count($stores)>1?array_shift(array_values($product->getStoreIds())):$stores[0];
		/*if(Mage::app()->getStore()->getStoreId() == $pstore_id){
			$purl = $this->getUrlModel()->getProductUrl($this, $useSid);//$this->getProductUrl();
		}else{
			$base = Mage::app()->getStore($pstore_id)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
			$purl = $base.$product->getUrlPath();
		}*/
		
		$base = Mage::app()->getStore($pstore_id)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
		$purl = $base.$product->getUrlPath();
		
		return $purl;
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
    //        if (Mage::helper('storepartitions')->isPermissionsEnabled() &&
    //            Mage::helper('storepartitions/access')->isAllowManageEntity('product') &&
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