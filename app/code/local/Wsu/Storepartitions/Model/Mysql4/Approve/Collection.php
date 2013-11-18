<?php
class Wsu_Storepartitions_Model_Mysql4_Approve_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
    protected function _construct() {
        $this->_init('storepartitions/approve');
    }
    public function loadByProductId($productId) {
        $this->addFieldToFilter('product_id', $productId);
        return $this;
    }
}