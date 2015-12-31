<?php

class PopulateTableShippingTask extends BuildTask
{
    
    protected $title = "Populate Table Shipping Methods";
    protected $description = 'If no table shipping methods exist, it creates multiple different setups of table shipping.';
    
    public function run($request = null)
    {
        if (!DataObject::get_one('TableShippingMethod')) {
            $fixture = new YamlFixture('shop_shippingframework/tests/fixtures/TableShippingMethod.yml');
            $fixture->saveIntoDatabase();
            DB::alteration_message('Created table shipping methods', 'created');
        } else {
            DB::alteration_message('Some table shipping methods already exist. None were created.');
        }
    }
}

/**
 * Makes PopulateTableShippingTask get run before PopulateShopTask is run
 */
class PopulateShopTableShippingTask extends Extension
{
    
    public function beforePopulate()
    {
        $task = new PopulateTableShippingTask();
        $task->run();
    }
}
