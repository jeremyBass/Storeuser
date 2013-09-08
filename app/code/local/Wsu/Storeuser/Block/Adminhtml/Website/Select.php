<?php
class Wsu_Storeuser_Block_Adminhtml_Website_Select extends Mage_Core_Block_Template {
    protected $_websiteIds = null;
    public function __construct() {
        parent::__construct();
        $this->setTemplate('storeuser/website_select.phtml');
    }
    public function getWebsites() {
        $websites = Mage::app()->getWebsites();
        if ($websiteIds = $this->getWebsiteIds()) {
            foreach ($websites as $websiteId => $website) {
                if (!in_array($websiteId, $websiteIds)) {
                    unset($websites[$websiteId]);
                }
            }
        }
        return $websites;
    }
    public function setCurrentWebsiteIds($websiteIds) {
        $this->_websiteIds = $websiteIds;
        return $this;
    }
    public function getCurrentWebsiteIds() {
        return $this->_websiteIds;
    }
}