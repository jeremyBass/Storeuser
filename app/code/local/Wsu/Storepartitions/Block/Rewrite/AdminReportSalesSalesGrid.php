<?php
class Wsu_Storepartitions_Block_Rewrite_AdminReportSalesSalesGrid extends Mage_Adminhtml_Block_Report_Sales_Sales_Grid {
    /*
     * @return Varien_Object
     */
    public function getFilterData() {
        $filter = parent::getFilterData();
        $filter->setStoreIds(implode(',', Mage::helper('storepartitions/access')->getFilteredStoreIds($filter->getStoreIds() ? explode(',', $filter->getStoreIds()) : array())));
        return $filter;
    }
}