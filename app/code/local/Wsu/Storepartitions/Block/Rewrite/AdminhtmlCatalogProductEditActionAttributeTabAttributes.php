<?php
class Wsu_Storepartitions_Block_Rewrite_AdminhtmlCatalogProductEditActionAttributeTabAttributes extends Mage_Adminhtml_Block_Catalog_Product_Edit_Action_Attribute_Tab_Attributes {
    protected function _getAdditionalElementHtml($element) {
        $result = parent::_getAdditionalElementHtml($element);
        if ($element && $element->getEntityAttribute() && $element->getEntityAttribute()->isScopeGlobal()) {
            $role = Mage::getSingleton('storepartitions/role');
            if ($role->isPermissionsEnabled() && !$role->canEditGlobalAttributes() && $this->getRequest()->getActionName() != 'new'){
                $result = str_replace('<input type="checkbox"', '<input type="checkbox" disabled ', $result);
            }
        }
        return $result;
    }
}