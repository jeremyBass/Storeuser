<?php
class Wsu_Storepartitions_Model_Rewrite_AdminSystemConfigSourceWebsite extends Mage_Adminhtml_Model_System_Config_Source_Website{
    public function toOptionArray(){
        $this->_options = parent::toOptionArray();
        $role = Mage::getSingleton('storepartitions/role');

        if ($role->isPermissionsEnabled()){
            foreach ($this->_options as $id => $website){
                if (!in_array($website['value'], $role->getAllowedWebsiteIds())){
                    unset($this->_options[$id]);
                }
            }
        }
        return $this->_options;
    }
}