<?php

namespace Fridge;

class Fridge
{
    /** @var Items */
    private $items = array();

    /**
     * @param Items $items
     */
    public function __construct(Items $items = array())
    {
        $this->fill($items);
    }

    /**
     * Stock the fridge with items
     *
     * @param Items $items
     */
    public function fill(Items $items = array())
    {
        $this->items = $items;
    }

    /**
     * Take an item from the fridge
     *
     * @param $itemName
     * @param $amount
     * @return bool
     */
    public function take($itemName, $amount)
    {
        return $this->items->take($itemName, $amount);
    }

} 