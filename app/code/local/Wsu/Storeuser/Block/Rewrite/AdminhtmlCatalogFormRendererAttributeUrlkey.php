<?php
class Wsu_Storeuser_Block_Rewrite_AdminhtmlCatalogFormRendererAttributeUrlkey extends Mage_Adminhtml_Block_Catalog_Form_Renderer_Attribute_Urlkey {
    public function getElementHtml() {
        $html    = parent::getElementHtml();
        $element = $this->getElement();
        if ($element && $element->getEntityAttribute() && $element->getEntityAttribute()->isScopeGlobal()) {
            $role = Mage::getSingleton('storeuser/role');
            if ($role->isPermissionsEnabled() && !$role->canEditGlobalAttributes()) {
                $html = str_replace('type="text"', ' disabled="disabled" type="text"', $html);
            }
        }
        return $html;
    }
}