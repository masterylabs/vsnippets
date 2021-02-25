<?php

/**
 * Model::find()
 */

trait Masteryl_Model_All
{
    public static function query()
    {
        return (new static );
    }

    public static function all($cols = null, $args = null)
    {
        return (new static )->_all($cols, $args);
    }

    protected function _all($cols = null, $args = null)
    {
        if ($cols) {
            $this->addCols($cols);
        }

        if ($args) {
            $this->setQueryArgs($args);
        }

        return $this->queryCollection();
    }

    public function get($cols = null)
    {
        if ($cols) {
            $this->addCols($cols);
        }

        return $this->queryCollection();
    }

    public function getIds($key = 'id')
    {
        $this->addCols([$key]);
        $items = $this->queryCollection();

        $ids = [];

        if (!empty($items)) {
            foreach ($items as $i) {
                array_push($ids, $i->{$key});
            }
        }

        return $ids;
    }
}
