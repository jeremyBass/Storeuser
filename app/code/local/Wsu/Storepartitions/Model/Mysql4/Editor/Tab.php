<?php
class Wsu_Storepartitions_Model_Mysql4_Editor_Tab extends Mage_Core_Model_Mysql4_Abstract{
    protected function _construct(){
        $this->_init('storepartitions/editor_tab', 'id');
    }
}