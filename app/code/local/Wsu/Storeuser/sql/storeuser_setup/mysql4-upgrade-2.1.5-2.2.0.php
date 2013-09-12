<?php


$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('wsu_storeuser_advancedrole')}` ADD `storeview_ids` text NOT NULL AFTER `store_id` ;

ALTER TABLE `{$this->getTable('wsu_storeuser_advancedrole')}` DROP INDEX `role_id` ;

ALTER TABLE `{$this->getTable('wsu_storeuser_advancedrole')}` DROP INDEX `store_id` ;

ALTER TABLE `{$this->getTable('wsu_storeuser_advancedrole')}` ADD INDEX ( `store_id` ) ;

");

$RoleCollection = Mage::getModel('storeuser/advancedrole')->getCollection();

foreach ($RoleCollection as $Role)
{
    if ($Role->getStoreId()) 
    {
    	$StoreId = Mage::getModel('core/store')->load($Role->getStoreId())->getGroupId();

    	$Role->setData('storeview_ids', $Role->getStoreId());
    	$Role->setData('store_id', $StoreId);
    	
    	$Role->save();
    }
}

$installer->endSetup();