<?php

class PopulateTableShippingTask extends Extension{
	
	function beforePopulate(){
		if(!DataObject::get_one('TableShippingMethod')){
			$fixture = new YamlFixture('shop_shippingframework/tests/fixtures/TableShippingMethod.yml');
			$fixture->saveIntoDatabase();
			DB::alteration_message('Created shipping options', 'created');
		}
	}
	
}