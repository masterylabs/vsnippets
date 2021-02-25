<?php

trait Masteryl_Collection_Events
{
    public function onCollection($items)
    {
        $onItem = 'onItem';

        if (isset($this->association)) {
            $onItem = 'on' . ucfirst($this->association) . 'Item';
        }

        $count = 0;
            foreach ($items as $item) {
                $items[$count] = $this->_onItem($item);
                if (method_exists($this, $onItem)) $items[$count] = $this->{$onItem}($item);

            $count++;
        }

        // if (method_exists($this, $onItem)) {
        //     $count = 0;
        //     foreach ($items as $item) {
        //         $items[$count] = $this->{$onItem}($item);
        //         $count++;
        //     }
        // }

        return $items;
    }

    private function _onItem($item)
    {
        if(!empty($this->default_item)) {
            foreach($this->default_item as $key => $val) 
            if(!isset($item->{$key})) $item->{$key} = $val;
        }
        return $item;
    }

}
