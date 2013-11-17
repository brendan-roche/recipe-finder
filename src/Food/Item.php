<?php
namespace Food;

class Item
{
    const UNIT_OF = 'of';
    const UNIT_GRAMS = 'grams';
    const UNIT_ML = 'milliliters';
    const UNIT_SLICES = 'slices';

    /** @var string */
    protected $name;

    /** @var string */
    protected $unit;

    /** @var int */
    protected $amount;

    /** @var array */
    private static $unitTypes = array();

    public function __construct($params = array())
    {
        $this->setUnitTypes();
        foreach ($params as $name => $value) {
            // work around for naming conventions used in json input file
            if($name == 'item') {
                $name = 'name';
            }
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
            return $this->$methodName($value);
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

    public function __toString()
    {
        return $this->name;
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
     * @param int $amount
     * @throws \InvalidArgumentException
     */
    public function setAmount($amount)
    {
        if (!is_numeric($amount)) {
            throw new \InvalidArgumentException('Invalid parameter passed for item amount: ' . $amount. '. Expecting integer');
        }
        $this->amount = (int) $amount;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
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
}