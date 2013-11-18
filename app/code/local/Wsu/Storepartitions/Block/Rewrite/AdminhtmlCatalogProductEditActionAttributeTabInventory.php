<?php
class Wsu_Storepartitions_Block_Rewrite_AdminhtmlCatalogProductEditActionAttributeTabInventory extends Mage_Adminhtml_Block_Catalog_Product_Edit_Action_Attribute_Tab_Inventory {
    protected function _toHtml() {
        $role = Mage::getSingleton('storepartitions/role');
        if (!$role->isPermissionsEnabled() || $role->canEditGlobalAttributes()) {
            return parent::_toHtml();
        }
        return parent::_toHtml() . '
            <script type="text/javascript">
            //<![CDATA[
            if (Prototype.Browser.IE){
                if (window.addEventListener){
                    window.addEventListener("load", disableInventoryInputs, false);
                }else{
                    window.attachEvent("onload", disableInventoryInputs);
                }
            }else{
                document.observe("dom:loaded", disableInventoryInputs);
            }

            function disableInventoryInputs(){
                var elements = $("table_cataloginventory").select(\'input[type="checkbox"],input[type="text"],select\');
                if (elements.size){
                    elements.each(function(el) {
                       el.disabled = true;
                    });
                }
            }
            //]]>
            </script>';
    }
}