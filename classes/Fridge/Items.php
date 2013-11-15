<?php

namespace Fridge;

use Fridge\Exceptions\InsufficientQuantity;

class Items implements \ArrayAccess, \Countable
{
    /** @var Item[] */
    protected $items = array();

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * @param mixed $offset
     * @return Item|null
     */
    public function offsetGet($offset)
    {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
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
        if(isset($this->items[$itemName])) {
            try {
                if(($remainingQty = $this->items[$itemName]->reduce($amount)) === 0) {
                    unset($this->items[$itemName]);
                }
                return true;
            } catch (InsufficientQuantity $e) {

            }
        }

        return false;
    }
}