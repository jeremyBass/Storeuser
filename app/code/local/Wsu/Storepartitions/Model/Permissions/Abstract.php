<?php
class Wsu_Storepartitions_Model_Permissions_Abstract extends Mage_Core_Model_Abstract{
    protected $_roleId = 0;
    protected $_role = null;

    protected function _construct(){
        if (Mage::app()->getStore()->isAdmin()){
            $session = Mage::getSingleton('admin/session');
            if ($user = $session->getUser()){
                $this->_getRole($user->getRole()->getId());
            }
        }
        return parent::_construct();
    }

    protected function _getRole($roleId = null){
        if(!empty($roleId)){
            $this->_roleId = $roleId;
        }

        if(empty($this->_roleId)){
            return false;
        }

        if(empty($this->_role) || $this->_role->getRoleId() != $this->_roleId){
            $this->_role = Mage::getModel('storepartitions/advancedrole')->load($this->_roleId, 'role_id');
        }
        return $this->_role;
    }

    public function getPermission($permission, $roleId = null){
        if($role = $this->_getRole($roleId)){
            return $role->getData($permission);
        }
        return false;
    }
}