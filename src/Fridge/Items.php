<?php

namespace Fridge;

use Food\Items as FoodItems;

class Items extends FoodItems
{
    const MAX_LENGTH = 1000;

    public function loadFromCSVFile($filePath)
    {
        $this->items = array();

        if(($handle = fopen($filePath, 'r')) !== false) {
            while(($data = fgetcsv($handle, self::MAX_LENGTH, ',')) !== false) {
                $this->items[$data[0]] = new Item(array(
                    'name' => $data[0],
                    'amount' => $data[1],
                    'unit' => $data[2],
                    'useBy' => $data[3],
                ));
            }
        }
    }

    /**
     * Return the timestamp for the item with the closest use-by date
     *
     * @return int|null
     */
    public function getNearestUseBy()
    {
        $useBy = null;
        foreach($this->items as $item) {
            if(($useBy === null || $item->getUseBy() < $useBy) && !$item->hasExpired()) {
                $useBy = $item->getUseBy();
            }
        }

        return $useBy;
    }
}