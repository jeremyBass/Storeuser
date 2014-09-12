<?php
class Wsu_Storepartitions_Block_Rewrite_BundleAdminhtmlCatalogProductEditTabAttributesSpecial extends Mage_Bundle_Block_Adminhtml_Catalog_Product_Edit_Tab_Attributes_Special {
    public function checkFieldDisable() {
        $result = parent::checkFieldDisable();
        if ($this->getElement() && $this->getElement()->getEntityAttribute() && $this->getElement()->getEntityAttribute()->isScopeGlobal()) {
            if (!Mage::getSingleton('storepartitions/role')->canEditGlobalAttributes()) {
                $this->getElement()->setDisabled(true);
                $this->getElement()->setReadonly(true);
                $afterHtml = $this->getElement()->getAfterElementHtml();
                if (false !== strpos($afterHtml, 'type="checkbox"')) {
                    $afterHtml = str_replace('type="checkbox"', 'type="checkbox" disabled ', $afterHtml);
                    $this->getElement()->setAfterElementHtml($afterHtml);
                }
            }
        }
        return $result;
    }
}