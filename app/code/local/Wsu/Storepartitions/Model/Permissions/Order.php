<?php
class Wsu_Storepartitions_Model_Permissions_Order extends Wsu_Storepartitions_Model_Permissions_Abstract{
    public function canManageOrdersOwnProductsOnly($roleId = null){
        return $this->getPermission('manage_orders_own_products_only', $roleId) &&
            $this->getPermission('can_edit_own_products_only', $roleId);
    }
    public function getIdsForOwnerByItemsName($itemName){
        $products = Mage::getModel('catalog/product')->getCollection();
        $idSubAdmin = Mage::getSingleton('admin/session')->getUser()->getId();

        $products->addAttributeToFilter('created_by', $idSubAdmin);
        $fieldParentName = 'parent_id';
        if($itemName == 'order'){
            $fieldParentName = 'order_id';
        }
        $select = $products->getSelect();
        $select->joinInner(array('items_table'=>'sales_flat_'.$itemName.'_item'), 'e.entity_id = items_table.product_id', array('items_table.'.$fieldParentName));
        $idsFilter = array();
        foreach($select->query()->fetchAll() as $item){
            $idsFilter[] = $item[$fieldParentName];
        }
        return $idsFilter;
    }
}