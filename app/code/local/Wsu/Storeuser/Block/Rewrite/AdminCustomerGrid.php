<?php
class Wsu_Storeuser_Block_Rewrite_AdminCustomerGrid extends Mage_Adminhtml_Block_Customer_Grid {
    protected function _prepareColumns() {
        parent::_prepareColumns();
        $role = Mage::getSingleton('storeuser/role');
        if ($role->isPermissionsEnabled()) {
            if (!Mage::helper('storeuser')->isShowingAllCustomers() && isset($this->_columns['website_id'])) {
                unset($this->_columns['website_id']);
                $allowedWebsiteIds = $role->getAllowedWebsiteIds();
                if (count($allowedWebsiteIds) > 1) {
                    $websiteFilter = array();
                    foreach ($allowedWebsiteIds as $allowedWebsiteId) {
                        $website                          = Mage::getModel('core/website')->load($allowedWebsiteId);
                        $websiteFilter[$allowedWebsiteId] = $website->getData('name');
                    }
                    $this->addColumn('website_id', array(
                        'header' => Mage::helper('customer')->__('Website'),
                        'align' => 'center',
                        'width' => '80px',
                        'type' => 'options',
                        'options' => $websiteFilter,
                        'index' => 'website_id'
                    ));
                }
            }
        }
        return $this;
    }
}