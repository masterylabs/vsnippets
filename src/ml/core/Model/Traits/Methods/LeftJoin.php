<?php

/**
 * Model::find()
 */

trait Masteryl_Model_LeftJoin
{
    public static function leftJoin($table, $cols = [], $foreignKey = null, $localKey = null)
    {
        return (new static )->_leftJoin($table, $cols, $foreignKey, $localKey);
    }

    public function _leftJoin($table, $cols = ['*'], $joinKey = null, $format = true)
    {
        if ($format) {
            $table = Masteryl_Inflector::pluralize($table);
        }

        $this->addLeftJoin($table, $joinKey);

        // print_r($cols);exit;
        $this->addCols($cols, $table);

        return $this;
    }

    public function addLeftJoin($table, $joinKey = null)
    {
        $table = $this->getTable($table);

        if (!$joinKey) {
            $joinKey = $this->db_table . '.' . Masteryl_Inflector::singularize($table) . '_id';
        } elseif (strstr($joinKey, '.') == false) {
            $joinKey = $this->db_table . '.' . $joinKey;
        }

        $join = [
            'table' => $table,
            'on' => [
                $joinKey,
                "{$table}.id",
            ],
        ];

        if (!isset($this->left_joins)) {
            $this->left_joins = [];
        }

        array_push($this->left_joins, $join);
    }
}
