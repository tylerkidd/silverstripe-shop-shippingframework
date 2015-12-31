<?php
/**
 * ShippingMethod is a base class for providing shipping options to customers. 
 * 
 * @package shop
 * @subpackage shipping 
 */
class ShippingMethod extends DataObject
{
    
    public static $db = array(
        "Name" => "Varchar",
        "Description" => "Varchar",
        "Enabled" => "Boolean",
        
        //TODO
        //"WeightMin" => "Decimal",
        //"WeightMax" => "Decimal",
        //"HandlingFee" => "Currency", //adds extra handling cost to use this method
    );
    
    public static $casting = array(
        'Rate' => 'Currency'
    );
    
    public function calculateRate(ShippingPackage $package, Address $address)
    {
        return null;
    }
    
    public function getRate()
    {
        return $this->CalculatedRate;
    }
    
    public function Title()
    {
        return implode(" - ", array_filter(array(
            $this->CalculatedRate,
            $this->Name,
            $this->Description
        )));
    }
}
