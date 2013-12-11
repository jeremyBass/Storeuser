<?php

class Wsu_Storepartitions_Model_Source_Websites {
	public function toOptionArray($isMultiselect = false) {
		$options = array();
		$websites=array();
        foreach (Mage::app()->getWebsites() as $website) {
			$websites[] = array("name"=>$website->getName(),"websitecode"=>$website->getCode());
        }
		foreach ($websites as $websiteObj) {
			$website=$websiteObj['websitecode'];
			$name=$websiteObj['name'];

			$options[] = array(
				'value'=> 'websites.'.$website,
				'label' => $name
			);
		}
		return $options;
	}

}