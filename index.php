<?php
require('bootstrap.php');

$recipes = new \Recipe\Recipes();
$recipes->loadFromJSON(file_get_contents($argv[2]));

$items = new \Fridge\Items();
$items->loadFromCSVFile($argv[1]);

$fridge = new \Fridge\Fridge($items);

$recipeFinder = new \Recipe\Finder($fridge, $recipes);

echo $recipeFinder->findCookTonight()."\n";
