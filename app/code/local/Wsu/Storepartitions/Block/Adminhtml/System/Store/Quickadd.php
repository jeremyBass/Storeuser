<?php

class Wsu_Storepartitions_Block_Adminhtml_System_Store_Quickadd extends Mage_Adminhtml_Block_System_Store_Edit {
    /**
     * Init class
     *
     */
    public function __construct() {
		$this->_objectId = 'website_id';
		$saveLabel   = Mage::helper('core')->__('Save Website');
		$deleteLabel = Mage::helper('core')->__('Delete Website');
		$deleteUrl   = $this->getUrl('*/*/deleteWebsite', array('item_id' => Mage::registry('store_data')->getId()));
        $this->_controller = 'system_store';

        parent::__construct();

        $this->_updateButton('save', 'label', $saveLabel);
        $this->_updateButton('delete', 'label', $deleteLabel);
        $this->_updateButton('delete', 'onclick', 'setLocation(\''.$deleteUrl.'\');');

        if (!Mage::registry('store_data')->isCanDelete()) {
            $this->_removeButton('delete');
        }
        if (Mage::registry('store_data')->isReadOnly()) {
            $this->_removeButton('save')->_removeButton('reset');
        }
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
