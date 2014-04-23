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

    public function quickAddAction() {
        Mage::register('store_type', 'website');
        $this->_forward('newStore');
    }
	
    public function quickAddSaveAction() {
		if ($this->getRequest()->isPost() && $postData = $this->getRequest()->getPost()) {
            if (empty($postData['root_cat'])) {
                $this->_redirect('*/*/');
                return;
            }
            $session = $this->_getSession();
		}
		
		$cDat = new Mage_Core_Model_Config();
        $SU_Helper = Mage::helper('storeutilities/utilities');
		
		$newRootCat = $SU_Helper->make_category($postData['root_cat']);
		if($newRootCat>0){
			$SU_Helper->reparentCategory($newRootCat,10);
			$siteId = $SU_Helper->make_website(array('code'=>'studentstore','name'=>'Student store'));
			if( $siteId>0 ){
				$storeGroupId = $SU_Helper->make_storeGroup( array('name'=>'Student Store'), 'student.store.mage.dev', $siteId, $newRootCat );
				if( $storeGroupId>0 ){
					$storeId = $SU_Helper->make_store( $siteId, $storeGroupId, array('code'=>'studentstore','name'=>'base default veiw') );
					if( $storeId>0 ){
						$SU_Helper->moveStoreProducts( $siteId, $storeId, $newRootCat );
						$storeCmsLayouts = array(
							'col1'=>array(
								'twelfths'=>'seven-twelfths',
								'blocks'=>array(
									'blocktop'=>'<a href="{{store direct_url="#"}}"> <img src="{{storemedia url="/lefttop_ad_block.jpg"}}" alt="" border="0" /> </a>',
									'blockbottom'=>'<img src="{{storemedia url="/rightbottom_ad_block.jpg"}}" alt="" border="0" />'
								)
							),
							'col2'=>array(
								'twelfths'=>'five-twelfths',
								'blocks'=>array(
									'blocktop'=>'<img src="{{storemedia url="/trasparent-placeholder-missing-image.png"}}" alt=""  border="0" />',
									'blockbottom'=>'<img src="{{storemedia url="/trasparent-placeholder-missing-image.png"}}" alt=""  border="0" />'
								)
							)
						);
						$CMShtml="";
						foreach($storeCmsLayouts as $col=>$part){
							$CMShtml.="<div class='column ".$part['twelfths']."'>".$part['blocks']['blocktop'].$part['blocks']['blockbottom']."</div>";
						}
						$SU_Helper->createCmsPage($storeId,array(
							'title' => 'Student store',
							'identifier' => 'home',
							'content_heading' => '',
							'is_active' => 1,
							'stores' => array($storeId),//available for all store views
							'content' => str_replace('{CMShtml}',$CMShtml,$defaultCmsPage)
						));
						
						$cDat->saveConfig('wsu_themecontrol_design/spine/spine_color', 'crimson', 'websites', $siteId);
						$cDat->saveConfig('wsu_themecontrol_design/spine/spine_tool_bar_color', 'lighter', 'websites', $siteId);
						$cDat->saveConfig('wsu_themecontrol_design/spine/spine_bleed', '0', 'websites', $siteId);
						$cDat->saveConfig('wsu_themecontrol_design/spine/max_width', '1188', 'websites', $siteId);
						$cDat->saveConfig('wsu_themecontrol_design/spine/fluid_width', 'hybrid', 'websites', $siteId);
					}
				}
			}
		}

		
		
		
    }
	


}

