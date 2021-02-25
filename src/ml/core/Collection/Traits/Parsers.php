<?php

trait Masteryl_Collection_Parsers
{
    private function parseHeaders($headers)
    {
        $items = [];

        foreach ($headers as $key => $value) {
            if (!is_array($value) && is_string($key)) {
                array_push($items, [
                    'text' => $value,
                    'value' => $key,
                ]);
            } elseif (is_array($value)) {
                array_push($items, $value);
            } else {
                array_push($items, [
                    'text' => $this->keyToHeader($value),
                    'value' => $value,
                ]);
            }
        }

        return $items;
    }

    private function parseItem($item)
    {
        // reremove hidden
        foreach ($this->hidden as $i) {
            unset($item->{$i});
        }

        if (method_exists($this, 'onItem')) {
            $item = $this->onItem($item);
        }

        return $item;
    }
}
