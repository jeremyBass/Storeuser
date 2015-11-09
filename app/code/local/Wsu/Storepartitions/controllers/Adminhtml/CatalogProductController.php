<?php
class Wsu_Storepartitions_Adminhtml_CatalogProductController extends Mage_Adminhtml_Controller_Action {
    public function massOwnerAction() {
        $productIds = (array)$this->getRequest()->getParam('product');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
        $owner      = (int)$this->getRequest()->getParam('created_by');

        try {
			if (!Mage::getModel('catalog/product')->isProductsHasSku($productIds)) {
                throw new Mage_Core_Exception(
                    $this->__('In order to perform changes all products must have skus.')
                );
            }
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
	public function validateAction() {
		$storeId    = (int)$this->getRequest()->getParam('store', 0);
		$require_cat = Mage::getStoreConfig('storepartitions/sucategories/require_cat', $storeId);
		
		if($require_cat){
			$response = new Varien_Object();
			$response->setError(false);

			try {
				$productData = $this->getRequest()->getPost('product');

				if ($productData && !isset($productData['stock_data']['use_config_manage_stock'])) {
					$productData['stock_data']['use_config_manage_stock'] = 0;
				}
				/* @var $product Mage_Catalog_Model_Product */
				$product = Mage::getModel('catalog/product');
				$product->setData('_edit_mode', true);
				if ($storeId = $this->getRequest()->getParam('store')) {
					$product->setStoreId($storeId);
				}
				if ($setId = $this->getRequest()->getParam('set')) {
					$product->setAttributeSetId($setId);
				}
				if ($typeId = $this->getRequest()->getParam('type')) {
					$product->setTypeId($typeId);
				}
				if ($productId = $this->getRequest()->getParam('id')) {
					$product->load($productId);
				}
				//==>start my changes
				$postedCategories = $this->getRequest()->getParam('category_ids');
				if ($product->getId()) { //if edit mode 
					//if product does not have categories and no categories were sent...
					if (!$product->getCategoryIds() && empty($postedCategories)){
						throw new Mage_Catalog_Exception('Fill in categories'); //translate if needed
					}
				}
				else { //if new mode
					if (empty($postedCategories)){
						throw new Mage_Catalog_Exception('Fill in categories'); //translate if needed
					}
				}
				//<=== end my changes

				$dateFields = array();
				$attributes = $product->getAttributes();
				foreach ($attributes as $attrKey => $attribute) {
					if ($attribute->getBackend()->getType() == 'datetime') {
						if (array_key_exists($attrKey, $productData) && $productData[$attrKey] != ''){
							$dateFields[] = $attrKey;
						}
					}
				}
				$productData = $this->_filterDates($productData, $dateFields);
		
				$product->addData($productData);
				$product->validate();
			}
			catch (Mage_Eav_Model_Entity_Attribute_Exception $e) {
				$response->setError(true);
				$response->setAttribute($e->getAttributeCode());
				$response->setMessage($e->getMessage());
			} catch (Mage_Core_Exception $e) {
				$response->setError(true);
				$response->setMessage($e->getMessage());
			} catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
				$this->_initLayoutMessages('adminhtml/session');
				$response->setError(true);
				$response->setMessage($this->getLayout()->getMessagesBlock()->getGroupedHtml());
			}
			$this->getResponse()->setBody($response->toJson());
		}else{
			parent::validateAction();
		}
	}
}