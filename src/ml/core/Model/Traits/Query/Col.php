<?php

trait Masteryl_Model_QueryCol
{
    private function queryCol($col, $colOffset = 0)
    {
        $joins = $this->getQueryJoins();

        $where = $this->getQueryWheres();

        $query = "SELECT {$col} FROM {$this->db_table}{$joins}{$where}";

        $this->_last_query = $query;

        return $this->db()->get_var($query, $colOffset, $this->query_offset);

        return $this;
    }
}
