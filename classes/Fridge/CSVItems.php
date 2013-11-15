<?php

namespace Fridge;

class CSVItems extends Items
{
    const MAX_LENGTH = 1000;

    public function loadFromFile($filePath)
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
}