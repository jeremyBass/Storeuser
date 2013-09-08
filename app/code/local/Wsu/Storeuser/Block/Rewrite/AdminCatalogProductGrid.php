<?php
class Wsu_Storeuser_Block_Rewrite_AdminCatalogProductGrid extends Mage_Adminhtml_Block_Catalog_Product_Grid {
    protected function _prepareMassaction() {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('product');
        $role = Mage::getSingleton('storeuser/role');
        if (!$role->isPermissionsEnabled() || $role->isAllowedToDelete()) {
            $this->getMassactionBlock()->addItem('delete', array(
                'label' => Mage::helper('catalog')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('catalog')->__('Are you sure?')
            ));
        }
        $statuses = Mage::getSingleton('catalog/product_status')->getOptionArray();
        array_unshift($statuses, array(
            'label' => '',
            'value' => ''
        ));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('catalog')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array(
                '_current' => true
            )),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('catalog')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        $this->getMassactionBlock()->addItem('attributes', array(
            'label' => Mage::helper('catalog')->__('Update attributes'),
            'url' => $this->getUrl('*/catalog_product_action_attribute/edit', array(
                '_current' => true
            ))
        ));
        return $this;
    }
    protected function _toHtml() {
        $allowedWebisteIds = Mage::getSingleton('storeuser/role')->getAllowedWebsiteIds();
        if (count($allowedWebisteIds) <= 1) {
            unset($this->_columns['websites']);
        }
        return parent::_toHtml();
    }
}