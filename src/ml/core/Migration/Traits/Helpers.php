<?php

trait Masteryl_Migration_Helpers
{
    private function getTableCols($table)
    {
        $sql = 'SHOW COLUMNS FROM '.$table;

        $items = $this->_db->get_results($sql);


        $cols = [];

        foreach ($items as $item) {
            array_push($cols, $item->Field);
        }

        return $cols;
    }
    private function getTables()
    {
        if (isset($this->_tables)) {
            return $this->_tables;
        }

        $this->_tables = [];
        
        $items = $this->_db->get_results("SHOW TABLES");
        
        foreach ($items as $item) {
            foreach ($item as $i) {
                array_push($this->_tables, $i);
            }
        }

        return $this->_tables;
    }

    private function tableExists($table = false)
    {
        if (!$table) {
            $table = $this->table;
        }

        $tables = $this->getTables();

        return !empty($tables) && in_array($table, $tables);
    }

    private function prepCols()
    {
        $this->create_cols = [];
        $this->cols = [];
        $this->index_cols = [];
    }

    // private function getTableName($table = false)
    // {
       
    // }
}
