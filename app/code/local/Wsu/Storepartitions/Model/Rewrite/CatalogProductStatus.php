<?php
class Wsu_Storepartitions_Model_Rewrite_CatalogProductStatus extends Mage_Catalog_Model_Product_Status {
    const STATUS_AWAITING = 3;
    public static function getOptionArray() {
        $options = array(
            self::STATUS_ENABLED => Mage::helper('catalog')->__('Enabled'),
            self::STATUS_DISABLED => Mage::helper('catalog')->__('Disabled')
        );
        if (Mage::getStoreConfig('storepartitions/su/enable')) {
            $options[self::STATUS_AWAITING] = Mage::helper('catalog')->__('Awaiting approve');
        }
        return $options;
    }
    public static function getAllOptions() {
        $options            = array();
        $permissionsEnabled = Mage::getSingleton('storepartitions/role')->isPermissionsEnabled();
        $suEnabled          = Mage::getStoreConfig('storepartitions/su/enable');
        if (($permissionsEnabled && $suEnabled) && (self::_isProductNew() || self::_isProductNotApproved())) {
            $options[] = array(
                'value' => self::STATUS_AWAITING,
                'label' => Mage::helper('catalog')->__('Awaiting approve')
            );
        } else {
            $options[] = array(
                'value' => '',
                'label' => Mage::helper('catalog')->__('-- Please Select --')
            );
            foreach (self::getOptionArray() as $index => $value) {
                $options[] = array(
                    'value' => $index,
                    'label' => $value
                );
            }
            unset($options[self::STATUS_AWAITING]);
        }
        return $options;
    }
    private static function _isProductNew() {
        $request        = Mage::app()->getRequest();
        $controllerName = $request->getControllerName();
        $actionName     = $request->getActionName();
        return $controllerName == 'catalog_product' && $actionName == 'new';
    }
    private static function _isProductNotApproved() {
        $request        = Mage::app()->getRequest();
        $controllerName = $request->getControllerName();
        $actionName     = $request->getActionName();
        return $controllerName == 'catalog_product' && $actionName == 'edit' && $request->getParam('id') && !self::_isApproved($request->getParam('id'));
    }
    private static function _isApproved($id) {
        return Mage::getModel('storepartitions/approve')->isApproved($id);
    }
}