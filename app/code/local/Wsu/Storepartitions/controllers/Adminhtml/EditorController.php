<?php

class Wsu_Storepartitions_Adminhtml_EditorController extends Mage_Adminhtml_Controller_Action{
    public function attributegridAction(){
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('storepartitions/adminhtml_permissions_tab_product_editor_attribute')->toHtml()
        );
    }
}