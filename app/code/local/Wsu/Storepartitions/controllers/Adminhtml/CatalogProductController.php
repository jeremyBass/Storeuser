<?php
class Wsu_Storepartitions_Adminhtml_CatalogProductController extends Mage_Adminhtml_Controller_Action {

    public function massOwnerAction() {
        $productIds = (array)$this->getRequest()->getParam('product');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
        $owner      = (int)$this->getRequest()->getParam('created_by');

        try {
            Mage::getSingleton('catalog/product_action')
                ->updateAttributes($productIds, array('created_by' => $owner), $storeId);

            $this->_getSession()->addSuccess(
                $this->__('Total of %d record(s) have been updated.', count($productIds))
            );
        }
        catch (Mage_Core_Model_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()->addException($e, $this->__('An error occurred while updating the product(s) owners.'));
        }
        $this->_redirect('adminhtml/catalog_product/', array('store'=> $storeId));
    }     
}