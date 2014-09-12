<?php
class Wsu_Storepartitions_Block_Rewrite_AdminCatalogProductHelperFormGallery extends Mage_Adminhtml_Block_Catalog_Product_Helper_Form_Gallery {
    public function getElementHtml() {
        $html = parent::getElementHtml();
        $role = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled() && !$role->isAllowedToDelete()) {
            $html = preg_replace('@cell-remove a-center last"><input([ ]+)type="checkbox"@', 'cell-remove a-center last"><input disabled type="checkbox"', $html);
        }
        return $html;
    }
	
    public function getAttributeReadonly($attribute) {
        if (is_object($attribute)) {
            $attribute = $attribute->getAttributeCode();
            $attrId = $attribute->getAttributeId();
        }else{
            $attribute_details = Mage::getSingleton("eav/config")->getAttribute('catalog_product', $attribute);
            $attribute_data = $attribute_details->getData();
            $attrId = $attribute_data['attribute_id'];
        }
        $result = parent::getAttributeReadonly($attribute);
        $attributePermissionArray = Mage::helper('storepartitions')->getAttributePermission();
        if(isset($attributePermissionArray[$attrId])){
            if($attributePermissionArray[$attrId] == 0){
                return true;
            }
            return false;
        }
        return $result;
    }
	
}