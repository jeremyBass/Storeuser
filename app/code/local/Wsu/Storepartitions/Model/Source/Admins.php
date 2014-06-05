<?php
class Wsu_Storepartitions_Model_Source_Admins extends Mage_Eav_Model_Entity_Attribute_Source_Abstract {
    protected $_data = null;
    public function getAllOptions() {
        return $this->toOptionArray();
    }
    public function _getAllOptions() {
        if(is_null($this->_data)) {
            $this->_data = array('' => '');
            $collection = Mage::getModel('admin/user')
                ->getCollection();
            foreach($collection as $admin) {
                $this->_data[$admin->getId()] = $admin->getUsername();
            }
        }
        return $this->_data;
    }
    public function toOptionArray() {
        $array = array(
       //     array('value' => 0, 'label'=>Mage::helper('storepartitions')->__('')),
        );
        $levels = $this->_getAllOptions();
        foreach($levels as $key=>$value) {
            //$array[] = array('value' => $key, 'label'=>Mage::helper('storepartitions')->__(ucfirst($value)));
            $array[] = array('value' => $key, 'label'=>Mage::helper('storepartitions')->__($value));
        }
        return $array;
    }
    public function getOptionArray(){
        $levels = $this->_getAllOptions();
        foreach($levels as $key=>$value) {
            $array[$key] = Mage::helper('storepartitions')->__(ucfirst($value));
        }
        return $array;
    }
} 