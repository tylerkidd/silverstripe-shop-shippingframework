<?php

class APIBasedShippingMethod extends ShippingMethod {

	static $db = array(
		'APIService'	=> "Enum('FedEx')",
	);

	static $defaults = array(
		'Name' => 'API Based Shipping Method',
		'Description' => 'Works out shipping from an api'
	);

	static $has_many = array(
		"Rates" => "APIBasedShippingRate"
	);

	
	function getCMSFields(){
		$fields = parent::getCMSFields();
		
		if($this->isInDB()){
			$tablefield = new GridField("Rates", "APIBasedShippingRate", $this->Rates(), new GridFieldConfig_RelationEditor());
			$fields->addFieldToTab("Root.Main", $tablefield);
		}
		return $fields;
	}
	

}


class APIBasedShippingRate extends DataObject {

	static $db = array(
		'FedExService'	=> "Enum('FIRST_OVERNIGHT,PRIORITY_OVERNIGHT,STANDARD_OVERNIGHT,GROUND_HOME_DELIVERY,FEDEX_1_DAY_FREIGHT,FEDEX_2_DAY_FREIGHT,FEDEX_2_DAY,FEDEX_2_DAY_AM,FEDEX_3_DAY_FREIGHT,FEDEX_EXPRESS_SAVER')",
	);
	
	static $has_one = array(
		'ShippingMethod' => 'APIBasedShippingMethod'
	);
	
	static $summary_fields = array(
		'PlainService' => 'Service',
		'PlainCurrier'				=> 'Currier'
	);
	
	function getPlainService(){
		if($this->ShippingMethod()->APIService == 'FedEx'){
			return FedExShippingHelper::getServiceType($this->FedExService);
		}

	}
	
	function getPlainCurrier(){
		return $this->ShippingMethod()->APIService;
	}
		
	function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields = FieldList::create();
		
		if($this->isInDB()){
			//$fields->push(DropdownField::create('APIService', $this->dbObject('APIService')->enumValues() ));

			if($this->ShippingMethod()->APIService == 'FedEx'){
				$fields->push(DropdownField::create('FedExService', 'FedEx Service', FedExShippingHelper::$service_types));
			}else{
				$fields->removeByName('FedExService');
			}

		}else{
			$fields->push(LiteralField::create('','Please save to continue...'));
			
		}
		
		return $fields;
	}

}