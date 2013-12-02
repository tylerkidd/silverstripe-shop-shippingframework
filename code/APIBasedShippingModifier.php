<?php
/**
 * Flat shipping to specific countries.
 *
 * @package shop
 * @subpackage modifiers
 */
class APIBasedShippingModifier extends ShippingModifier {
	
	static $db = array(
		'APIObject' => 'Text'
	);
	
	function value(){
		return $this->APIObject ? $this->APIObject->Cost->Amount : 0;
	}

	function TableTitle() {
		return 'Shipping Modifier using API - '.$this->APIObject->Type;
	}
	
	function setShipping($shipping){
		$this->APIObject = $shipping;
	}
	
}