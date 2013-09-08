<?php
class Wsu_Storeuser_Block_Rewrite_AdminCmsPageGrid extends Mage_Adminhtml_Block_Cms_Page_Grid {
    protected function _prepareCollection() {
        $collection = Mage::getModel('cms/page')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $collection->setFirstStoreFlag(true);
        $role = Mage::getSingleton('storeuser/role');
        if ($role->isPermissionsEnabled()) {
            $collection->getSelect()->join(array(
                'store_table_permissions' => $collection->getTable('cms/page_store')
            ), 'main_table.page_id = store_table_permissions.page_id', array())->where('store_table_permissions.store_id in (?)', $role->getAllowedStoreviewIds())->group('main_table.page_id');
        }
        $this->setCollection($collection);
        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }
}