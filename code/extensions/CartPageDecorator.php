<?php

class CartPageDecorator extends Extension
{
    
    public static $allowed_actions = array(
        'ShippingEstimateForm'
    );
    
    public function ShippingEstimateForm()
    {
        return new ShippingEstimateForm($this->owner);
    }
    
    public function ShippingEstimates()
    {
        $estimates = Session::get("ShippingEstimates");
        Session::set("ShippingEstimates", null);
        Session::clear("ShippingEstimates");
        return $estimates;
    }
}
