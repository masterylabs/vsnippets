<?php

trait Masteryl_Model_PivotOrder
{
    public function pivotOrder($by = 'id', $order = 'asc')
    {
        $by = "{$this->pivot_table}.{$by}";

        return $this->order($by, $order);
    }
}
