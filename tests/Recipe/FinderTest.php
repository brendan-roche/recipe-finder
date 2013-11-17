<?php
namespace Recipe;

use Fridge\Fridge;
use Fridge\Items as FridgeItems;

class FinderTest extends \PHPUnit_Framework_TestCase
{
    /** @var Finder */
    private $recipeFinder;

    public function setup()
    {
        $recipes = new Recipes();
        $recipes->loadFromJSON(file_get_contents('recipes.json'));

        $items = new FridgeItems();
        $items->loadFromCSVFile('fridge.csv');

        $fridge = new Fridge($items);
        $this->recipeFinder = new Finder($fridge, $recipes);
    }

    public function testValidRecipes()
    {
        $validRecipes = $this->recipeFinder->findValid();
        $this->assertEquals(array('grilled cheese on toast', 'salad sandwich'), array_keys($validRecipes));
    }

    public function testCookTonight()
    {
        $this->assertEquals('salad sandwich', $this->recipeFinder->findCookTonight());
    }
}
