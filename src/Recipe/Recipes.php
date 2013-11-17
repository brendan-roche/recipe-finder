<?php

namespace Recipe;

class Recipes implements \Iterator, \ArrayAccess, \Countable
{
    /** @var Recipe[] */
    private $recipes = array();

    /**
     * @param string $json
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function loadFromJSON($json)
    {
        $this->recipes = array();

        if (($recipes = json_decode($json, true)) === false) {
            throw new \InvalidArgumentException("Invalid formed JSON for loading recipes: \n$json\n\n");
        }

        foreach ($recipes as $recipe) {
            $this[] = new Recipe($recipe['name'], $recipe['ingredients']);
        }

        return true;
    }

    /**
     * @return mixed|void
     */
    public function rewind()
    {
        return reset($this->recipes);
    }

    /**
     * @return Recipe
     */
    public function current()
    {
        return current($this->recipes);
    }

    /**
     * @return string|null
     */
    public function key()
    {
        return key($this->recipes);
    }

    /**
     * @return mixed|void
     */
    public function next()
    {
        return next($this->recipes);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->recipes) !== null;
    }

    /**
     * @param string|null $recipeName
     * @param Recipe|array $recipe
     */
    public function offsetSet($recipeName, $recipe)
    {
        if(is_array($recipe)) {
            $recipe = new Recipe($recipeName, $recipe);
        }
        if (is_null($recipeName)) {
            $recipeName = $recipe->getName();
        }

        $this->recipes[$recipeName] = $recipe;

    }

    /**
     * @param string $recipeName
     * @return bool
     */
    public function offsetExists($recipeName)
    {
        return isset($this->recipes[$recipeName]);
    }

    /**
     * @param string $recipeName
     */
    public function offsetUnset($recipeName)
    {
        unset($this->recipes[$recipeName]);
    }

    /**
     * @param string $recipeName
     * @return Recipe|null
     */
    public function offsetGet($recipeName)
    {
        return isset($this->recipes[$recipeName]) ? $this->recipes[$recipeName] : null;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->recipes);
    }
} 