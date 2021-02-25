<?php

/*

public function products($fields = null, $pivotFields = null)
{
return $this->belongsToMany(MlMember_Product::class, $fields, $pivotFields);
}

 */

trait Masteryl_Model_BelongsTo
{
    protected $query_belogs_to;

    public function belongsTo($m, $cols = '*', $foreignKey = null, $colKey = null)
    {
        if (!$colKey) {
            $colKey = Masteryl_Inflector::singularize($this->table) . '_id';
        }

        $m->associations_type = 'belongs_to';

        if (!empty($cols)) {
            $m->addCols($cols);
        }

        if (!$foreignKey) {
            $foreignKey = Masteryl_Inflector::singularize($m->table) . '_id';
        }

        $m->query_belongs_to = [$this->table, $this->id, $foreignKey];

        if (!isset($this->{$foreignKey})) {
            $this->{$foreignKey} = $this->queryCol($foreignKey);
        }

        $m->addWhere('id', $this->{$foreignKey});

        $m->query_belogs_to = [$colKey, $this->id];

        return $m->queryRow();
    }
}
