<?php
class Wsu_Storepartitions_Block_Rewrite_AdminSalesOrderGrid extends Mage_Adminhtml_Block_Sales_Order_Grid {
    protected function _prepareColumns() {
        parent::_prepareColumns();
        $role = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled()) {
            $allowedStoreviews = $role->getAllowedStoreviewIds();
            if (count($allowedStoreviews) <= 1 && isset($this->_columns['store_id'])) {
                unset($this->_columns['store_id']);
            }
        }
        return $this;
    }
}