<?php
class Wsu_Storepartitions_Block_Rewrite_AdminCatalogProductEditTabCategories extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Categories {
    public function getCategoryCollection() {
        $collection = parent::getCategoryCollection();
        $role       = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled()) {
            if ($role->isScopeStore()) {
                $collection->addIdFilter($role->getCategoryIdsFromAllowedStores());
            }
            if ($role->isScopeWebsite()) {
                $collection->addIdFilter($role->getAllowedCategoryIds());
            }
            $this->setData('category_collection', $collection);
        }
        return $collection;
    }
    public function isReadonly($id = 0) {
        $role = Mage::getSingleton('storepartitions/role');
        if (!$role->isScopeStore()) {
            return $this->getProduct()->getCategoriesReadonly();
        }
        $categoryAllowed    = in_array($id, $role->getAllowedCategoryIds());
        $categoriesReadOnly = $this->getProduct()->getCategoriesReadonly();
        if ($categoryAllowed && !$categoriesReadOnly) {
            return false;
        }
        return true;
    }
    protected function _getNodeJson($node, $level = 1) {
        $item     = parent::_getNodeJson($node, $level);
        $isParent = $this->_isParentSelectedCategory($node);
        if ($isParent) {
            $item['expanded'] = true;
        }
        if (in_array($node->getId(), $this->getCategoryIds())) {
            $item['checked'] = true;
        }
        if (!$this->isReadonly($node->getId())) {
            $item['disabled'] = false;
        }
        return $item;
    }
    public function getRoot($parentNodeCategory = null, $recursionLevel = 3) {
        if (!is_null($parentNodeCategory) && $parentNodeCategory->getId()) {
            return $this->getNode($parentNodeCategory, $recursionLevel);
        }
        $root = Mage::registry('root');
        if (is_null($root)) {
            $storeId = (int) $this->getRequest()->getParam('store');
            if ($storeId) {
                $store  = Mage::app()->getStore($storeId);
                $rootId = $store->getRootCategoryId();
            } else {
                $rootId = Mage_Catalog_Model_Category::TREE_ROOT_ID;
            }
            $ids  = $this->getSelectedCategoriesPathIds($rootId);
            $tree = Mage::getResourceSingleton('catalog/category_tree')->loadByIds($ids, false, false);
            if ($this->getCategory()) {
                $tree->loadEnsuredNodes($this->getCategory(), $tree->getNodeById($rootId));
            }
            $tree->addCollectionData($this->getCategoryCollection());
            $root = $tree->getNodeById($rootId);
            if ($root && $rootId != Mage_Catalog_Model_Category::TREE_ROOT_ID) {
                $root->setIsVisible(true);
                if ($this->isReadonly($rootId)) {
                    $root->setDisabled(true);
                }
            } elseif ($root && $root->getId() == Mage_Catalog_Model_Category::TREE_ROOT_ID) {
                $root->setName(Mage::helper('catalog')->__('Root'));
            }
            Mage::register('root', $root);
        }
        return $root;
    }
}