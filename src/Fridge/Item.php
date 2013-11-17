<?php
namespace Fridge;

use Food\Item as FoodItem;

class Item extends FoodItem
{
    /** @var int */
    protected $useBy;

    /**
     * Pass in any valid date string
     *
     * @param string|int $useBy
     * @throws \InvalidArgumentException
     */
    public function setUseBy($useBy)
    {
        if(is_int($useBy) && $useBy > 0) {
            // assume a valid time stamp
            $this->useBy = $useBy;

        // store it as a unix timestamp
        } else if (($this->useBy = strtotime(str_replace('/', '-', $useBy))) === false) {
            throw new \InvalidArgumentException('Invalid parameter passed for Use-By date: ' . $useBy . '.');
        }
    }

    /**
     * @return int
     */
    public function getUseBy()
    {
        return $this->useBy;
    }

    /**
     * @return bool
     */
    public function hasExpired()
    {
        return $this->useBy < time();
    }
}