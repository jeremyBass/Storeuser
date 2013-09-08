<?php
class Wsu_Storeuser_Model_System_Config_Observer extends Mage_Core_Model_Abstract {
    public function onCoreLocaleSetLocale($observer) {
        if (!Mage::registry('aitpagecache_check_14') && Mage::getConfig()->getNode('modules/Wsu_Aitpagecache/active') === 'true') {
            if (file_exists(Mage::getBaseDir('magentobooster') . DS . 'use_cache.ser')) {
                Mage::register('aitpagecache_check_14', 1);
            } elseif (file_exists(Mage::getBaseDir('app/etc') . DS . 'use_cache.ser')) {
                Mage::register('aitpagecache_check_13', 1);
            }
        }
    }
}