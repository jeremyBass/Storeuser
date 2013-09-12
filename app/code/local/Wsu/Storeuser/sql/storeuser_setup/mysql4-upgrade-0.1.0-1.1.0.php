<?php


$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE IF NOT EXISTS {$this->getTable('wsu_storeuser_advancedrole')} (
  `advancedrole_id` smallint(5) unsigned NOT NULL auto_increment,
  `role_id` int(10) unsigned NOT NULL,
  `store_id` smallint(5) unsigned NOT NULL,
  `category_ids` text NOT NULL,
  PRIMARY KEY  (`advancedrole_id`),
  UNIQUE KEY `role_id` (`role_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

");

$installer->run("

ALTER TABLE `{$this->getTable('wsu_storeuser_advancedrole')}` ADD `website_id` SMALLINT( 5 ) UNSIGNED NOT NULL AFTER `role_id` ;

ALTER TABLE `{$this->getTable('wsu_storeuser_advancedrole')}` ADD INDEX ( `website_id` ) ;

");

$installer->endSetup(); 