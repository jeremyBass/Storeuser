<?php
class Wsu_Storepartitions_Model_Editor_Type extends Mage_Core_Model_Abstract {
    protected function _construct(){
        $this->_init('storepartitions/editor_type');
    }
    public function deleteRole($roleId){
        $recordCollection = $this->getCollection()->loadByRoleId($roleId);
        if ($recordCollection->getSize()){
            foreach ($recordCollection as $record){
                $record->delete();
            }
        }
    }
    public function getRestrictedTypes($roleId){
        $types = array();
        $recordCollection = $this->getCollection()->loadByRoleId($roleId);
        if ($recordCollection->getSize()){
            foreach ($recordCollection as $record){
                $types[] = $record->getType();
            }
        }
        if(count($types) > 0){
            return $types;
        }
        return false;
    }    
}