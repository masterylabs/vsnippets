<?php

trait Masteryl_Model_ItemFormat
{
    private $query_item_format;

    public function itemFormat($value)
    {
        $this->query_item_format = $value;

        return $this;
    }
}
