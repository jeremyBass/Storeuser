<?php
class Wsu_Storepartitions_Model_Notification extends Mage_Core_Model_Abstract {
    const XML_PATH_EMAIL_SENDER = 'contacts/email/sender_email_identity';
    public function send($product) {
        $suEmail = Mage::getStoreConfig('storepartitions/su/email');
        if ('' == $suEmail) {
            $suEmail = Mage::getStoreConfig('trans_email/ident_sales/email');
        }
        $vars    = (array) $this->_prepareVars($product);
        $name    = 'Store Partitions Notification';
        $storeId = $product->getStoreId();
        Mage::getSingleton('core/translate')->setTranslateInline(false);
        $mailTemplate = Mage::getModel('core/email_template');
        $mailTemplate->setDesignConfig(array(
            'area' => 'frontend',
            'store' => $storeId
        ));
        $mailTemplate->setTemplateSubject($name);
        $emailId = Mage::getStoreConfig('storepartitions/su/template', $storeId);
        $mailTemplate->sendTransactional($emailId, Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER, $storeId), $suEmail, $name, $vars);
        Mage::getSingleton('core/translate')->setTranslateInline(true);
        return $mailTemplate->getSentSuccess();
    }
    protected function _prepareVars($product) {
        return array(
            'product_name' => $product->getName(),
            'product_sku' => $product->getSku(),
            'product_price' => $product->getPrice(),
            'admin_name' => Mage::getSingleton('admin/session')->getUser()->getName(),
            'website' => Mage::getBaseUrl()
        );
    }
    public function sendCategoryForApproving(Mage_Catalog_Model_Category $category) {
        $suEmail = Mage::getStoreConfig('storepartitions/sucategories/email');
        if ('' == $suEmail) {
             $suEmail = Mage::getStoreConfig('trans_email/ident_sales/email');
        }
        $vars = (array)$this->_prepareVarsForCategoryApproving($category);
        $name = 'Store Partitions Notification';
        $storeId = $category->getStoreId();
        Mage::getSingleton('core/translate')->setTranslateInline(false);        
        $mailTemplate = Mage::getModel('core/email_template');
        $mailTemplate->setDesignConfig(array('area' => 'frontend', 'store' => $storeId));
        $mailTemplate->setTemplateSubject($name);
        $emailId = Mage::getStoreConfig('storepartitions/sucategories/template', $storeId);
        $mailTemplate->sendTransactional(
            $emailId, 
            Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER, $storeId),
            $suEmail,
            $name,
            $vars
        );
        Mage::getSingleton('core/translate')->setTranslateInline(true);
        return $mailTemplate->getSentSuccess();
    }

    protected function _prepareVarsForCategoryApproving(Mage_Catalog_Model_Category $category){
        return array(
            'category_name' => $category->getName(),
            'category_id' => $category->getId(),            
            'admin_name' => Mage::getSingleton('admin/session')->getUser()->getName(),
            'website' => Mage::getBaseUrl(),
        );
    }
	
}