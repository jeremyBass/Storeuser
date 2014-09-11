<?php
class Wsu_Storepartitions_Block_Adminhtml_Permissions_Tab_Product_Create extends Mage_Adminhtml_Block_Widget_Form {
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('permissions_product_create', array('legend'=>Mage::helper('storepartitions')->__('Product create permission')));
        $this->_addElementTypes($fieldset);        

        $fieldset->addField('allow_create_product', 'select', array(
            'name'     => 'allow_create_product',
            'label'    => Mage::helper('storepartitions')->__('Allow Create Product'),
            'title'    => Mage::helper('storepartitions')->__('Allow Create Product'),
            'values'   => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $fieldset->addField('apply_to', 'apply', array(
            'name'        => 'apply_to[]',
            'label'       => Mage::helper('catalog')->__('Allow To'),
            'values'      => Mage_Catalog_Model_Product_Type::getOptions(),
            'mode_labels' => array(
                'all'     => Mage::helper('catalog')->__('All Product Types'),
                'custom'  => Mage::helper('catalog')->__('Selected Product Types')
            ),            
        ), 'frontend_class');

        $this->setForm($form);
        $this->_setFormValues($form);
    }
    protected function _setFormValues($form){
        $request = Mage::app()->getRequest();
        $form->getElement('allow_create_product')->setValue('0');
        $rid = null;
        if($request->getParam('rid')) {
            $rid = $request->getParam('rid');
            $advancedrole = Mage::getModel('storepartitions/advancedrole');
            if($advancedrole->canCreateProducts($rid)) {
                $form->getElement('allow_create_product')->setValue('1');
            }

            $editorType = Mage::getModel('storepartitions/editor_type');
            if($applyTo = $editorType->getRestrictedTypes($rid)) {
                $applyTo = is_array($applyTo) ? $applyTo : explode(',', $applyTo);
                $form->getElement('apply_to')->setValue($applyTo);
            }else{
                $form->getElement('apply_to')->addClass('no-display ignore-validate');
            }
        }else{
            $form->getElement('apply_to')->addClass('no-display ignore-validate');
            $form->getElement('allow_create_product')->setValue('1');
        }

        $form->getElement('apply_to')->setSize(5);

        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap("apply_to", 'apply_to')
            ->addFieldMap("allow_create_product", 'allow_create_product')
            ->addFieldDependence('apply_to', 'allow_create_product', '1')
        );
    }
    protected function _getAdditionalElementTypes(){
        return array(
            'apply'         => Mage::getConfig()->getBlockClassName('adminhtml/catalog_product_helper_form_apply'),
        );
    }    
}