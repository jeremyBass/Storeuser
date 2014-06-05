<?php
class Wsu_Storepartitions_Model_Mysql4_Approvecategory_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
    protected function _construct() {
        $this->_init('storepartitions/approvecategory');
    }

    public function loadByCategoryId($categoryId) {
        $this->addFieldToFilter('category_id', $categoryId);
        return $this;
    }
}