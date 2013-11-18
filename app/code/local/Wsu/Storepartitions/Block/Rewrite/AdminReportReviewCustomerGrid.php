<?php
class Wsu_Storepartitions_Block_Rewrite_AdminReportReviewCustomerGrid extends Mage_Adminhtml_Block_Report_Review_Customer_Grid {
    protected function _prepareCollection() {
        $collection = Mage::getResourceModel('reports/review_customer_collection')->joinCustomers();
        if (!Mage::helper('storepartitions')->isShowingAllCustomers()) {
            $role = Mage::getSingleton('storepartitions/role');
            if ($role->isPermissionsEnabled()) {
                $collection->getSelect()->joinInner(array(
                    '_table_customer' => Mage::getSingleton('core/resource')->getTableName('customer_entity')
                ), ' _table_customer.entity_id = detail.customer_id ', array());
                $collection->addFieldToFilter('website_id', array(
                    'in' => $role->getAllowedWebsiteIds()
                ));
            }
        }
        $this->setCollection($collection);
        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }
}