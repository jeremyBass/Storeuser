<?php
class Wsu_Storepartitions_Block_Rewrite_AdminCatalogProductHelperFormGallery extends Mage_Adminhtml_Block_Catalog_Product_Helper_Form_Gallery {
    public function getElementHtml() {
        $html = parent::getElementHtml();
        $role = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled() && !$role->isAllowedToDelete()) {
            $html = preg_replace('@cell-remove a-center last"><input([ ]+)type="checkbox"@', 'cell-remove a-center last"><input disabled="disabled" type="checkbox"', $html);
        }
        return $html;
    }
}