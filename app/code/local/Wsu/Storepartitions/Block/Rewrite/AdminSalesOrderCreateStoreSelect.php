<?php
class Wsu_Storepartitions_Block_Rewrite_AdminSalesOrderCreateStoreSelect extends Mage_Adminhtml_Block_Sales_Order_Create_Store_Select {
    public function getStoreCollection($group) {
        $stores = parent::getStoreCollection($group);
        $role   = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled()) {
            $stores->addIdFilter($role->getAllowedStoreviewIds());
        }
        return $stores;
    }
}