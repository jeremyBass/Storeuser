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


            $fieldset = $form->addFieldset('group_fieldset', array(
                'legend' => Mage::helper('core')->__('Store Information')
            ));
            $fieldset->addField('group_name', 'text', array(
                'name'      => 'group[name]',
                'label'     => Mage::helper('core')->__('Name'),
                'value'     => "",
                'required'  => true,
            ));
            $fieldset->addField('root_cat', 'text', array(
                'name'      => 'root_cat',
                'label'     => Mage::helper('core')->__('Root Category Name'),
                'value'     => "",
                'required'  => true,
            ));
            $fieldset->addField('baseurl', 'text', array(
                'name'      => 'storegroup[baseurl]',
                'label'     => Mage::helper('core')->__('Base Url'),
                'value'     => "",
                'required'  => true,
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



            $fieldset = $form->addFieldset('store_cms_fieldset', array(
                'legend' => Mage::helper('core')->__('Store CMS home page')
            ));
            $fieldset->addField('store_title', 'text', array(
                'name'      => 'store[title]',
                'label'     => Mage::helper('core')->__('Title'),
                'value'     => "",
                'required'  => true,
            ));
            $fieldset->addField('store_content_heading', 'text', array(
                'name'      => 'store[content_heading]',
                'label'     => Mage::helper('core')->__('Content Heading'),
                'value'     => "",
                'required'  => true,
            ));
            $fieldset->addField('store_home_layout', 'textarea', array(
                'name'      => 'store[home_layout]',
                'label'     => Mage::helper('core')->__('layout'),
                'value'     => "",
                'required'  => true,
            ));

        $form->setAction($this->getUrl('*/*/quickAddSave'));
        $form->setUseContainer(true);
        $this->setForm($form);

        Mage::dispatchEvent('adminhtml_store_quickadd_form_prepare_form', array('block' => $this));

        return parent::_prepareForm();
    }
}
