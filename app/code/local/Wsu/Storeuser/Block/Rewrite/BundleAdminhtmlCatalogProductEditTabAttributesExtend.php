<?php
class Wsu_Storeuser_Block_Rewrite_BundleAdminhtmlCatalogProductEditTabAttributesExtend extends Mage_Bundle_Block_Adminhtml_Catalog_Product_Edit_Tab_Attributes_Extend {
    public function checkFieldDisable() {
        $result               = parent::checkFieldDisable();
        $superGlobalAttribute = array(
            'sku',
            'weight'
        );
        $currentProduct       = Mage::registry('current_product');
        $bAllow               = !$currentProduct || !$currentProduct->getId() || !$currentProduct->getSku();
        if ($bAllow && $this->getElement() && $this->getElement()->getEntityAttribute() && in_array($this->getElement()->getEntityAttribute()->getAttributeCode(), $superGlobalAttribute)) {
            return $result;
        }
        if ($this->getElement() && $this->getElement()->getEntityAttribute() && $this->getElement()->getEntityAttribute()->isScopeGlobal()) {
            $role = Mage::getSingleton('storeuser/role');
            if ($role->isPermissionsEnabled() && !$role->canEditGlobalAttributes()) {
                $this->getElement()->setDisabled(true);
                $this->getElement()->setReadonly(true);
                $afterHtml = $this->getElement()->getAfterElementHtml();
                if (false !== strpos($afterHtml, 'type="checkbox"')) {
                    $afterHtml = str_replace('type="checkbox"', 'type="checkbox" disabled="disabled"', $afterHtml);
                    $this->getElement()->setAfterElementHtml($afterHtml);
                }
            }
        }
        return $result;
    }
}