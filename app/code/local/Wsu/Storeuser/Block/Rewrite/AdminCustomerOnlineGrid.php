<?php
class Wsu_Storeuser_Block_Rewrite_AdminCustomerOnlineGrid extends Mage_Adminhtml_Block_Customer_Online_Grid {
    protected function _prepareCollection() {
        /* @var $collection Mage_Log_Model_Mysql4_Visitor_Online_Collection */
        $collection = Mage::getModel('log/visitor_online')->prepare()->getCollection();
        $collection->addCustomerData();
        $role = Mage::getSingleton('storeuser/role');
        if ($role->isPermissionsEnabled()) {
            $collection->getSelect()->where('`customer_email`.website_id IN (' . implode(',', $role->getAllowedWebsiteIds()) . ')');
        }
        $this->setCollection($collection);
        Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
        return $this;
    }
}