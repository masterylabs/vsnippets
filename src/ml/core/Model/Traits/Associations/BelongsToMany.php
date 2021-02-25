<?php

/*

public function products($fields = null, $pivotFields = null)
{
return $this->belongsToMany(MlMember_Product::class, $fields, $pivotFields);
}

 */

trait Masteryl_Model_BelongsToMany
{
    public function belongsToMany($m, $cols = '*', $pivotCols = null, $pivotTable = null, $foreignKey = null, $localKey = null)
    {

        $m->associations_type = 'belongs_to_many';

        if (!empty($cols)) {
            $m->addCols($cols);
        }

        // adding for attach
        if (!$pivotTable) {
            $pivotTable = $this->getPivotTable($this->table, $m->table);
        }

        if (!empty($pivotCols)) {
            $m->addCols($pivotCols, $pivotTable);
        }

        if (!$foreignKey) {
            $foreignKey = Masteryl_Inflector::singularize($this->table) . '_id';
        }

        if (!$localKey) {
            $localKey = Masteryl_Inflector::singularize($m->table) . '_id';
        }

        $m->pivot_table = $pivotTable;

        $m->foreign_key = $foreignKey;

        $m->foreign_value = $this->id;

        $m->local_key = $localKey;

        $m->addInnerJoin($pivotTable, $this->id, $foreignKey, $localKey);

        $m->query_belongs_to_many = true;

        return $m;
    }
}
