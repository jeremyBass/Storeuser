<?php
class Wsu_Storeuser_Block_Rewrite_AdminReportSalesShippingGrid extends Mage_Adminhtml_Block_Report_Sales_Shipping_Grid {
    /*
     * @return Varien_Object
     */
    public function getFilterData() {
        $filter = parent::getFilterData();
        $filter->setStoreIds(implode(',', Mage::helper('storeuser/access')->getFilteredStoreIds($filter->getStoreIds() ? explode(',', $filter->getStoreIds()) : array())));
        return $filter;
    }
}