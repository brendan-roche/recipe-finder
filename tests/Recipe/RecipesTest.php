<?php
namespace Recipe;

use Food\Item as FoodItem;

class RecipesTest extends \PHPUnit_Framework_TestCase
{
    /** @var Recipes */
    private $recipes;

    public function setup()
    {
        $this->recipes = new Recipes();
        $this->recipes->loadFromJSON(file_get_contents(__DIR__.'/../recipes.json'));
    }

    public function testIterator()
    {
        /** @var Recipe $recipe */
        foreach ($this->recipes as $name => $recipe) {
            $this->assertEquals('Recipe\Recipe', get_class($recipe));
            $this->assertEquals($name, (string) $recipe);
        }

        /** @var Recipe $recipe */
        $recipe = $this->recipes->rewind();
        $this->assertEquals('grilled cheese on toast', (string) $recipe);
        $this->assertEquals('grilled cheese on toast', $this->recipes->key());

        $recipe = $this->recipes->next();
        $this->assertEquals('salad sandwich', (string) $recipe);
        $this->assertEquals('salad sandwich', $this->recipes->key());

        $recipe = $this->recipes->next();
        $this->assertEquals('vegemite sandwich', (string) $recipe);
        $this->assertEquals('vegemite sandwich', $this->recipes->key());

        $recipe = $this->recipes->next();
        $this->assertFalse($recipe);

        $recipe = $this->recipes->rewind();
        $this->assertEquals('grilled cheese on toast', (string) $recipe);
    }

    public function testArrayAccess()
    {
        $this->assertTrue(isset($this->recipes['salad sandwich']));

        $this->recipes[] = new Recipe('vegemite on toast', array(
            array(
                'name' => 'bread',
                'amount' => 1,
                'unit' => FoodItem::UNIT_SLICES,
            ),
            array(
                'name' => 'vegemite',
                'amount' => 5,
                'unit' => FoodItem::UNIT_GRAMS,
            ),
        ));

        $this->assertEquals('vegemite on toast', (string) $this->recipes['vegemite on toast']);

        unset($this->recipes['vegemite on toast']);

        $this->assertFalse(isset($this->recipes['vegemite on toast']));
    }

    public function testCountable()
    {
        $this->assertCount(3, $this->recipes);
    }
}
