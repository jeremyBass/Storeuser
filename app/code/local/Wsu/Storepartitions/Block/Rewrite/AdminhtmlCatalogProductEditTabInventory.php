<?php
class Wsu_Storepartitions_Block_Rewrite_AdminhtmlCatalogProductEditTabInventory extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Inventory {
    protected function _toHtml() {
        $role = Mage::getSingleton('storepartitions/role');
        if (!$role->isPermissionsEnabled() || $role->canEditGlobalAttributes()) {
            return parent::_toHtml();
        }
        return parent::_toHtml() . '
            <input id="storepartitions_inventory_manage_stock_default" name="product[stock_data][use_config_manage_stock]" type="hidden" value="1" />
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

                if(typeof($("inventory_use_config_manage_stock")) != "undefined");{
                    if($("inventory_use_config_manage_stock").checked){
                        $("storepartitions_inventory_manage_stock_default").value = 1;
                    }else{
                        $("storepartitions_inventory_manage_stock_default").value = 0;
                    }
                }
            }
            //]]>
            </script>';
    }
}