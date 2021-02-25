<?php

trait Masteryl_Model_Helpers
{

    /**
     * Helpers
     */

    /**
     * Available in Model
     */
    protected function createIdentifier($length = 20)
    {
        $prefix = isset($this->identifier_prefix) ? $this->identifier_prefix : substr($this->table, 0, 4) . '_';
        return $this->makeKey($length, $prefix);
    }

    /**
     *
     * Private Helpers
     */

    private function idsToArray($ids)
    {
        if (is_string($ids)) {
            $ids = array_map('intval', explode(',', $ids));
        } elseif (is_numeric($ids)) {
            $ids = [$ids];
        } elseif (is_object($ids)) {
            $ids = [$ids->id];
        } else {
            $ids = array_map('intval', $ids);
        }

        return $ids;
    }

    // protected $query_item_format = ['name' => '{prod_name}: {name}'];
    // protected $query_item_format = ['name' => '{$item->prod_name}: {$item->name}'];

    private function parseItems($items)
    {
        // ee('parseItems');
        $count = 0;
        foreach ($items as $item) {
            foreach ($item as $key => $value) {
                // echo $key."\n";
                if (is_null($value) || in_array($key, $this->query_hidden_fields, true)) {
                    // echo "unset {$key} \n";
                    unset($items[$count]->{$key});
                } else {
                    $items[$count]->{$key} = $this->parseColValue($key, $value);
                    

                    if (isset($this->query_item_format) && isset($this->query_item_format[$key])) {
                        eval('$items[$count]->{$key} = "' . $this->query_item_format[$key] . '";');
                    }
                    // ee(['imtekey', $key], $items[$count]->{$key});
                }
            }

                
            // ee($items);

            $count++;
        }

        return $items;
    }


   

    // private function parseItem($item)
    // {
    //     exit;
    // }

    private function parseColValue($key, $value)
    {
        // /???

        if (in_array($key, $this->bool_cols)) {
            return (bool) $value;
        }

        if (in_array($key, $this->int_cols)) {
            // ee(['intCol', $key, (int) $value]);
            return (int) $value;
        }

        // added 07.20 (doesnt work with json strings)
        // if (is_string($value)) {
        //     // $value = stripslashes($value);
        // }

        // must be after stripslashes
        if (in_array($key, $this->json_cols) && is_string($value)) {
            return json_decode($value);
        }

        return $value;
    }

    private function keyToText($key)
    {
        return ucwords(str_replace('_', ' ', $key));
    }
}
