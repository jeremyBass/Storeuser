<?php
require_once(Mage::getModuleDir('controllers','Mage_Adminhtml').DS.'System'.DS.'StoreController.php');
class Wsu_Storepartitions_Adminhtml_System_StoreController extends Mage_Adminhtml_System_StoreController {
    const CSV_SEPARATOR   = ',';
    const CSV_ENCLOSED_BY = '"';
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
		$model      = Mage::getModel('core/website');
		Mage::register('store_data', $model);
		
		
		$this->_initAction()
			->_addContent($this->getLayout()->createBlock('adminhtml/system_store_quickadd'))
			->renderLayout();
        //$this->_forward('newStore');
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
		$SP_Helper = Mage::helper('storepartitions');
		
		$newRootCat = $SU_Helper->make_category($postData['root_cat']);
		if($newRootCat>0){
			Mage::getSingleton('adminhtml/session')->addSuccess( $SP_Helper->__('Created the new root category of')." <b>". $postData['root_cat']."</b>" );
			
			$siteId = $SU_Helper->make_website(array(
							'code'=>$postData['website']['code'],
							'name'=>$postData['website']['name']
						));
			if( $siteId>0 ){
				Mage::getSingleton('adminhtml/session')->addSuccess( $postData['website']['name']."(id: ${siteId}) ".Mage::helper('storeutilities')->__('Web Site was created') );
				
				$storeGroupId = $SU_Helper->make_storeGroup( array(
						'name'=>$postData['storegroup']['name']
					),
					$postData['storegroup']['baseurl'],
					$siteId, $newRootCat
				 );
				if( $storeGroupId>0 ){
					Mage::getSingleton('adminhtml/session')->addSuccess( $postData['storegroup']['name']." [".$postData['storegroup']['baseurl']."](id: ${storeGroupId}) ".$SP_Helper->__(' site group was created') );
					
					$storeId = $SU_Helper->make_store( $siteId, $storeGroupId, array(
								'code'=>$postData['website']['code'],
								'name'=>"base default veiw "
								) );
					if( $storeId>0 ){
						
						Mage::getSingleton('adminhtml/session')->addSuccess( $SP_Helper->__('A base store view was created for the new store') );
						
						if(!empty($postData['store']['home_layout'])){
							$SU_Helper->createCmsPage($storeId,array(
								'title' => $postData['store']['title'],
								'identifier' => 'home',
								'content_heading' => $postData['store']['content_heading'],
								'is_active' => 1,
								'stores' => array($storeId),//available for all store views
								'content' => $postData['store']['home_layout']
							));
						}
						
						
						if($SP_Helper->shouldMapWebsites()){
							$map_file=Mage::getBaseDir().'/maps/nginx-mapping.conf';
							if(!file_exists($map_file)){
								file_put_contents($map_file, "map \$http_host \$magesite {\n#MAGE_CONTROLLED_MAPS-Storepartitions\n#END_OF_MAGE_CONTROLLED_MAPS-Storepartitions\n}");
							}

							$str=file_get_contents($map_file);
							
							if(strpos($str,'#END_OF_MAGE_CONTROLLED_MAPS-Storepartitions')===false){
								$str=str_replace("}","\n#MAGE_CONTROLLED_MAPS-Storepartitions\n#END_OF_MAGE_CONTROLLED_MAPS-Storepartitions\n}",$str);
							}
							$str=str_replace("#END_OF_MAGE_CONTROLLED_MAPS-Storepartitions","    ".$postData['storegroup']['baseurl']." ".$postData['website']['code'].";\n#END_OF_MAGE_CONTROLLED_MAPS-Storepartitions",$str);
							file_put_contents($map_file, $str);
							Mage::getSingleton('adminhtml/session')->addSuccess( $postData['storegroup']['baseurl']." ".$postData['website']['code']." ".Mage::helper('storeutilities')->__('was added to the nginx-mapping.conf file') );
						}
						
						/*
						$cDat->saveConfig('wsu_themecontrol_design/spine/spine_color', 'crimson', 'websites', $siteId);
						$cDat->saveConfig('wsu_themecontrol_design/spine/spine_tool_bar_color', 'lighter', 'websites', $siteId);
						$cDat->saveConfig('wsu_themecontrol_design/spine/spine_bleed', '0', 'websites', $siteId);
						$cDat->saveConfig('wsu_themecontrol_design/spine/max_width', '1188', 'websites', $siteId);
						$cDat->saveConfig('wsu_themecontrol_design/spine/fluid_width', 'hybrid', 'websites', $siteId);
						*/
						
					}else{Mage::getSingleton('adminhtml/session')->addError("failed to create the store view");}
				}else{Mage::getSingleton('adminhtml/session')->addError("failed to create the store group");}
			}else{Mage::getSingleton('adminhtml/session')->addError("failed to create the website");}
		}else{Mage::getSingleton('adminhtml/session')->addError("failed to create the root category");}

