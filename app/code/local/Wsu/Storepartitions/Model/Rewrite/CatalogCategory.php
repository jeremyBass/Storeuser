<?php
class Wsu_Storepartitions_Model_Rewrite_CatalogCategory extends Mage_Catalog_Model_Category {
    protected function _beforeSave(){
        if (!$this->getId() && !Mage::registry('wsuemails_category_is_new')) {
            Mage::register('wsuemails_category_is_new', true);
        }

        $role = Mage::getSingleton('storepartitions/role');
        if (!Mage::registry('storepartitions_category_update')) {
            if(!$role->isAllowedToEditCategory($this)) {
                Mage::register('wsu_catalog_catagory_clear_session_data', true);
                throw new Mage_Core_Exception(
                    Mage::helper('storepartitions')->__('You do not have permissions to update "%s" category.', $this->getName())
                );
            }
        }

        $generalSection = Mage::app()->getRequest()->getParam('general');
        if(!isset($generalSection) || !is_array($generalSection) || !isset($generalSection['is_active']))
            return parent::_beforeSave();

        if(isset($generalSection['path'])) {
            $parent_category_id = $this->_getParentCategoryFromPath($generalSection['path']);
            if($role->isPermissionsEnabled() && !in_array($parent_category_id, $role->getAllowedCategoryIds())) {
                throw new Mage_Core_Exception(
                    Mage::helper('storepartitions')->__('You are not allowed to save category in "%s" branch.', Mage::getModel('catalog/category')->load($parent_category_id)->getName())
                );
            }
        }


        if ($role->isPermissionsEnabled() && Mage::getStoreConfig('storepartitions/sucategories/enable')&& !$this->getId()){
            $this->setSpCategoryApproveStatus(Wsu_Storepartitions_Model_Approvecategory::WSU_CATEGORY_STATUS_AWAITING);
        }

        if(!$role->isPermissionsEnabled() && $this->getId() && Mage::getModel('storepartitions/approvecategory')->isCategoryAwaitingApproving($this->getId())){
            switch($generalSection['is_active']){
                case '0':
                    $this->setSpCategoryApproveStatus(Wsu_Storepartitions_Model_Approvecategory::WSU_CATEGORY_STATUS_NOT_APPROVED);
                    break;                
                case '1':
                    $this->setSpCategoryApproveStatus(Wsu_Storepartitions_Model_Approvecategory::WSU_CATEGORY_STATUS_APPROVED);
                    break;
                default:                    
                    break;
                }
            }
        
        return parent::_beforeSave();
    }

    protected function _getParentCategoryFromPath($path) {
        if(!is_numeric($path)) {
            $path = explode('/', $path);
            $category_id = array_pop($path);//should be current category_id
            if($this->getId() && $category_id == $this->getId()) {
                $category_id = array_pop($path);
            }
            $path = $category_id;
        }
        $path = (int)$path;
        return $path;
    }

    protected function _afterSave() {
        if ($this->getData('entity_id') && 
            ($this->getSpCategoryApproveStatus() === Wsu_Storepartitions_Model_Approvecategory::WSU_CATEGORY_STATUS_AWAITING || 
             $this->getSpCategoryApproveStatus() === Wsu_Storepartitions_Model_Approvecategory::WSU_CATEGORY_STATUS_NOT_APPROVED || 
             $this->getSpCategoryApproveStatus() === Wsu_Storepartitions_Model_Approvecategory::WSU_CATEGORY_STATUS_APPROVED
            )) {
            switch($this->getSpCategoryApproveStatus()){
                case Wsu_Storepartitions_Model_Approvecategory::WSU_CATEGORY_STATUS_NOT_APPROVED:
                    Mage::getModel('storepartitions/approvecategory')->disapprove($this->getData('entity_id'));
                    break;
                case Wsu_Storepartitions_Model_Approvecategory::WSU_CATEGORY_STATUS_APPROVED:
                    Mage::getModel('storepartitions/approvecategory')->approve($this->getData('entity_id'));
                    break;
                case Wsu_Storepartitions_Model_Approvecategory::WSU_CATEGORY_STATUS_AWAITING:
                    Mage::getModel('storepartitions/approvecategory')->add($this->getData('entity_id'));
                    Mage::getModel('storepartitions/notification')->sendCategoryForApproving($this);
                    break;
                default:
                    break;            
            }

            $this->setSpCategoryApproveStatus('');
        }

        $role = Mage::getSingleton('storepartitions/role');

        if ($role->isPermissionsEnabled()) {
            $role->addAllowedCategoryId($this->getId(), $this->_getCurrentStoreId());
            
            if (true === Mage::registry('wsuemails_category_is_new')) {
                Mage::unregister('wsuemails_category_is_new');
                Mage::register('storepartitions_category_update', true);
                $backUpProducts = $this->getPostedProducts();
                $this->setPostedProducts(null);
                $this->setStoreId(0);

                if(!Mage::getStoreConfig('storepartitions/sucategories/enable')){
                    $this->setIsActive(0);
                }
                $this->save();
                $this->setPostedProducts($backUpProducts);
                Mage::unregister('storepartitions_category_update');
            }
        }
        
        return parent::_afterSave();
    }

    private function _getCurrentStoreId() {
        $storeviewId = Mage::app()->getRequest()->getParam('store');
        return Mage::getModel('core/store')->load($storeviewId)->getGroupId();
    }





}