<?php

trait Masteryl_Model_QueryDelete
{
    private function queryDelete()
    {
        $pk = $this->primary_key;

        if (!empty($this->{$pk})) {
            $where = [$pk => $this->{$pk}];
        } elseif (!empty($this->hidden_id)) {
            $where = [$pk => $this->hidden_id];
        } else {
            $where = $this->getQueryWheresArray();
        }

        $this->db()->delete($this->db_table, $where);

        // clear update cols
        $this->query_update_cols = [];
    }

    private function queryDeleteIds($ids)
    {
        $pk = $this->primary_key;

        $ids = implode(',', array_map('absint', $ids));
        $this->db()->query("DELETE FROM {$this->db_table} WHERE {$pk} IN({$ids})");
    }
}
