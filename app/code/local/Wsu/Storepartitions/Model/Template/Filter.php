<?php

class Wsu_Storepartitions_Model_Template_Filter extends Mage_Widget_Model_Template_Filter {
	/**
	 * Take the url, and if it doesn't resolve then look to a default 
	 * folder to see if there is something to work with.
	 * @params string $url 
	 */
	public function storemediaDirective($construction) {
		$params = $this->_getIncludeParameters($construction[2]);
		$requestedUrl = $params['url'];

        $currentStoreCode = Mage::app()->getStore(Mage::getDesign()->getStore())->getCode();
		$URL = '/store-media/'.$currentStoreCode.'/'. trim($requestedUrl,'/');
		if(!file_exists(Mage::getBaseDir('media') .$URL)){
			$URL = '/store-media/default/'. trim($requestedUrl,'/');
		}
		if(file_exists(Mage::getBaseDir('media') .$URL)){
			return Mage::getBaseUrl('media') .$URL;
		}else{
			return "#";	
		}
	}
}




