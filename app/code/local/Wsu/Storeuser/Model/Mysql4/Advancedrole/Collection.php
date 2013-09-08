<?php
class Wsu_Storeuser_Model_Mysql4_Advancedrole_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
    protected function _construct() {
        $this->_init('storeuser/advancedrole');
    }
    public function loadByRoleId($roleId) {
        $this->addFieldToFilter('role_id', $roleId);
        $this->load();
        return $this;
    }
    public function loadByRoleAndStore($roleId, $storeId) {
        $this->addFieldToFilter('role_id', $roleId);
        $this->addFieldToFilter('store_id', $storeId);
        $this->load();
        return $this;
    }
}