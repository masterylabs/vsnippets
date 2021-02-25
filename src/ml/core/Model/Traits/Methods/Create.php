<?php

/**
 * Model::find()
 */

trait Masteryl_Model_Create
{
    public static function create($data = [])
    {
        return (new static )->_create($data);
    }

    public function _create($data = [])
    {
        // load items
        foreach ($data as $key => $value) {
            $this->{$key} = $this->parseKeyValue($key, $value);
        }

        return $this->queryCreate();
    }
}
