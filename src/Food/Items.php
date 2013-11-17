<?php

namespace Food;

class Items implements \Iterator, \ArrayAccess, \Countable
{
    /** @var Item[]|\Fridge\Item[] */
    protected $items = array();

    /**
     * @param Item[]|array|null $items
     */
    public function __construct($items = null)
    {
        $this->setItems($items);
    }

    /**
     * @param Item[]|array|null $items
     */
    public function setItems($items = null)
    {
        $this->items = array();

        if (is_array($items)) {
            foreach ($items as $item) {
                $this[] = $item;
            }
        }
    }

    /**
     * @return array
     */
    public function itemNames()
    {
        return array_keys($this->items);
    }

    /**
     * @return mixed|void
     */
    public function rewind()
    {
        return reset($this->items);
    }

    /**
     * @return Item
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * @return string|null
     */
    public function key()
    {
        return key($this->items);
    }

    /**
     * @return mixed|void
     */
    public function next()
    {
        return next($this->items);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->items) !== null;
    }

    /**
     * @param string|null $itemName
     * @param Item $item
     */
    public function offsetSet($itemName, $item)
    {
        if (is_null($itemName)) {
            if (!($item instanceof Item)) {
                $item = new Item($item);
            }
            $itemName = $item->getName();
        }

        $this->items[$itemName] = $item;

    }

    /**
     * @param string $itemName
     * @return bool
     */
    public function offsetExists($itemName)
    {
        return isset($this->items[$itemName]);
    }

    /**
     * @param string $itemName
     */
    public function offsetUnset($itemName)
    {
        unset($this->items[$itemName]);
    }

    /**
     * @param string $itemName
     * @return Item|null
     */
    public function offsetGet($itemName)
    {
        return isset($this->items[$itemName]) ? $this->items[$itemName] : null;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }
}