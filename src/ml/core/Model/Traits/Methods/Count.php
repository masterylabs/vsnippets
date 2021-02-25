<?php

/**
 * Model::find()
 */

trait Masteryl_Model_Count
{
    // public static function count()
    // {
    //     return (new static )->_count();
    // }
    public function count()
    {
        return $this->queryCount();
    }
}
