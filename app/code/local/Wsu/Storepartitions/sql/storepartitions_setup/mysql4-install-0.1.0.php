<?php


$installer = $this;

$installer->startSetup();

$table_advancedrole = $installer->getTable('wsu_storepartitions_advancedrole');
$installer->run("
	DROP TABLE IF EXISTS `{$table_advancedrole}`;
	CREATE TABLE `{$table_advancedrole}` (
		`advancedrole_id` smallint(5) unsigned NOT NULL auto_increment,
		`role_id` int(10) unsigned NOT NULL,
		`website_id` SMALLINT( 5 ) UNSIGNED NOT NULL,
		`store_id` smallint(5) unsigned NOT NULL,
		`storeview_ids` text NOT NULL,
		`category_ids` text NOT NULL,
		`can_edit_global_attr` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
		`can_create_products` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
		`can_edit_own_products_only` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
		`can_add_store_views` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
		`can_edit_store_views` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
		`can_add_store_groups` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
		`can_edit_store_groups` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
		`can_add_web_sites` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
		`can_edit_web_sites` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
		`manage_orders_own_products_only` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
		PRIMARY KEY  (`advancedrole_id`),
		UNIQUE KEY `role_id` (`role_id`),
		KEY `store_id` (`store_id`)
	) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='Role definitions';
");
//ok fix this up some ok? yeah ok, well it anit right is it? no.. but.. but what.. blaaaa
/*
ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` ADD INDEX ( `website_id` ) ;
ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` DROP INDEX `role_id` ;
ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` DROP INDEX `store_id` ;

$installer->run(" ALTER TABLE `{$this->getTable('wsu_storepartitions_advancedrole')}` ADD INDEX ( `store_id` ) ; ");
*/


$table_approvedproducts = $installer->getTable('wsu_storepartitions_approvedproducts');
$installer->run("
	DROP TABLE IF EXISTS `{$table_approvedproducts}`;
	CREATE TABLE `{$table_approvedproducts}` (
	  `id` smallint(5) unsigned NOT NULL auto_increment,
	  `product_id` int(10) unsigned NOT NULL,
	  `is_approved` smallint(1) unsigned NOT NULL,
	  PRIMARY KEY  (`id`),
	  KEY `product_id` (`product_id`)
	) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='Product Approval Status';
");

$table_approvedcategories = $installer->getTable('wsu_storepartitions_approvedcategories');
$installer->run("
	DROP TABLE IF EXISTS `{$table_approvedcategories}`;
	CREATE TABLE `{$table_approvedcategories}` (
	  `id` smallint(5) unsigned NOT NULL auto_increment,
	  `category_id` smallint(5) unsigned NOT NULL,
	  `is_approved` smallint(1) unsigned NOT NULL,
	  PRIMARY KEY  (`id`),
	  KEY `category_id` (`category_id`)
	) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='Category Approval Status';
");


$table_editor_attribute = $installer->getTable('wsu_storepartitions_editor_attribute');
$installer->run($sql = "
DROP TABLE IF EXISTS `{$table_editor_attribute}`;
CREATE TABLE IF NOT EXISTS {$table_editor_attribute} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned  NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `is_allow` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FC_WSU_SP_EDITOR_ATTRIBUTE_ROLE_ID` FOREIGN KEY (`role_id`) REFERENCES {$this->getTable('admin/role')} (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  KEY `role_id` (`role_id`,`attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci COMMENT='editor attribute';
    
");

$table_editor_tab = $installer->getTable('wsu_storepartitions_editor_tab');
$installer->run($sql = "
DROP TABLE IF EXISTS `{$table_editor_tab}`;
CREATE TABLE IF NOT EXISTS {$table_editor_tab} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned  NOT NULL,
  `tab_code` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FC_WSU_SP_EDITOR_TAB_ROLE_ID` FOREIGN KEY (`role_id`) REFERENCES {$this->getTable('admin/role')} (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci COMMENT='editor tab';
    
");

$table_editor_type = $installer->getTable('wsu_storepartitions_editor_type');
$installer->run($sql = "
DROP TABLE IF EXISTS `{$table_editor_type}`;
CREATE TABLE IF NOT EXISTS {$table_editor_type} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned  NOT NULL,
  `type` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FC_WSU_SP_EDITOR_TYPE_ROLE_ID` FOREIGN KEY (`role_id`) REFERENCES {$this->getTable('admin/role')} (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci COMMENT='editor type';
");

$catalogInstaller = Mage::getResourceModel('catalog/setup', 'catalog_setup');
$catalogInstaller->addAttribute('catalog_product', 'created_by', array( 'type' => 'int', 'visible'  => false, 'required' => false ));

$catalogInstaller->updateAttribute('catalog_product', 'created_by', 'is_visible', '1'); 
$catalogInstaller->updateAttribute('catalog_product', 'created_by', 'source_model', 'storepartitions/source_admins'); 
$catalogInstaller->updateAttribute('catalog_product', 'created_by', 'frontend_label', 'Product owner'); 
$catalogInstaller->updateAttribute('catalog_product', 'created_by', 'frontend_input', 'select'); 
$catalogInstaller->updateAttribute('catalog_product', 'created_by', 'source_model', 'Wsu_Storepartitions_Model_Source_Admins');

$installer->endSetup(); 