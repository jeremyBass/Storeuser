<?php
class Wsu_Storepartitions_Block_Rewrite_AdminCustomerEditTabViewOrders extends Mage_Adminhtml_Block_Customer_Edit_Tab_View_Orders {

    protected function _prepareCollection() {

        $collection = Mage::getResourceModel('sales/order_grid_collection')
            ->addFieldToFilter('customer_id', Mage::registry('current_customer')->getId())
            ->setIsCustomerMode(true);
        $role              = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled()) {
            $collection->addIdFilter($role->getAllowedWebsiteIds());
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }


} 