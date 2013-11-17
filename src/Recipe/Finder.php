<?php

namespace Recipe;

use Fridge\Fridge;

class Finder {
    /** @var Fridge  */
    private $fridge;

    /** @var Recipes */
    private $recipes;

    public function __construct(Fridge $fridge = null, Recipes $recipes = null)
    {
        if ($fridge !== null) {
            $this->setFridge($fridge);
        }

        if ($recipes !== null) {
            $this->setRecipes($recipes);
        }
    }

    /**
     * @param Fridge $fridge
     */
    public function setFridge($fridge)
    {
        $this->fridge = $fridge;
    }

    /**
     * @return Fridge
     */
    public function getFridge()
    {
        return $this->fridge;
    }

    /**
     * @param Recipes $recipes
     */
    public function setRecipes(Recipes $recipes)
    {
        $this->recipes = $recipes;
    }

    /**
     * @return Recipes
     */
    public function getRecipes()
    {
        return $this->recipes;
    }

    /**
     * Iterates through all recipes and returns an array of recipes
     * that we have all ingredients for.
     *
     * Returns an associative array with
     *  recipe name => timestamp for item with closest use by
     *
     * @return array
     */
    public function findValid()
    {
        $validRecipes = array();

        /** @var Recipe $recipe */
        foreach($this->recipes as $name => $recipe) {
            if (($fridgeItems = $this->fridge->getMatchingItems($recipe->getIngredients())) !== false) {
                $validRecipes[$name] = $fridgeItems->getNearestUseBy();
            }
        }

        return $validRecipes;
    }

    /**
     * Returns a recipe name matching the recipe
     * which uses an item with the closest use by date
     *
     * @return string
     */
    public function findCookTonight()
    {
        $validRecipes = $this->findValid();
        $noRecipes = count($validRecipes);
        if ($noRecipes == 0) {
            return 'Order Takeout';
        } elseif ($noRecipes > 1) {
            asort($validRecipes);
        }

        return key($validRecipes);
    }
} 