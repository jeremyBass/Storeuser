<?php
class Wsu_Storepartitions_Block_Rewrite_AdminhtmlCatalogFormRendererFieldsetElement extends Mage_Adminhtml_Block_Catalog_Form_Renderer_Fieldset_Element {
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
            $role = Mage::getSingleton('storepartitions/role');
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
    public function render(Varien_Data_Form_Element_Abstract $element) {
        $html = parent::render($element);
        if ($this->getElement() && $this->getElement()->getEntityAttribute() && $this->getElement()->getEntityAttribute()->isScopeGlobal()) {
            $role = Mage::getSingleton('storepartitions/role');
            if ($role->isPermissionsEnabled() && !$role->canEditGlobalAttributes() && ('msrp' == $this->getElement()->getHtmlId())) {
                $html .= '
                    <script type="text/javascript">
                    //<![CDATA[
                    if (Prototype.Browser.IE){
                        if (window.addEventListener){
                            window.addEventListener("load", storepartitions_disable_msrp, false);
                        }else{
                            window.attachEvent("onload", storepartitions_disable_msrp);
                        }
                    }else{
                        document.observe("dom:loaded", storepartitions_disable_msrp);
                    }

                    function storepartitions_disable_msrp(){
                        ["click", "focus", "change"].each(function(evt){
                            var msrp = $("msrp");
                            if (msrp && !msrp.disabled){
                                Event.observe(msrp, evt, function(el) {
                                    el.disabled = true;
                                }.curry(msrp));
                            }
                        });
                    }
                    //]]>
                    </script>';
            }
			//lets rethink this into maybe a cleaner solution.. 
            if (!$role->canEditGlobalAttributes()) {
                $html = str_replace('<script type="text/javascript">toggleValueElements(', '<script type="text/javascript">//toggleValueElements(', $html);
            }
        }
        return $html;
    }
}