<?php
class Wsu_Storepartitions_Block_Rewrite_AdminCatalogCategoryTabAttributes extends Mage_Adminhtml_Block_Catalog_Category_Tab_Attributes {
	
    protected function _setFieldset($attributes, $fieldset, $exclude=array()) {
        parent::_setFieldset($attributes, $fieldset, $exclude);

        if(!Mage::getStoreConfig('admin/sucategories/enable')) {
            return;
		}

        $elements = $fieldset->getSortedElements();
        $role = Mage::getSingleton('storepartitions/role');
        $catId = Mage::app()->getRequest()->getParam('id');

        if(isset($catId)){
            if ($role->isPermissionsEnabled()){
                if(Mage::getModel('storepartitions/approvecategory')->isCategoryApproved($catId)){
                    //do nothing
                }
                else{
                    foreach($elements as $elem){
                        if($elem->getName() === 'is_active'){
                            $newValues = $this->getAitAllOptions();
                            $elem->setValues($newValues);                            
                        }
                    }
                }
            } else{
                if(Mage::getModel('storepartitions/approvecategory')->isCategoryApproved($catId)){
                    //do nothing
                } else{
                    foreach($elements as $elem){
                        if($elem->getName() === 'is_active'){
                            $oldValues = $elem->getValues();
                            $newValues = $this->getAitAllOptionsEmpty();
                            $values = array_merge($oldValues, $newValues);
                            $elem->setValues($values);                          
                        }
                    }
                }                
            }
        } else{
            if ($role->isPermissionsEnabled()){
                foreach($elements as $elem){
                    if($elem->getName() === 'is_active'){                        
                        $newValues = $this->getAitAllOptions();
                        $elem->setValues($newValues);
                    }
                }
            }
            else{
                //do nothing
            }
        }       
    }

    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAitAllOptions() {        
            $this->_options = array(
                array(
                    'label' => Mage::helper('storepartitions')->__('AWAITING APPROVE'),
                    'value' =>  '00'
                ),                
            );
        
        return $this->_options;
    }

    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAitAllOptionsEmpty() {        
            $this->_options = array(
                array(
                    'label' => Mage::helper('catalog')->__('-- Please Select --'),    
                    'value' =>  '00', 
                ),                
            );
        
        return $this->_options;
    }
}