<?php

namespace Recipe;

use Food\Item as FoodItem;
use Food\Items as FoodItems;

class Recipe
{
    /** @var string */
    private $name;

    /** @var FoodItems */
    private $ingredients;

    /**
     * @param string $name
     * @param array $ingredients
     */
    public function __construct($name = null, $ingredients = null) {
        if($name !== null) {
            $this->setName($name);
        }

        if($ingredients !== null) {
            $this->setIngredients($ingredients);
        }
    }

    /**
     * @param array $ingredients
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = new FoodItems();

        foreach($ingredients as $ingredient) {
            $this->ingredients[] = new FoodItem($ingredient);
        }
    }

    /**
     * @return FoodItems
     */
    public function getIngredients()
    {
        return $this->ingredients;
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
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}