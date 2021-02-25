<?php

trait Masteryl_Migration_CreateOrUpdate
{
    protected $_tables;

    protected $create_cols;

    protected $cols;

    protected $index_cols;

    protected $app_id;

    private $no_create = false;
  

    public function truncateTable()
    {
        // drop
        $this->dropTable();

        // create
        $this->prepCols();
        return $this->up();
    }

    public function destroy()
    {
        return $this->dropTable();
    }

    private function dropTable()
    {
        return $this->_db->query("DROP TABLE {$this->table}");
    }

    private function createTable()
    {
        $this->prepCols();

        return $this->up();
    }

    public function updateTable()
    {
        $this->prepCols();

        $this->no_create = true;
        $this->up(); // get fields
        $this->no_create = false;

        $cols = $this->getTableCols($this->table);

        $index = 0;
        foreach ($this->cols as $col) {
            if (!in_array($col, $cols, true)) {
                $q = $this->create_cols[$index];
                $q = "ALTER TABLE {$this->table} ADD {$q}";
                $res = $this->_db->query($q);
            }
            $index++;
        }
    }

    public function create()
    {
        if ($this->no_create) {
            return;
        }

        $table = $this->table;

        $query = "CREATE TABLE {$table} (" . implode(', ', $this->create_cols);

        // add primary key
        if (!empty($this->primary_key)) {
            $query .= ", PRIMARY KEY ({$this->primary_key})";
        }

        if (!empty($this->index_cols)) {
            foreach ($this->index_cols as $col) {
                $query .= ", INDEX ({$col})";
            }
        }

        $query .= ')';

        // ee($query);

        $this->_db->query($query);

        // $this->_db->query("ALTER TABLE {$this->table} ADD INDEX identifier");
    }
}
