<?php
class Wsu_Storepartitions_Block_Adminhtml_Permissions_Tab_Product_Editor_Tabs extends Mage_Adminhtml_Block_Widget_Form {    
    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('permissions_product_editor', array());
        $tabs = Mage::helper('storepartitions')->getProductTabs();
        foreach($tabs as $name => $title){
            $fieldset->addField($name, 'checkbox', array(
                'name'     => $name,
                'label'    => Mage::helper('catalog')->__($title),
                'title'    => Mage::helper('catalog')->__($title),
                'values'   => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
            ));
        }
        $this->setForm($form);
        $this->_setFormValues($form);
    }
    protected function _setFormValues($form){
        $request = Mage::app()->getRequest();
        $rid = null;
        if($request->getParam('rid')){
            $rid = $request->getParam('rid');            

            $editorTab = Mage::getModel('storepartitions/editor_tab');
            $disabledTabs = $editorTab->getDisabledTabs($rid);
            if($disabledTabs){                
                foreach($disabledTabs as $tab){
                    $form->getElement($tab)->setChecked(1);
                }
            }            
        }        
    }
}