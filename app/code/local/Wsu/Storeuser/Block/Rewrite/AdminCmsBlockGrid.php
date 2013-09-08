<?php
class Wsu_Storeuser_Block_Rewrite_AdminCmsBlockGrid extends Mage_Adminhtml_Block_Cms_Block_Grid {
    protected function _prepareCollection() {
        /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
        $collection = Mage::getModel('cms/block')->getCollection();
        $role       = Mage::getSingleton('storeuser/role');
        if ($role->isPermissionsEnabled()) {
            $collection->addStoreFilter($role->getAllowedStoreviewIds());
        }
        $this->setCollection($collection);
        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }
}