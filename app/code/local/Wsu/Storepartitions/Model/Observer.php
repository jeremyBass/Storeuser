<?php
class Wsu_Storepartitions_Model_Observer {
    private $_role = null;
    protected $_helper;
    protected $_helperAccess;
    public function __construct() {
        $this->_helper       = Mage::helper('storepartitions');
        $this->_helperAccess = Mage::helper('storepartitions/access');
    }
    private function _getCurrentRole() {
        if (null == $this->_role) {
            $this->_role = Mage::getSingleton('storepartitions/role');
        }
        return $this->_role;
    }
    public function onAdminRolesSaveBefore(Varien_Event_Observer $observer) {
        $scope = Mage::app()->getRequest()->getPost('access_scope');
        if ('store' == $scope) {
            $request       = Mage::app()->getRequest();
            $storeIds      = $request->getPost('store_switcher');
            $categoryIds   = $request->getPost('store_category_ids');
            $errorStoreIds = array();
            foreach ($storeIds as $storeId => $storeviewIds) {
                if (empty($categoryIds[$storeId])) {
                    $errorStoreIds[] = $storeId;
                }
            }
            if ($errorStoreIds) {
                $storesCollection = Mage::getModel('core/store_group')->getCollection()->addFieldToFilter('group_id', array(
                    'in' => $errorStoreIds
                ));
                $storeNames       = array();
                foreach ($storesCollection as $store) {
                    $storeNames[] = $store->getName();
                }
                Mage::throwException($this->_helper->__('Please, select allowed categories for the following stores: %s', join(', ', $storeNames)));
            }
        }
    }
    public function onAdminRolesSaveAfter($observer) {
        $roleId = $observer->getObject()->getId();
        $scope  = Mage::app()->getRequest()->getPost('access_scope');
        if ($roleId && $scope) {
            $this->deleteAdvancedRole($roleId);
            if ('store' == $scope) {
                $this->_saveRoleStoreRestriction($roleId);
            } else if ('website' == $scope) {
                $this->_saveRoleWebsiteRestriction($roleId);
            } else if ('disabled' == $scope) {
                //                Mage::getSingleton('adminhtml/session')->addSuccess(
                //                    $this->_helper->__('Advanced permissions were disabled for this role')
                //                );
            } else {
                Mage::getSingleton('adminhtml/session')->addError($this->_helper->__('Invalid Advanced Permissions scope type received'));
            }
        }
    }
    private function _saveRoleStoreRestriction($roleId) {
        $request                = Mage::app()->getRequest();
        $canUpdateGlobalAttr    = (int) $request->getPost('allowupdateglobalattrs');
        $canEditOwnProductsOnly = (int) $request->getPost('caneditownproductsonly');
		$canAddStoreViews		= (int) $request->getPost('canaddstoreviews');
		$canEditStoreViews		= (int) $request->getPost('caneditstoreviews');
		$canAddStoreGroups		= (int) $request->getPost('canaddstoregroups');
		$canEditStoreGroups		= (int) $request->getPost('caneditstoregroups');
		$canAddWebSites			= (int) $request->getPost('canaddwebsites');
		$canEditWebSites		= (int) $request->getPost('caneditwebsites');
        $selectedStoreIds       = $request->getPost('store_switcher');
        $storeCategoryIds       = $request->getPost('store_category_ids');
        foreach ($selectedStoreIds as $storeId => $storeviewIds) {
            $storeviewIds = implode(',', $storeviewIds);
            $categoryIds  = '';
            if (isset($storeCategoryIds[$storeId])) {
                $categoryIds = implode(',', array_diff(array_unique(explode(',', $storeCategoryIds[$storeId])), array(
                    ''
                )));
            }
            $advancedrole = Mage::getModel('storepartitions/advancedrole');
            $advancedrole->setData('role_id', $roleId);
            $advancedrole->setData('store_id', $storeId);
            $advancedrole->setData('storeview_ids', $storeviewIds);
            $advancedrole->setData('category_ids', $categoryIds);
            $advancedrole->setData('website_id', 0);
            $advancedrole->setData('can_edit_global_attr', $canUpdateGlobalAttr);
            $advancedrole->setData('can_edit_own_products_only', $canEditOwnProductsOnly);
			$advancedrole->setData('can_add_store_views', $canAddStoreViews);
			$advancedrole->setData('can_edit_store_views', $canEditStoreViews);
			$advancedrole->setData('can_add_store_groups', $canAddStoreGroups);
			$advancedrole->setData('can_edit_store_groups', $canEditStoreGroups);
			$advancedrole->setData('can_add_web_sites', $canAddWebSites);
			$advancedrole->setData('can_edit_web_sites', $canEditWebSites);
            $advancedrole->save();
        }
    }
    private function _saveRoleWebsiteRestriction($roleId) {
        $request                = Mage::app()->getRequest();
        $canUpdateGlobalAttr    = (int) $request->getPost('allowupdateglobalattrs');
        $canEditOwnProductsOnly = (int) $request->getPost('caneditownproductsonly');
		$canAddStoreViews		= (int) $request->getPost('canaddstoreviews');
		$canEditStoreViews		= (int) $request->getPost('caneditstoreviews');
		$canAddStoreGroups		= (int) $request->getPost('canaddstoregroups');
		$canEditStoreGroups		= (int) $request->getPost('caneditstoregroups');
		$canAddWebSites			= (int) $request->getPost('canaddwebsites');
		$canEditWebSites		= (int) $request->getPost('caneditwebsites');
        foreach ($request->getPost('website_switcher') as $websiteId) {
            $advancedrole = Mage::getModel('storepartitions/advancedrole');
            $advancedrole->setData('role_id', $roleId);
            $advancedrole->setData('website_id', $websiteId);
            $advancedrole->setData('store_id', '');
            $advancedrole->setData('category_ids', '');
            $advancedrole->setData('can_edit_global_attr', $canUpdateGlobalAttr);
            $advancedrole->setData('can_edit_own_products_only', $canEditOwnProductsOnly);
			$advancedrole->setData('can_add_store_views', $canAddStoreViews);
			$advancedrole->setData('can_edit_store_views', $canEditStoreViews);
			$advancedrole->setData('can_add_store_groups', $canAddStoreGroups);
			$advancedrole->setData('can_edit_store_groups', $canEditStoreGroups);
			$advancedrole->setData('can_add_web_sites', $canAddWebSites);
			$advancedrole->setData('can_edit_web_sites', $canEditWebSites);
            $advancedrole->save();
        }
    }
    public function deleteAdvancedRole($roleId) {
        Mage::getModel('storepartitions/advancedrole')->deleteRole($roleId);
    }
    public function onAdminRolesDeleteAfter($observer) {
        $role = $observer->getObject();
        if ($role) {
            $this->deleteAdvancedRole($role->getId());
        }
    }
    public function onCatalogProductEditAction($observer) {
        $role = $this->_getCurrentRole();
        if (!$role->isPermissionsEnabled()) {
            return;
        }
        $product = $observer->getProduct();
        if (($role->canEditOwnProductsOnly() && !$role->isOwnProduct($product)) || !$role->isAllowedToEditProduct($product)) {
            Mage::getSingleton('adminhtml/session')->addError($this->_helper->__('Sorry, you have no permissions to edit this product. For more details please contact site administrator.'));
            $controller = Mage::app()->getFrontController();
            $controller->getResponse()->setRedirect(Mage::getModel('adminhtml/url')->getUrl('*/*/', array(
                'store' => $controller->getRequest()->getParam('store', 0)
            )))->sendResponse();
            exit;
        }
        if (!$role->isAllowedToDelete()) {
            $product->setIsDeleteable(false);
        }
    }
    public function onCatalogProductPrepareSave($observer) {
        // should check if the product is a new one
        $product     = $observer->getProduct();
        $request     = $observer->getRequest();
        $productData = $request->getPost('product');
        if (!$product->getId()) {
            // new product
            Mage::getSingleton('catalog/session')->setIsNewProduct(true);
            Mage::getSingleton('catalog/session')->setSelectedVisibility($productData['visibility']);
            $product->setData('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);
        }
    }
    /**
     * @refactor
     * add 3 sub methods
     */
    public function onCatalogProductSaveAfter($observer) {
        $controllerName = Mage::app()->getRequest()->getControllerName();
        $actionName     = Mage::app()->getRequest()->getActionName();
        if (!(Mage::getSingleton('catalog/session')->getIsNewProduct(true)) && !('catalog_product' == $controllerName && 'quickCreate' == $actionName)) {
            return;
        }
        $product              = $observer->getProduct();
        // setting created by attribute
        $attributeTable       = Mage::getResourceModel('catalog/product_collection')->getTable('catalog_product_entity_int');
        $productEntityTypeId  = $product->getEntityTypeId();
        $createdByAttributeId = Mage::getModel('eav/entity_attribute')->load('created_by', 'attribute_code')->getId();
        $adminId              = Mage::getSingleton('admin/session')->getUser()->getUserId();
        $this->insertAttributeValue($attributeTable, $productEntityTypeId, $createdByAttributeId, 0, $product->getId(), $adminId);
        $role = $this->_getCurrentRole();
        if (!$role->isPermissionsEnabled()) {
            return;
        }
        // setting selected visibility for allowed store views
        $allowedStoreviewIds   = $role->getAllowedStoreviewIds();
        $visibilityAttributeId = Mage::getModel('eav/entity_attribute')->load('visibility', 'attribute_code')->getId();
        $visibility            = Mage::getSingleton('catalog/session')->getSelectedVisibility(true);
        foreach ($allowedStoreviewIds as $allowedStoreviewId) {
            $this->insertAttributeValue($attributeTable, $productEntityTypeId, $visibilityAttributeId, $allowedStoreviewId, $product->getId(), $visibility);
        }
        // setting visibility "Nowhere" for all other store views
        $visibilityNotVisible = Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE;
        foreach (Mage::getModel('core/store')->getCollection() as $store) {
            if (0 != $store->getId() && (!in_array($store->getId(), $allowedStoreviewIds))) {
                $this->insertAttributeValue($attributeTable, $productEntityTypeId, $visibilityAttributeId, $store->getId(), $product->getId(), $visibilityNotVisible);
            }
        }
    }
    public function onCatalogProductCollectionLoadBefore($observer) {
        if (!$this->_getCurrentRole()->isPermissionsEnabled()) {
            return;
        }
        $routeName = Mage::app()->getFrontController()->getRequest()->getRouteName();
        if (false === strpos($routeName, 'adminhtml') && false === strpos($routeName, 'bundle')) {
            return;
        }
        if (Mage::getStoreConfig('storepartitions/general/showallproducts')) {
            return;
        }
        $role           = $this->_getCurrentRole();
        $collection     = $observer->getCollection();
        $controllerName = Mage::app()->getRequest()->getControllerName();
        if ($role->isScopeStore() && !in_array($controllerName, array(
            'sales_order_edit',
            'sales_order_create'
        ))) {
            $collection->getSelect()->joinLeft(array(
                'product_cat' => $collection->getTable('catalog_category_product')
            ), 'product_cat.product_id = e.entity_id', array());
            $collection->getSelect()->where(' product_cat.category_id in (' . join(',', $role->getAllowedCategoryIds()) . ')
                or product_cat.category_id IS NULL ');
            $collection->getSelect()->distinct(true);
        }
        if ($role->isScopeWebsite()) {
            $websiteIds   = $role->getAllowedWebsiteIds();
            $scopeStoreId = Mage::app()->getFrontController()->getRequest()->getParam('store');
            if ($scopeStoreId) {
                $scopeWebsiteId = Mage::getModel('core/store')->load($scopeStoreId)->getWebsiteId();
                if (in_array($scopeWebsiteId, $websiteIds)) {
                    $websiteIds = array(
                        $scopeWebsiteId
                    );
                }
            }
            $collection->addWebsiteFilter($websiteIds);
        }
    }
    protected function _getCurrentOrder() {
        $orderId = Mage::app()->getRequest()->has('order_id');
        if ($orderId) {
            $order = Mage::getModel('sales/order')->load($orderId);
            return $order;
        }
        $order = Mage::getSingleton('adminhtml/session_quote')->getOrder();
        if ($order->getId()) {
            return $order;
        }
        return null;
    }
    protected function _filterCollectionByPermissions($collection) {
        if (!$this->_getCurrentRole()->isPermissionsEnabled()) {
            return;
        }
        if ($collection->getFlag('permissions_processed')) {
            return;
        }
        if (false !== strpos(Mage::app()->getFrontController()->getRequest()->getRouteName(), 'adminhtml')) {
            $role = $this->_getCurrentRole();
            if ($role->isPermissionsEnabled()) {
                if (version_compare(Mage::getVersion(), '1.4.1.0', '>')) {
                    $collection->addAttributeToFilter('main_table.store_id', array(
                        'in' => $role->getAllowedStoreviewIds()
                    ));
                } else {
                    $collection->addAttributeToFilter('store_id', array(
                        'in' => $role->getAllowedStoreviewIds()
                    ));
                }
            }
        }
        $collection->setFlag('permissions_processed', true);
    }
    private function _filterCustomerCollection($collection) {
        if (!$this->_getCurrentRole()->isPermissionsEnabled()) {
            return;
        }
        if (!Mage::getStoreConfig('storepartitions/general/showallcustomers')) {
            $collection->addAttributeToFilter('website_id', array(
                'in' => $this->_getCurrentRole()->getAllowedWebsiteIds()
            ));
        }
    }
    private function _filterCmsMysql4BlockCollection($collection) {
        if (!$this->_getCurrentRole()->isPermissionsEnabled()) {
            return;
        }
        $table = Mage::getSingleton('core/resource')->getTableName('cms/block_store');
        $collection->getSelect()->distinct()->join($table, $table . '.block_id = main_table.block_id', array());
        $request = Mage::app()->getRequest();
        if ($request->getParam('store')) {
            $storeId = Mage::getModel('core/store')->load($request->getParam('store'))->getId();
            $collection->getSelect()->where($table . '.store_id in (0, ' . $storeId . ')');
        } else {
            $allowedStoreviewIds = $this->_getCurrentRole()->getAllowedStoreviewIds();
            $collection->getSelect()->where($table . '.store_id in (0,' . implode(',', $allowedStoreviewIds) . ')');
        }
    }
    private function _filterUrlRewriteCollection($collection) {
        if (!$this->_getCurrentRole()->isPermissionsEnabled()) {
            return;
        }
        $controllerName = Mage::app()->getRequest()->getControllerName();
        $actionName     = Mage::app()->getRequest()->getActionName();
        if ('urlrewrite' == $controllerName && 'index' == $actionName) {
            $collection->addStoreFilter($this->_getCurrentRole()->getAllowedStoreviewIds());
        }
    }
    public function onEavCollectionAbstractLoadBefore($observer) {
        if (!$this->_getCurrentRole()->isPermissionsEnabled()) {
            return;
        }
        $collection = $observer->getCollection();
        if ($collection instanceof Mage_Sales_Model_Mysql4_Order_Collection || $collection instanceof Mage_Sales_Model_Resource_Order_Collection) {
            $this->_filterCollectionByPermissions($collection);
        }
        if ($collection instanceof Mage_Sales_Model_Mysql4_Order_Invoice_Collection || $collection instanceof Mage_Sales_Model_Resource_Order_Invoice_Collection) {
            $this->_filterCollectionByPermissions($collection);
        }
        if ($collection instanceof Mage_Sales_Model_Mysql4_Order_Shipment_Collection || $collection instanceof Mage_Sales_Model_Resource_Order_Shipment_Collection) {
            $this->_filterCollectionByPermissions($collection);
        }
        if ($collection instanceof Mage_Sales_Model_Mysql4_Order_Creditmemo_Collection || $collection instanceof Mage_Sales_Model_Resource_Order_Creditmemo_Collection) {
            $this->_filterCollectionByPermissions($collection);
        }
        if ($collection instanceof Mage_Customer_Model_Entity_Customer_Collection || $collection instanceof Mage_Customer_Model_Resource_Customer_Collection) {
            $this->_filterCustomerCollection($collection);
        }
    }
    public function onCoreCollectionAbstractLoadBefore($observer) {
        $collection = $observer->getCollection();
        if ($collection instanceof Mage_Sales_Model_Mysql4_Order_Grid_Collection || $collection instanceof Mage_Sales_Model_Resource_Order_Grid_Collection) {
            $this->_filterCollectionByPermissions($collection);
        }
        if ($collection instanceof Mage_Sales_Model_Mysql4_Order_Invoice_Grid_Collection || $collection instanceof Mage_Sales_Model_Resource_Order_Invoice_Grid_Collection) {
            $this->_filterCollectionByPermissions($collection);
        }
        if ($collection instanceof Mage_Sales_Model_Mysql4_Order_Shipment_Grid_Collection || $collection instanceof Mage_Sales_Model_Resource_Order_Shipment_Grid_Collection) {
            $this->_filterCollectionByPermissions($collection);
        }
        if ($collection instanceof Mage_Sales_Model_Mysql4_Order_Creditmemo_Grid_Collection || $collection instanceof Mage_Sales_Model_Resource_Order_Creditmemo_Grid_Collection) {
            $this->_filterCollectionByPermissions($collection);
        }
        if ($collection instanceof Mage_Core_Model_Resource_Url_Rewrite_Collection || $collection instanceof Mage_Core_Model_Mysql4_Url_Rewrite_Collection) {
            $this->_filterUrlRewriteCollection($collection);
        }
        if ($collection instanceof Mage_Cms_Model_Mysql4_Block_Collection) {
            $this->_filterCmsMysql4BlockCollection($collection);
        }
    }
    public function onSalesOrderLoadAfter($observer) {
        if (!$this->_getCurrentRole()->isPermissionsEnabled()) {
            return;
        }
        if (false !== strpos(Mage::app()->getFrontController()->getRequest()->getRouteName(), 'adminhtml')) {
            if (!in_array($observer->getOrder()->getStoreId(), $this->_getCurrentRole()->getAllowedStoreviewIds())) {
                Mage::app()->getResponse()->setRedirect(Mage::getUrl('*/sales_order'));
            }
        }
    }
    public function onCustomerLoadAfter($observer) {
        if (!$this->_getCurrentRole()->isPermissionsEnabled() || Mage::getStoreConfig('storepartitions/general/showallcustomers')) {
            return;
        }
        $customer = $observer->getCustomer();
        if (false !== strpos(Mage::app()->getFrontController()->getRequest()->getRouteName(), 'adminhtml') && $customer->getData()) {
            if (!in_array($customer->getWebsiteId(), $this->_getCurrentRole()->getAllowedWebsiteIds())) {
                Mage::app()->getResponse()->setRedirect(Mage::getUrl('*/*'));
            }
        }
    }
    public function onCmsPageLoadAfter($observer) {
        if (!$this->_getCurrentRole()->isPermissionsEnabled()) {
            return;
        }
        $model = $observer->getObject();
        if ($model instanceof Mage_Cms_Model_Page) {
            if (!$model->getData('store_id')) {
                return;
            }
            if (is_array($model->getData('store_id')) && in_array(0, $model->getData('store_id'))) {
                // allow, if admin store (all store views) selected
                return;
            }
            if (is_array($model->getData('store_id')) && array_intersect($model->getData('store_id'), $this->_getCurrentRole()->getAllowedStoreviewIds())) {
                return;
            }
            // if no permissions - redirect
            Mage::app()->getResponse()->setRedirect(Mage::getUrl('*/*'));
        }
    }
    public function onAdminhtmlCmsPageEditTabMainPrepareForm($observer) {
        if (!$this->_getCurrentRole()->isPermissionsEnabled()) {
            return;
        }
        $page             = Mage::registry('cms_page');
        $pageStoreviewIds = (array) $page->getStoreId();
        // if page assigned to some storeview admin don't have access to - forbid enabled/disabled setting changes
        if (array_diff($pageStoreviewIds, $this->_getCurrentRole()->getAllowedStoreviewIds())) {
            $fieldset = $observer->getForm()->getElement('base_fieldset');
            $fieldset->removeField('is_active');
        }
    }
    public function onCmsPagePrepareSave($observer) {
        $page = $observer->getPage();
        if ($page->getId() && $this->_getCurrentRole()->isPermissionsEnabled()) {
            // should keep in mind we may have store views from another websites (not visible on edit form) assigned
            $this->_helperAccess->setCmsObjectStores($page);
        }
    }
    public function onModelSaveBefore($observer) {
        $model = $observer->getObject();
        if (($model instanceof Mage_Cms_Model_Block) || ($model instanceof Mage_Widget_Model_Widget_Instance) || ($model instanceof Mage_Poll_Model_Poll)) {
            $this->_helperAccess->setCmsObjectStores($model);
        }
        if ($model instanceof Mage_Catalog_Model_Product) {
            $this->_helperAccess->setProductWebsites($model);
        }
    }
    public function onReviewDeleteBefore($observer) {
        if (!$this->_getCurrentRole()->isPermissionsEnabled()) {
            return;
        }
        $reviewId      = $observer->getObject()->getId();
        $reviewStoreId = Mage::getModel('review/review')->load($reviewId)->getData('store_id');
        if (!in_array($reviewStoreId, $this->_getCurrentRole()->getAllowedStoreviewIds())) {
            Mage::throwException($this->_helper->__('Review could not be deleted due to insufficent permissions.'));
        }
    }
    public function onAdminhtmlCatalogProductReviewMassDeletePredispatch($observer) {
        if (!$this->_getCurrentRole()->isPermissionsEnabled()) {
            return;
        }
        $reviewIds           = $observer->getData('controller_action')->getRequest()->getParam('reviews');
        $notAllowedReviewIds = array();
        foreach ($reviewIds as $id => $reviewId) {
            $reviewStoreId = Mage::getModel('review/review')->load($reviewId)->getData('store_id');
            if (!in_array($reviewStoreId, $this->_getCurrentRole()->getAllowedStoreviewIds())) {
                unset($reviewIds[$id]);
                $notAllowedReviewIds[] = $reviewId;
            }
        }
        if (!empty($notAllowedReviewIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->_helper->__('Some review(s) could not be deleted due to insufficent permissions.'));
            $observer->getData('controller_action')->getRequest()->setParam('reviews', $reviewIds);
        }
    }
    public function insertAttributeValue($table, $entityTypeId, $attributeId, $toreId, $entityId, $value) {
        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        $data       = array(
            'entity_type_id' => $entityTypeId,
            'attribute_id' => $attributeId,
            'store_id' => $toreId,
            'entity_id' => $entityId,
            'value' => $value
        );
        $connection->insert($table, $data);
    }
}