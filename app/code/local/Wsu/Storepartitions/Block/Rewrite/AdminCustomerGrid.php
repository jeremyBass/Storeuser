<?php
class Wsu_Storepartitions_Block_Rewrite_AdminCustomerGrid extends Mage_Adminhtml_Block_Customer_Grid {
	
	
	
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('customer/customer_collection')
            ->addNameToSelect()
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('created_at')
            ->addAttributeToSelect('group_id')
			->addAttributeToSelect('website_id')
            ->joinAttribute('billing_postcode', 'customer_address/postcode', 'default_billing', null, 'left')
            ->joinAttribute('billing_city', 'customer_address/city', 'default_billing', null, 'left')
            ->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
            ->joinAttribute('billing_region', 'customer_address/region', 'default_billing', null, 'left')
            ->joinAttribute('billing_country_id', 'customer_address/country_id', 'default_billing', null, 'left');


       
            $role = Mage::getSingleton('storepartitions/role');
            if ($role->isPermissionsEnabled()) {
				var_dump($role->getAllowedWebsiteIds());
                $collection->addFieldToFilter('website_id', array(
                    'in' => $role->getAllowedWebsiteIds()
                ));

            }
        


        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        parent::_prepareColumns();
        $role = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled()) {
            if (!Mage::helper('storepartitions')->isShowingAllCustomers() && isset($this->_columns['website_id'])) {
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