<?php
class Wsu_Storepartitions_Model_Editor_Tab extends Mage_Core_Model_Abstract{
    protected function _construct(){
        $this->_init('storepartitions/editor_tab');
    }
    public function deleteRole($roleId){
        $recordCollection = $this->getCollection()->loadByRoleId($roleId);

        if ($recordCollection->getSize()){
            foreach ($recordCollection as $record){
                $record->delete();
            }
        }
    }
    public function getDisabledTabs($roleId){
        $tabs = array();
        $recordCollection = $this->getCollection()->loadByRoleId($roleId);
        if ($recordCollection->getSize()){
            foreach ($recordCollection as $record){
                $tabs[] = $record->getTabCode();
            }
        }
        if(count($tabs) > 0){
            return $tabs;
        }
        return false;
    }
    public function duplicateProductTabPermissions($oldRoleId, $newRoleId){
        $oldTabs = $this->getDisabledTabs($oldRoleId);
        if($oldTabs){
            foreach($oldTabs as $tab){
                $this->setData('role_id', $newRoleId);
                $this->setData('tab_code',$tab);
                $this->save();
            }
        }
    }
}