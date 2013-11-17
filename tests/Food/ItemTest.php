<?php
namespace Food;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    function testMagicMethods()
    {
        /** @var Item $item */
        $item = new Item(array(
            'name' => 'bread',
            'amount' => 5,
            'unit' => Item::UNIT_SLICES,
        ));

        $this->assertEquals('bread', $item->name);
        $this->assertEquals(5, $item->amount);
        $this->assertEquals(Item::UNIT_SLICES, $item->unit);

        $item->amount = 10;
        $this->assertEquals(10, $item->amount);

        $this->assertEquals('bread', (string) $item);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testExceptionInvalidUnit()
    {
        new Item(array(
            'name' => 'bread',
            'amount' => 5,
            'unit' => 'invalid',
        ));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testExceptionInvalidAmount()
    {
        new Item(array(
            'name' => 'bread',
            'amount' => 'invalid',
            'unit' => Item::UNIT_SLICES,
        ));
    }
}