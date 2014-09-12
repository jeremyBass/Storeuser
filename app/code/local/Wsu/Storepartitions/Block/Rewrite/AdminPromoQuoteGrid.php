<?php
class Wsu_Storepartitions_Block_Rewrite_AdminPromoQuoteGrid extends Mage_Adminhtml_Block_Promo_Quote_Grid{
    protected function _prepareCollection() {
        /** @var $collection Mage_SalesRule_Model_Mysql4_Rule_Collection */
        $collection = Mage::getModel('salesrule/rule')->getResourceCollection();
        $collection->addWebsitesToResult();
        $role = Mage::getSingleton('storepartitions/role');

        if ($role->isPermissionsEnabled()){
            $collection->addWebsiteFilter($role->getAllowedWebsiteIds());
            $collection->setFlag('is_website_table_joined', false);
        }
        $this->setCollection($collection);
        Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns(){
        parent::_prepareColumns();
        $role = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled()){
            unset($this->_columns['rule_website']);
            $allowedWebsiteIds = $role->getAllowedWebsiteIds();
            if (count($allowedWebsiteIds) > 1){
                $websiteFilter = array();
                foreach ($allowedWebsiteIds as $allowedWebsiteId){
                    $website = Mage::getModel('core/website')->load($allowedWebsiteId);
                    $websiteFilter[$allowedWebsiteId] = $website->getData('name');
                }
                $this->addColumn('rule_website', array(
                    'header'    => Mage::helper('salesrule')->__('Website'),
                    'align'     =>'left',
                    'index'     => 'website_ids',
                    'type'      => 'options',
                    'sortable'  => false,
                    'options'   => $websiteFilter,
                    'width'     => 200
                ));
            }
        }
        return $this;
    }
}