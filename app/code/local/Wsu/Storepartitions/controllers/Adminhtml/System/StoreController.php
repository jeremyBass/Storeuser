<?php
require_once(Mage::getModuleDir('controllers','Mage_Adminhtml').DS.'System'.DS.'StoreController.php');
class Wsu_Storepartitions_Adminhtml_System_StoreController extends Mage_Adminhtml_System_StoreController {

    /**
     * Init actions
     *
     * @return Mage_Adminhtml_Cms_PageController
     */
    protected function _initAction() {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('system/store')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('System'), Mage::helper('adminhtml')->__('System'))
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Stores'), Mage::helper('adminhtml')->__('Manage Stores'))
        ;
        return $this;
    }

    public function quickAddAction()
    {
        Mage::register('store_type', 'website');
        $this->_forward('newStore');
    }


}

