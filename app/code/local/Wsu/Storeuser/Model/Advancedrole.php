<?php
class Wsu_Storeuser_Model_Advancedrole extends Mage_Core_Model_Abstract {
    protected function _construct() {
        $this->_init('storeuser/advancedrole');
    }
    public function getStoreviewIdsArray() {
        if (!$this->getStoreviewIds() || '0' == $this->getStoreviewIds()) {
            return array();
        }
        return explode(',', $this->getStoreviewIds());
    }
    public function getCategoryIdsArray() {
        if (!$this->getCategoryIds() || '0' == $this->getCategoryIds()) {
            return array();
        }
        return explode(',', $this->getCategoryIds());
    }
    public function canEditGlobalAttributes($roleId) {
        $recordCollection = $this->getCollection()->loadByRoleId($roleId);
        if ($recordCollection->getSize()) {
            return (bool) $recordCollection->getFirstItem()->getCanEditGlobalAttr();
        }
        return true;
    }
    public function canEditOwnProductsOnly($roleId) {
        $recordCollection = $this->getCollection()->loadByRoleId($roleId);
        if ($recordCollection->getSize()) {
            return (bool) $recordCollection->getFirstItem()->getCanEditOwnProductsOnly();
        }
        return true;
    }
    public function deleteRole($roleId) {
        $recordCollection = $this->getCollection()->loadByRoleId($roleId);
        if ($recordCollection->getSize()) {
            foreach ($recordCollection as $record) {
                $record->delete();
            }
        }
    }
}