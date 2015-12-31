<?php

class ShippingEstimateFormTest extends FunctionalTest
{
    
    public static $fixture_file = array(
        "shop_shippingframework/tests/fixtures/TableShippingMethod.yml",
        'shop/tests/fixtures/shop.yml'
    );
    
    public function setUp()
    {
        parent::setUp();
        ShopTest::setConfiguration();
        $this->cartpage = $this->objFromFixture("CartPage", "cart");
        $this->cartpage->publish('Stage', 'Live');
        ShoppingCart::singleton()->setCurrent($this->objFromFixture("Order", "cart")); //set the current cart
    }
    
    public function testGetEstimates()
    {
        $resp = $this->get('/cart'); //required to prep things
        //good data
        $data = array(
            'Country' => 'NZ',
            'State' => 'Auckland',
            'City' => 'Auckland',
            'PostalCode' => 1010
        );
        $resp = $this->post('/cart/ShippingEstimateForm', $data);
        
        //TODO: assertions

        //un-escaped data
        $data = array(
            'Country' => 'NZ',
            'State' => 'Hawke\'s Bay',
            'City' => 'SELECT * FROM \" \' WHERE AND EVIL',
            'PostalCode' => 1234
        );
        $resp = $this->post('/cart/ShippingEstimateForm', $data);
        
        //TODO: assertions
    }
}
