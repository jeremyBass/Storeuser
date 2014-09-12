<?php
class Wsu_Storepartitions_Model_Rewrite_AdminhtmlConfigData extends Mage_Adminhtml_Model_Config_Data{
    public function load(){
        if ($this->getSection() != Mage::app()->getRequest()->getParam('section')) {
            $this->setSection(Mage::app()->getRequest()->getParam('section'));
            $this->_configData = null;
        }
        return parent::load();
    }
}