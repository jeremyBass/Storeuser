<?php
class Wsu_Storepartitions_Block_Rewrite_AdminCatalogProductEditTabSettings extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Settings {
    protected function _prepareForm()  {
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('settings', array('legend'=>Mage::helper('storepartitions')->__('Create Product Settings')));

        $entityType = Mage::registry('product')->getResource()->getEntityType();

        $fieldset->addField('attribute_set_id', 'select', array(
            'label' => Mage::helper('catalog')->__('Attribute Set'),
            'title' => Mage::helper('catalog')->__('Attribute Set'),
            'name'  => 'set',
            'value' => $entityType->getDefaultAttributeSetId(),
            'values'=> Mage::getResourceModel('eav/entity_attribute_set_collection')
                ->setEntityTypeFilter($entityType->getId())
                ->load()
                ->toOptionArray()
        ));

        $roleId = Mage::getSingleton('admin/session')->getUser()->getRole()->getRoleId();
        $usableProductTypes = Mage::getModel('storepartitions/editor_type')->getRestrictedTypes($roleId);
        $productTypes = Mage::getModel('catalog/product_type')->getOptionArray();
        if($usableProductTypes) {
            foreach($productTypes as $id => $value) {
                if(!in_array($id, $usableProductTypes)) {
                    unset($productTypes[$id]);
                }
            }
        }

        $fieldset->addField('product_type', 'select', array(
            'label' => Mage::helper('catalog')->__('Product Type'),
            'title' => Mage::helper('catalog')->__('Product Type'),
            'name'  => 'type',
            'value' => '',
            'values'=> $productTypes
        ));

        $fieldset->addField('continue_button', 'note', array(
            'text' => $this->getChildHtml('continue_button'),
        ));

        $this->setForm($form);
    }
}