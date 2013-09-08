<?php
class Wsu_Storeuser_Model_Rewrite_AdminSalesOrderCreate extends Mage_Adminhtml_Model_Sales_Order_Create {
    public function initFromOrder(Mage_Sales_Model_Order $order) {
        try {
            parent::initFromOrder($order);
        }
        catch (Exception $e) {
            return Mage::app()->getFrontController()->getResponse()->setRedirect(getenv("HTTP_REFERER"));
        }
        return $this;
    }
}