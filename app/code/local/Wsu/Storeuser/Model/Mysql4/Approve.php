<?php
class Wsu_Storeuser_Model_Mysql4_Approve extends Mage_Core_Model_Mysql4_Abstract{
    protected function _construct(){
        $this->_init('storeuser/approve', 'id');
    }
} 