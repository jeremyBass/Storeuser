<?php
class Wsu_Storeuser_Block_Rewrite_AdminhtmlCatalogProductEditActionAttributeTabAttributes extends Mage_Adminhtml_Block_Catalog_Product_Edit_Action_Attribute_Tab_Attributes {
    protected function _getAdditionalElementHtml($element) {
        $result = parent::_getAdditionalElementHtml($element);
        if ($element && $element->getEntityAttribute() && $element->getEntityAttribute()->isScopeGlobal()) {
            $role = Mage::getSingleton('storeuser/role');
            if ($role->isPermissionsEnabled() && !$role->canEditGlobalAttributes()) {
                $result = str_replace('<input type="checkbox"', '<input type="checkbox" disabled="disabled"', $result);
            }
        }
        return $result;
    }
}