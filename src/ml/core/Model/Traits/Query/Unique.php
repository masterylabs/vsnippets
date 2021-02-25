<?php

trait Masteryl_Model_QueryUnique
{
    /**
     * Used for checking slug
     */

    public function queryUnique($key, $value)
    {
        $query = "SELECT id FROM {$this->db_table} WHERE";

        // valid returned if own slug
        if (isset($this->id)) {
            $query .= " id != {$this->id} AND";
        }

        $query .= " {$key} = '{$value}'";

        return $this->db()->get_var($query);
    }
}
