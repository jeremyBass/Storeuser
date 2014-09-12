<?php
class Wsu_Storepartitions_Block_Rewrite_AdminPromoCatalogEdit extends Mage_Adminhtml_Block_Promo_Catalog_Edit {
    protected function _prepareLayout(){
        parent::_prepareLayout();
        $role = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled()){
            $blockModel = Mage::registry('current_promo_catalog_rule');
            if ($blockModel->getWebsiteIds() && is_array($blockModel->getWebsiteIds())){
                foreach ($blockModel->getWebsiteIds() as $blockWebsiteId){
                    if (!in_array($blockWebsiteId, $role->getAllowedWebsiteIds())){
                        $this->_removeButton('delete');
                        $this->_removeButton('save');
                        $this->_removeButton('save_apply');
                        $this->_removeButton('save_and_continue_edit');
                        $this->_removeButton('save_and_continue');
                        Mage::getSingleton('adminhtml/session')->addError(
                            Mage::helper('storepartitions')->__(
                                'Currently ou do not have permissions for this rule.'
                            ));
                        break;
                    }
                }
            }
        }
        return $this;
    }
}