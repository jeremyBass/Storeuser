<?php
class Wsu_Storepartitions_Block_Cart_Sidebar extends Mage_Checkout_Block_Cart_Sidebar {
	/**
     * Retrieve shopping cart url
     *
     * @return string
     */
    public function getMainStoreUrl($arg='checkout/cart'){
		$storeId = 1;//pick up from setting.. look to latter but hard code now
		return Mage::app()->getStore($storeId)->getUrl($arg);
        return $this->_getUrl($arg);
    }

	/**
     * Retrieve shopping cart url
     *
     * @return string
    
    public function getUrl($arg='checkout/cart'){
		$storeId = 1;//pick up from setting.. look to latter but hard code now
		return Mage::app()->getStore($storeId)->getUrl($arg);
        return $this->_getUrl($arg);
    }
	 */

}
