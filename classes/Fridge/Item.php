<?php

namespace Fridge;

use Fridge\Exceptions\InsufficientQuantity;

class Item
{
    const UNIT_OF = 'of';
    const UNIT_GRAMS = 'grams';
    const UNIT_ML = 'millileters';
    const UNIT_SLICES = 'slices';

    /** @var string */
    private $name;

    /** @var int */
    private $amount;

    /** @var string */
    private $unit;

    /** @var int */
    private $useBy;

    /** @var array */
    private static $unitTypes = array();

    public function __construct($params = array())
    {
        $this->setUnitTypes();
        foreach ($params as $name => $value) {
            $this->__set($name, $value);
        }
    }

    /**
     * @param $name
     * @param $value
     * @return bool
     */
    public function __set($name, $value)
    {
        $methodName = 'set'.$name;
        if(method_exists($this, $methodName)) {
            return $this->$methodName();
        } elseif (property_exists($this, $name)) {
            $this->$name = $value;
            return true;
        }

        return false;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $methodName = 'get'.$name;
        if(method_exists($this, $methodName)) {
            return $this->$methodName();
        } elseif (property_exists($this, $name)) {
            return $this->$name;
        }

        return false;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $unit
     * @throws \InvalidArgumentException
     */
    public function setUnit($unit)
    {
        if (!in_array($unit, self::$unitTypes)) {
            throw new \InvalidArgumentException('Invalid parameter passed for item unit: ' . $unit . '. Allowed values are '.implode(', ', self::$unitTypes));
        }
        $this->unit = $unit;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Pass in any valid date string
     *
     * @param string $useBy
     * @throws \InvalidArgumentException
     */
    public function setUseBy($useBy)
    {
        // store it as a unix timestamp
        if (($this->useBy = strtotime($useBy) === false)) {
            throw new \InvalidArgumentException('Invalid parameter passed for use by date: ' . $useBy . '.');
        }
    }

    /**
     * @param string $format
     * @return int
     */
    public function getUseBy($format = 'Y-m-d')
    {
        return date($this->useBy, $format);
    }

    /**
     * Load all our unit types into a static class variable
     */
    private function setUnitTypes()
    {
        if(empty(self::$unitTypes)) {
            $self = new \ReflectionClass(get_called_class());
            $constants = $self->getConstants();
            foreach($constants as $constant => $value) {
                if(strpos($constant, 'UNIT_') === 0) {
                    self::$unitTypes[] = $value;
                }
            }
        }
    }

    /**
     * Reduce the quantity amount for this item in the fridge.
     * If there is not enough of this particular item then throw an exception
     * Otherwise return the remaining amount quantity for this item.
     *
     * @param int|float $amount
     * @return int|float
     * @throws InsufficientQuantity
     */
    public function reduce($amount)
    {
        if($amount > $this->amount) {
            throw new InsufficientQuantity("There is only $this->amount ($this->unit) for item $this->name in the fridge, requested $amount");
        }

        $this->amount -= $amount;

        return $this->amount;
    }
}