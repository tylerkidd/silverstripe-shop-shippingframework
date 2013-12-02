<?php

define('SHOP_SHIPPING_PATH', dirname(__FILE__));
define('SHOP_SHIPPING_FOLDER', basename(SHOP_SHIPPING_PATH));


PopulateShopTask::add_extension("PopulateShopTableShippingTask");
Order::add_extension("OrderShippingDecorator");
CartPage_Controller::add_extension("CartPageDecorator");