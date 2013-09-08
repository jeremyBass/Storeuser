<?php
class Wsu_Storeuser_Block_Rewrite_AdminTagStoreSwitcher extends Wsu_Storeuser_Block_Rewrite_AdminStoreSwitcher {
    public function __construct() {
        parent::__construct();
        $this->setUseConfirm(false)->setSwitchUrl($this->getUrl('*/*/*/', array(
            'store' => null,
            '_current' => true
        )));
    }
}