<?php
namespace Fridge;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    public function useByDataProvider()
    {
        return array(
            array(
                'invalid date'
            ),
        );
    }

    /**
     * @param mixed $useBy
     * @dataProvider useByDataProvider
     * @expectedException \InvalidArgumentException
     */
    public function testSetInvalidUseByException($useBy)
    {
        new Item(
            array(
                'name' => 'salami',
                'amount' => 5,
                'unit' => Item::UNIT_SLICES,
                'useBy' => $useBy,
            )
        );
    }
}
