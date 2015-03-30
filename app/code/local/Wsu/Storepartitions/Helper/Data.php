<?php
class Wsu_Storepartitions_Helper_Data extends Mage_Core_Helper_Abstract {
    public function isShowingAllProducts() {
        return Mage::getStoreConfig('storepartitions/general/showallproducts');
    }
    public function isShowProductOwner(){
        return Mage::getStoreConfig('storepartitions/general/show_admin_on_product_grid');
    }
    public function isShowingProductsWithoutCategories() {
        return Mage::getStoreConfig('storepartitions/general/allow_null_category');
    }
    public function isShowingAllCustomers() {
        return Mage::getStoreConfig('storepartitions/general/showallcustomers');
    }
    public function isAllowedDeletePerWebsite() {
        return Mage::getStoreConfig('storepartitions/general/allowdelete_perwebsite');
    }
    public function isAllowedDeletePerStoreview() {
        return Mage::getStoreConfig('storepartitions/general/allowdelete');
    }
    public function shouldMapWebsites() {
        return Mage::getStoreConfig('storepartitions/general/mapping');
    }
    public function getAllowedCategories() {
        return Mage::getSingleton('storepartitions/role')->getAllowedCategoryIds();
    }
	public function isQuickCreate() {
        return Mage::app()->getRequest()->getActionName() == 'quickCreate' ? true : false;
    }
    public function getProductTabs(){
        return array(
            'inventory' => 'Inventory',
            'websites' => 'Websites',
            'categories' => 'Categories',
            'related' => 'Related',
            'upsell' => 'Upsell',
            'crosssell' => 'Crosssell',
            'productalert' => 'Product Alerts',
            'reviews' => 'Product Reviews', 
            'tags' => 'Product Tags',
            'customers_tags' => 'Customers Tagged Product',
            'customer_options' => 'Custom Options');
    }
    
    public function getAttributePermission(){
        $user = Mage::getSingleton('admin/session')->getUser();

        $spAttributeModel = Mage::getSingleton('storepartitions/editor_attribute');
        return $spAttributeModel->getAttributePermissionByRole($user->getRole()->getRoleId());
    }
	
    /**
     * @return \Varien_Data_Collection
     */
    public function _getExportCollection() {
        /** @var Mage_Core_Model_Resource_Config_Data_Collection $collection */
        $collection = Mage::getModel('core/config_data')->getCollection();
        $collection->setOrder('path', 'asc')->setOrder('scope', 'asc')->setOrder('scope_id', 'asc');

        /*$include = $this->_input->getOption('include');
        if (!empty($include) && is_string($include) === true) {
            $includes = explode(',', $include);
            $orWhere  = array();
            foreach ($includes as $singlePath) {
                $singlePath = trim($singlePath);
                if (!empty($singlePath)) {
                    $orWhere[] = $collection->getConnection()->quoteInto('`path` like ?', $singlePath . '%');
                }
            }
            if (count($orWhere) > 0) {
                $collection->getSelect()->where(implode(' or ', $orWhere));
            }
        }

        $includeScope = $this->_input->getOption('includeScope');
        if (!empty($includeScope) && is_string($includeScope) === true) {
            $includeScopes = explode(',', $includeScope);
            $orWhere       = array();
            foreach ($includeScopes as $singlePath) {
                $singlePath = trim($singlePath);
                if (!empty($singlePath)) {
                    $orWhere[] = $collection->getConnection()->quoteInto('`scope` like ?', $singlePath);
                }
            }
            if (count($orWhere) > 0) {
                $collection->getSelect()->where(implode(' or ', $orWhere));
            }
        }

        $exclude = $this->_input->getOption('exclude');
        if (!empty($exclude) && is_string($exclude) === true) {
            $excludes = explode(',', $exclude);
            $select   = $collection->getSelect();
            foreach ($excludes as $singleExclude) {
                $singleExclude = trim($singleExclude);
                if (!empty($singleExclude)) {
                    $select->Where('`path` not like ?', $singleExclude . '%');
                }
            }
        }
		https://raw.githubusercontent.com/Zookal/HarrisStreet-ImpEx/master/src/lib/n98-magerun/modules/Zookal_HarrisStreetImpex/src/HarrisStreet/CoreConfigData/AbstractImpex.php
		
		*/
        // remove the id field and sort columns a-z
        foreach ($collection as $item) {
            /** @var $item \Mage_Core_Model_Config_Data */
            $data = $item->getData();
            unset($data['config_id']);
            ksort($data);
            $item->setData($data);
        }
        return $collection;
    }
	
	
	
}