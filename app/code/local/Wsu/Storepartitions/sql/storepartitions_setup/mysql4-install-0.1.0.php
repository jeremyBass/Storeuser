<?php


$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE IF NOT EXISTS {$this->getTable('wsu_storepartitions_advancedrole')} (
  `advancedrole_id` smallint(5) unsigned NOT NULL auto_increment,
  `role_id` int(10) unsigned NOT NULL,
  `store_id` smallint(5) unsigned NOT NULL,
  `category_ids` text NOT NULL,
  PRIMARY KEY  (`advancedrole_id`),
  UNIQUE KEY `role_id` (`role_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

");
//ok fix this up some ok? yeah ok, well it anit right is it? no.. but.. but what.. blaaaa
$installer->run("
ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` ADD `website_id` SMALLINT( 5 ) UNSIGNED NOT NULL AFTER `role_id` ;
ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` ADD INDEX ( `website_id` ) ;
ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` ADD `storeview_ids` text NOT NULL AFTER `store_id` ;
ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` DROP INDEX `role_id` ;
ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` DROP INDEX `store_id` ;
ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` ADD INDEX ( `store_id` ) ;
");

$RoleCollection = Mage::getModel('storepartitions/advancedrole')->getCollection();

foreach ($RoleCollection as $Role) {
    if ($Role->getStoreId()){
    	$StoreId = Mage::getModel('core/store')->load($Role->getStoreId())->getGroupId();

    	$Role->setData('storeview_ids', $Role->getStoreId());
    	$Role->setData('store_id', $StoreId);
    	
    	$Role->save();
    }
}



$installer->run($sql = '
ALTER TABLE `' . $this->getTable('wsu_storepartitions_advancedrole') . '` ADD COLUMN `can_edit_global_attr` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1;
ALTER TABLE `' . $this->getTable('wsu_storepartitions_advancedrole') . '` ADD COLUMN `can_edit_own_products_only` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1;
');

$catalogInstaller = Mage::getResourceModel('catalog/setup', 'catalog_setup');
$catalogInstaller->addAttribute('catalog_product', 'created_by', array(
    'type'     => 'int',
    'visible'  => false,
    'required' => false
));

$installer->run($sql = "
CREATE TABLE IF NOT EXISTS {$this->getTable('wsu_storepartitions_approvedproducts')} (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `product_id` int(10) unsigned NOT NULL,
  `is_approved` smallint(1) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
    
");

$installer->endSetup(); 