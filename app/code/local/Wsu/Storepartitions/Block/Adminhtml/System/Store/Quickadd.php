<?php

class Wsu_Storepartitions_Block_Adminhtml_System_Store_Quickadd extends Mage_Adminhtml_Block_Widget_Form_Container {
    /**
     * Init class
     *
     */
    public function __construct() {
		$this->_objectId = 'website_id';
		$saveLabel   = Mage::helper('core')->__('Save Website');
        $this->_controller = 'system_store';
        parent::__construct();
        $this->_updateButton('save', 'label', $saveLabel);

    }

    protected function _prepareLayout() {
        /* Add website button */
        $this->setChild('form', $this->getLayout()->createBlock('adminhtml/system_store_quickadd_form'));
        return parent::_prepareLayout();
    }
   /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText(){
		
		$editLabel = Mage::helper('core')->__('Edit Website');
		$addLabel  = Mage::helper('core')->__('New Website');

        return Mage::registry('store_action') == 'add' ? $addLabel : $editLabel;
    }
}
