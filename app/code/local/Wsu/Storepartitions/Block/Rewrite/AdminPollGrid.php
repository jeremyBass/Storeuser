<?php
class Wsu_Storepartitions_Block_Rewrite_AdminPollGrid extends Mage_Adminhtml_Block_Poll_Grid {
    protected function _prepareCollection() {
        $collection = Mage::getModel('poll/poll')->getCollection();
        $role       = Mage::getSingleton('storepartitions/role');
        if ($role->isPermissionsEnabled()) {
            $collection->addStoreFilter($role->getAllowedStoreviewIds());
        }
        $this->setCollection($collection);
        Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
        if (!Mage::app()->isSingleStoreMode()) {
            $this->getCollection()->addStoreData();
        }
        return $this;
    }
}