		$this->_redirect('*/*/');
		
    }
	
    /**
	 * Create and send a zip file of all of the settings 
     */
    public function exportStoreSettingsAction() {
		/*if ( !$this->getRequest()->isPost() && $postData = $this->getRequest()->getPost()) {

		}*/
		$SP_Helper = Mage::helper('storepartitions');
		$collection = $SP_Helper->_getExportCollection();

        $subCollections = array();
        foreach ($collection as $item) {
            /** @var $item \Mage_Core_Model_Config_Data */
            $path		=  $item->getPath();
            $value		=  $item->getValue();
			$scope		=  $item->getScope();
			$scopeId	=  $item->getScopeId();
			
			$key = explode('/',$path);
			$pastArray = isset($subCollections[$key[0]]) ? $subCollections[$key[0]] : array();
            $subCollections[$key[0]] = array_merge($pastArray,array(array(
				$path,
				$scope,
				$scopeId,
				$value
			)));
        }	
		//var_dump(array_keys($subCollections));
		//var_dump($subCollections);
		$baseDir = Mage::getBaseDir('cache').'/export/';
		if(!file_exists($baseDir)){
			mkdir($baseDir,0777,true);	
		}
		foreach( $subCollections as $key=>$items ){
			$filename = $baseDir.$key.'.csv';
			$fileContent=array();
			$fileContent[] = '"path","scope","scope_id","value"';
			foreach( $items as $item ){
				$fileContent[] = $this->_getRow($item);
			}
			$contents = implode(PHP_EOL, $fileContent);
			$this->_writeFile($filename,$contents);
		}
		$zipBaseDir = Mage::getBaseDir('cache').'/zipped_export/';
		if(!file_exists($zipBaseDir)){
			mkdir($zipBaseDir,0777,true);	
		}
		$zipfilename = $zipBaseDir.'/'.date('y-m-d').'.zip';
		$this->Zip($baseDir, $zipfilename);
        if (! is_file ( $zipfilename ) || ! is_readable ( $zipfilename )) {
            throw new Exception ( );
        }
        $this->getResponse ()
                    ->setHttpResponseCode ( 200 )
                    ->setHeader ( 'Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true )
                    ->setHeader ( 'Pragma', 'public', true )
                    ->setHeader ( 'Content-type', 'application/force-download' )
                    ->setHeader ( 'Content-Length', filesize($zipfilename) )
                    ->setHeader ('Content-Disposition', 'attachment' . '; filename=' . basename($zipfilename) );
        $this->getResponse ()->clearBody ();
        $this->getResponse ()->sendHeaders ();
        readfile ( $zipfilename );
        $this->_redirect('*/*/');
    }
	
    /**
	 * Prep values into a signle row for the csv
	 * 
     * @param array $values
     *
     * @return string
     */
    protected function _getRow( array $values )  {
        foreach ($values as &$v) {
            $v = $this->_multiLineToSingleLine($v);
        }
        return self::CSV_ENCLOSED_BY .
				implode(self::CSV_ENCLOSED_BY . self::CSV_SEPARATOR . self::CSV_ENCLOSED_BY, $values) .
				self::CSV_ENCLOSED_BY."\r";
    }
	
	
    /**
	 * prep sting to be a csv value
	 * 
     * @param string $str
     *
     * @return string
     */
    protected function _multiLineToSingleLine( $str )  {
        $str = str_replace(array("\r\n", "\n"), '\\n', $str);
        return addcslashes($str, '"');
    }
	
   /**
    * write to file
	*  
    * @param string $fileName name of the file
    * @param string $contents Contents to put to file
    *
    * @return int
    */
	protected function _writeFile( $fileName, $contents )  {
        $written = file_put_contents($fileName, $contents);
        if (FALSE === $written) {
            //error
            return 1;
        }
		//ok
        return;
	}
	
   /**
    * zip files
	*  
    * @param string $source name of the file
    * @param string $destination Contents to put to file
    *
    * @return boolean
    */
	protected function Zip( $source, $destination ) {
		if (!extension_loaded('zip') || !file_exists($source)) {
			return false;
		}
		
		$zip = new ZipArchive();
		if (!$zip->open($destination, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE)) {
			//echo 'false flag';
			return false;
		}
		$source = str_replace('\\', '/', realpath($source));
		if (is_dir($source) === true) {
			$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
			
			foreach ($files as $file) {
				$file = str_replace('\\', '/', $file);
				// Ignore "." and ".." folders
				if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) ){
					continue;
				}
				$file = realpath($file);
				if (is_dir($file) === true) {
					$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
				} else if (is_file($file) === true) {
					$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
				}
			}
		} else if (is_file($source) === true) {
			$zip->addFromString(basename($source), file_get_contents($source));
		}
		return $zip->close();
	}

	
}

