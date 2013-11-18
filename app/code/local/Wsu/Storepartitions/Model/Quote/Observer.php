<?php
class Wsu_Storepartitions_Model_Quote_Observer extends Mage_Core_Model_Abstract {
    public function onControllerFrontInitRouters($observer) {
        if (!Mage::registry('wsupagecache_check_14') && Mage::getConfig()->getNode('modules/Wsu_Wsupagecache/active') === 'true') {
            if (file_exists(Mage::getBaseDir('magentobooster') . DS . 'use_cache.ser')) {
                Mage::register('wsupagecache_check_14', 1);
            } elseif (file_exists(Mage::getBaseDir('app/etc') . DS . 'use_cache.ser')) {
                Mage::register('wsupagecache_check_13', 1);
            }
        }
    }
}