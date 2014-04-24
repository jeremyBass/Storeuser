<?php

class Wsu_Storepartitions_Block_Adminhtml_System_Store_Quickadd_Form extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * Class constructor
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setId('coreStoreForm');
    }

    /**
     * Prepare form data
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm() {
			//$Model = Mage::registry('store_data');
			//$Model->setData($postData['website']);
			/* @var $websiteModel Mage_Core_Model_Website */
			/* @var $groupModel Mage_Core_Model_Store_Group */
			/* @var $storeModel Mage_Core_Model_Store */
	
			$form = new Varien_Data_Form(array(
				'id'        => 'edit_form',
				'action'    => $this->getData('action'),
				'method'    => 'post'
			));

/*
root_cat
website['code']
website['name']
storegroup['name']
storegroup['baseurl']
store['code']
store['name']
store['home_layout']
store['title']
store['content_heading']
*/



            $fieldset = $form->addFieldset('website_fieldset', array(
                'legend' => Mage::helper('core')->__('Website Information')
            ));
            /* @var $fieldset Varien_Data_Form */

            $fieldset->addField('website_name', 'text', array(
                'name'      => 'website[name]',
                'label'     => Mage::helper('core')->__('Name'),
                'value'     => "",
                'required'  => true,
            ));

            $fieldset->addField('website_code', 'text', array(
                'name'      => 'website[code]',
                'label'     => Mage::helper('core')->__('Code'),
                'value'     => "",
                'required'  => true,
            ));

            $fieldset->addField('website_sort_order', 'text', array(
                'name'      => 'website[sort_order]',
                'label'     => Mage::helper('core')->__('Sort Order'),
                'value'     => "",
                'required'  => false,
            ));


             $fieldset->addField('is_default', 'hidden', array(
                    'name'      => 'website[is_default]',
                    'value'     => ""
                ));

            $fieldset->addField('website_website_id', 'hidden', array(
                'name'  => 'website[website_id]',
                'value' => ""
            ));


            $fieldset = $form->addFieldset('group_fieldset', array(
                'legend' => Mage::helper('core')->__('Store Information')
            ));

 
            $fieldset->addField('group_name', 'text', array(
                'name'      => 'group[name]',
                'label'     => Mage::helper('core')->__('Name'),
                'value'     => "",
                'required'  => true,
            ));

            $categories = Mage::getModel('adminhtml/system_config_source_category')->toOptionArray();

            $fieldset->addField('group_root_category_id', 'select', array(
                'name'      => 'group[root_category_id]',
                'label'     => Mage::helper('core')->__('Root Category'),
                'value'     => "",
                'values'    => $categories,
                'required'  => true,
            ));


            $fieldset->addField('group_group_id', 'hidden', array(
                'name'      => 'group[group_id]',
                'no_span'   => true,
                'value'     => ""
            ));


            $fieldset = $form->addFieldset('store_fieldset', array(
                'legend' => Mage::helper('core')->__('Store View Information')
            ));

 

            $fieldset->addField('store_name', 'text', array(
                'name'      => 'store[name]',
                'label'     => Mage::helper('core')->__('Name'),
                'value'     => "",
                'required'  => true,
            ));
            $fieldset->addField('store_code', 'text', array(
                'name'      => 'store[code]',
                'label'     => Mage::helper('core')->__('Code'),
                'value'     => "",
                'required'  => true,
            ));

            $fieldset->addField('store_is_active', 'select', array(
                'name'      => 'store[is_active]',
                'label'     => Mage::helper('core')->__('Status'),
                'value'     => "",
                'options'   => array(
                    0 => Mage::helper('adminhtml')->__('Disabled'),
                    1 => Mage::helper('adminhtml')->__('Enabled')),
                'required'  => true,
            ));

            $fieldset->addField('store_sort_order', 'text', array(
                'name'      => 'store[sort_order]',
                'label'     => Mage::helper('core')->__('Sort Order'),
                'value'     => "",
                'required'  => false,
            ));

            $fieldset->addField('store_is_default', 'hidden', array(
                'name'      => 'store[is_default]',
                'no_span'   => true,
                'value'     => "",
            ));

            $fieldset->addField('store_store_id', 'hidden', array(
                'name'      => 'store[store_id]',
                'no_span'   => true,
                'value'     => "",
            ));



        $form->setAction($this->getUrl('*/*/quickAddSave'));
        $form->setUseContainer(true);
        $this->setForm($form);

        Mage::dispatchEvent('adminhtml_store_quickadd_form_prepare_form', array('block' => $this));

        return parent::_prepareForm();
    }
}
