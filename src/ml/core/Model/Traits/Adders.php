<?php

trait Masteryl_Model_Adders
{
    /**
     * Cols can be array, or key=>value for custom col names
     */
    private function addCols($cols, $table = null)
    {
        if (!isset($this->query_cols)) {
            $this->query_cols = [];
        }

        if (!$table) {
            $table = $this->db_table;
        } else {
            $table = $this->getTable($table);
        }

        // echo 'addCols: ' . $table;

        if (is_array($cols)) {
            
            foreach ($cols as $key => $col) {
                if (strstr(strtolower($col), ' as') == true) {
                    $part = explode(' ', $col);
                    $key = array_shift($part);
                    $col = array_pop($part);

                    if (strstr($key, '.') == false) {
                        $key = "{$table}.{$key}";
                    }

                    $col = "{$key} as {$col}";
                }

                // simple array
                elseif (!is_numeric($key)) {
                    if (strstr($key, '.') == false) {
                        $key = "{$table}.{$key}";
                    }

                    $col = "{$key} as {$col}";
                // exit;
                } elseif (strstr($col, '.') == false) {
                    $col = "{$table}.{$col}";
                }

                array_push($this->query_cols, $col);

                // ee($col);
            }
        }
    }

    private function addWhere($col, $value, $compare = '=', $ao = 'AND')
    {
        if (strstr($col, '.') == false) {
            $col = "{$this->db_table}.{$col}";
        }

        array_push($this->query_wheres, [
            'col' => $col,
            'value' => $value,
            'compare' => $compare,
            'ao' => $ao,
        ]);
    }

    // version 1
    // private function addLeftJoin($pivotTable, $foreignValue, $foreignKey, $localKey)
    // {
    //     $where = [
    //         "{$pivotTable}.{$foreignKey}",
    //         $foreignValue,
    //     ];

    //     $this->addWhere("{$pivotTable}.{$foreignKey}", $foreignValue);

    //     $join = [
    //         'table' => $pivotTable,
    //         'on' => [
    //             "{$this->db_table}.id",
    //             "{$pivotTable}.{$localKey}",
    //         ],
    //     ];

    //     if (!isset($this->left_joins)) {
    //         $this->left_joins = [];
    //     }

    //     masteryl_send_json(compact('where', 'join'));exit;

    //     array_push($this->left_joins, $join);

    // }

    private function addInnerJoin($pivotTable, $foreignValue, $foreignKey, $localKey)
    {
        $where = [
            "{$pivotTable}.{$foreignKey}",
            $foreignValue,
        ];

        $this->addWhere("{$pivotTable}.{$foreignKey}", $foreignValue);

        $join = [
            'table' => $pivotTable,
            'on' => [
                "{$this->db_table}.id",
                "{$pivotTable}.{$localKey}",
            ],
        ];

        if (!isset($this->inner_joins)) {
            $this->inner_joins = [];
        }

        // je(compact('where', 'join'));

        array_push($this->inner_joins, $join);
    }

    /**
     * Do not delete
     */
    // private function addInnerJoinTo($table, $id, $pivotCols = [], $pivotTable = null, $col = null, $col2 = null)
    // {
    //     if (!$pivotTable) {
    //         $pivotTable = $this->getPivotTable($table, $this->table);
    //     }

    //     if (!empty($pivotCols)) {
    //         $this->addCols($pivotCols, $pivotTable);
    //     }

    //     if (!$col) {
    //         $col = Masteryl_Inflector::singularize($table) . '_id';
    //     }

    //     if (!$col2) {
    //         $col2 = Masteryl_Inflector::singularize($this->table) . '_id';
    //     }

    //     // echo $this->table . ' ' . $col;exit;

    //     // $this->pivot_table = $pivotTable;

    //     // and where clause
    //     $where = [$pivotTable . '.' . $col, $id];

    //     $this->addWhere($pivotTable . '.' . $col, $id);

    //     $join = [
    //         'table' => $pivotTable,
    //         'on' => [$this->db_table . '.id', $pivotTable . '.' . $col2],
    //         // 'foreign_key' =>
    //     ];

    //     if (!isset($this->inner_joins)) {
    //         $this->inner_joins = [];
    //     }

    //     // je(compact('where', 'join'));

    //     array_push($this->inner_joins, $join);
    // }
}
