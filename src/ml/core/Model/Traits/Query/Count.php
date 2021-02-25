<?php

/**
 * Model::find()
 */

/*

output_type
One of three pre-defined constants. Defaults to OBJECT.
OBJECT - result will be output as an object.
ARRAY_A - result will be output as an associative array.
ARRAY_N - result will be output as a numerically indexed array.
row_offset
(integer) The desired row (0 being the first). Defaults to 0.

 */

trait Masteryl_Model_QueryCount
{
    private function queryCount()
    {
        // $this->query_is_collection = true;

        $joins = $this->getQueryJoins();

        $where = $this->getQueryWheres();

        $query = "SELECT COUNT(*) FROM {$this->db_table}{$joins}{$where}";

        // exit($query);

        $this->_last_query = $query;

        return (int) $this->db()->get_var($query, 0, $this->query_offset);
    }
}
