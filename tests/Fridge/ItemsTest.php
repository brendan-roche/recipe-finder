<?php
namespace Fridge;

class ItemsTest extends \PHPUnit_Framework_TestCase
{
    /** @var Items|Item[] */
    private $items;

    public function setup()
    {
        $this->items = new Items();
        $this->items->loadFromCSVFile(__DIR__.'/../fridge.csv');
    }

    public function testNearestUseBy()
    {
        $oneMinLater = strtotime('+1 minute');
        $this->items['bread']->setUseBy($oneMinLater);

        $this->assertEquals($oneMinLater, $this->items->getNearestUseBy());
    }
}
