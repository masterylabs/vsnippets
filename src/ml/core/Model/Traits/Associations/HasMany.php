<?php

trait Masteryl_Model_HasMany
{
    // private $query_has_many;

    public function hasMany($m, $cols = null, $colKey = null)
    {
        if (!$colKey) {
            $colKey = Masteryl_Inflector::singularize($this->table) . '_id';
        }

        $m->associations_type = 'has_many';

        if ($cols) {
            $m->addCols($cols);
        }

        $m->addWhere($colKey, $this->id);
        // ee($colKey, $this->id);


        $m->query_has_many = [$colKey, $this->id];

        return $m;
    }
}
