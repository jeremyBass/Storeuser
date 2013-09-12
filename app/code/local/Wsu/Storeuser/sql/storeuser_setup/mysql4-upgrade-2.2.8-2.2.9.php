<?php


$installer = $this;

$installer->startSetup();

$installer->run($sql = '
ALTER TABLE `' . $this->getTable('wsu_storeuser_advancedrole') . '` ADD COLUMN `can_edit_global_attr` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1;
');

$installer->endSetup();
