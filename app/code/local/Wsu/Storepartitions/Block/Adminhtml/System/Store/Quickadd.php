<?php

class Wsu_Storepartitions_Block_Adminhtml_System_Store_Quickadd extends Mage_Adminhtml_Block_Widget_Form_Container {
    /**
     * Init class
     *
     */
    public function __construct() {
		$this->_objectId = 'website_id';
		$saveLabel   = Mage::helper('core')->__('Save');

		$this->_blockGroup = 'adminhtml';
		$this->_controller = 'system_store';
		$this->_mode = 'quickadd';
		
        parent::__construct();
		 
        $this->_updateButton('save', 'label', $saveLabel);

    }

   /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText(){
        return Mage::helper('core')->__('Add a Website, Site, and Store all in one');
    }
}
