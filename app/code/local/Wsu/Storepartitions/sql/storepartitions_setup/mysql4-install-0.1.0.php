<?php


$installer = $this;

$installer->startSetup();

$installer->run("
	CREATE TABLE IF NOT EXISTS {$this->getTable('wsu_storepartitions_advancedrole')} (
	  `advancedrole_id` smallint(5) unsigned NOT NULL auto_increment,
	  `role_id` int(10) unsigned NOT NULL,
	  `website_id` SMALLINT( 5 ) UNSIGNED NOT NULL,
	  `store_id` smallint(5) unsigned NOT NULL,
	  `storeview_ids` text NOT NULL,
	  `category_ids` text NOT NULL,
	  `can_edit_global_attr` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
	  `can_edit_own_products_only` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
	  `can_add_store_views` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
	  `can_edit_store_views` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
	  `can_add_store_groups` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
	  `can_edit_store_groups` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
	  `can_add_web_sites` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
	  `can_edit_web_sites` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
	  PRIMARY KEY  (`advancedrole_id`),
	  UNIQUE KEY `role_id` (`role_id`),
	  KEY `store_id` (`store_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
");
//ok fix this up some ok? yeah ok, well it anit right is it? no.. but.. but what.. blaaaa
/*
ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` ADD INDEX ( `website_id` ) ;
ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` DROP INDEX `role_id` ;
ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` DROP INDEX `store_id` ;
*/
$installer->run(" ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` ADD INDEX ( `store_id` ) ; ");

$installer->run($sql = "
	CREATE TABLE IF NOT EXISTS {$this->getTable('wsu_storepartitions_approvedproducts')} (
	  `id` smallint(5) unsigned NOT NULL auto_increment,
	  `product_id` int(10) unsigned NOT NULL,
	  `is_approved` smallint(1) unsigned NOT NULL,
	  PRIMARY KEY  (`id`),
	  KEY `product_id` (`product_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
    
");
$installer->run($sql = "
	CREATE TABLE IF NOT EXISTS {$this->getTable('wsu_storepartitions_approvedcategories')} (
	  `id` smallint(5) unsigned NOT NULL auto_increment,
	  `category_id` smallint(5) unsigned NOT NULL,
	  `is_approved` smallint(1) unsigned NOT NULL,
	  PRIMARY KEY  (`id`),
	  KEY `category_id` (`category_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
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

$catalogInstaller = Mage::getResourceModel('catalog/setup', 'catalog_setup');
$catalogInstaller->addAttribute('catalog_product', 'created_by', array( 'type' => 'int', 'visible'  => false, 'required' => false ));

$installer->updateAttribute('catalog_product', 'created_by', 'is_visible', '1'); 
$installer->updateAttribute('catalog_product', 'created_by', 'source_model', 'storepartitions/source_admins'); 
$installer->updateAttribute('catalog_product', 'created_by', 'frontend_label', 'Product owner'); 
$installer->updateAttribute('catalog_product', 'created_by', 'frontend_input', 'select'); 
$installer->updateAttribute('catalog_product', 'created_by', 'source_model', 'Wsu_Storepartitions_Model_Source_Admins'); 

$installer->endSetup(); 