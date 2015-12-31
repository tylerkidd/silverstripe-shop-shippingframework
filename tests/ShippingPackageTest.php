<?php

class ShippingPackageTest extends SapphireTest
{
    
    public function testPackages()
    {
        $p = new ShippingPackage(25, array('depth' => 4, 'height' => 23, 'width' => 12));
        $this->assertEquals($p->height(), 23);
        $this->assertEquals($p->width(), 12);
        $this->assertEquals($p->depth(), 4);
        $this->assertEquals($p->weight(), 25);
        
        $p = new ShippingPackage(25.3, array('h' => 23.7, 'd' => 4, 'w' => 12.344, ));
        $this->assertEquals($p->height(), 23.7);
        $this->assertEquals($p->width(), 12.344);
        $this->assertEquals($p->depth(), 4);
        $this->assertEquals($p->weight(), 25.3);
        
        $p = new ShippingPackage(1, array(3, 4, 5));
        $this->assertEquals($p->height(), 3);
        $this->assertEquals($p->width(), 4);
        $this->assertEquals($p->depth(), 5);
        $this->assertEquals($p->volume(), 60);
        
        $p = new ShippingPackage(13, array(1, 1, 2.5), array('shape' => 'cylinder'));
        $this->assertEquals($p->height(), 1);
        $this->assertEquals($p->depth(), 2.5);
        $this->assertEquals($p->weight(), 13);
        $this->assertEquals($p->volume(), 2.5);
    }
}
