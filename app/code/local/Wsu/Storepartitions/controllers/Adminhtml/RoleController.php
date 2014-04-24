<?php
class Wsu_Storepartitions_Adminhtml_RoleController extends Mage_Adminhtml_Controller_Action {
    public function duplicateAction() {
        $roleModel             = Mage::getModel('admin/roles');
        $wsuRoleModel          = Mage::getModel('storepartitions/advancedrole');
        $loadRole              = $roleModel->load($this->getRequest()->getParam('rid'));
        $roleName              = $loadRole->getRoleName();
        $ruleModel             = Mage::getModel("admin/rules");
        $loadRuleCollection    = $ruleModel->getCollection()->addFilter('role_id', $this->getRequest()->getParam('rid'));
        //echo "<pre>"; print_r($loadRuleCollection->getSize()); exit;
        $loadAitRoleCollection = $wsuRoleModel->getCollection()->addFilter('role_id', $this->getRequest()->getParam('rid'));
        try {
            $roleModel->setId(null)->setName('Copy of ' . $loadRole->getRoleName())->setPid($loadRole->getParentId())->setTreeLevel($loadRole->getTreeLevel())->setType($loadRole->getType())->setUserId($loadRole->getUserId())->save();
            //            foreach (explode(",",$roleModel->getUserId()) as $nRuid) {
            //                $this->_addUserToRole($nRuid, $roleModel->getId());
            //            }
            foreach ($loadRuleCollection as $rule) {
                $ruleModel->setData($rule->getData())->setRuleId(null)->setRoleId($roleModel->getId())->save();
            }
            $newRoleId = $roleModel->getRoleId();
            foreach ($loadAitRoleCollection as $loadAitRole) {
                $wsuRoleModel->setId(null)
							->setRoleId($newRoleId)
							->setWebsiteId($loadAitRole->getWebsiteId())
							->setStoreId($loadAitRole->getStoreId())
							->setStoreviewIds($loadAitRole->getStoreviewIds())
							->setCategoryIds($loadAitRole->getCategoryIds())
							->setCanEditGlobalAttr($loadAitRole->getCanEditGlobalAttr())
							->setCanEditOwnProductsOnly($loadAitRole->getCanEditOwnProductsOnly())
							->setCanAddStoreViews($loadAitRole->getCanAddStoreViews())
							->setCanEditStoreViews($loadAitRole->getCanEditStoreViews())
							->save();
            }
        }
        catch (Exception $e) {
            $this->_getSession()->addError($this->__("Role %s wasn't duplicated. %s", $roleName, $e->getMessage()));
        }
        $this->_getSession()->addSuccess($this->__("Role %s was duplicated", $roleName));
        $this->_redirect('adminhtml/permissions_role/index');
        return $this;
    }
    //    protected function _addUserToRole($userId, $roleId)
    //    {
    //        $user = Mage::getModel("admin/user")->load($userId);
    //        $user->setRoleId($roleId)->setUserId($userId);
    //
    //        if( $user->roleUserExists() === true ) {
    //            return false;
    //        } else {
    //            $user->add();
    //            return true;
    //        }
    //    }
}