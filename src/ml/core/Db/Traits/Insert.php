<?php

trait Masteryl_Db_Insert
{
    public $insert_id;

    public function insert($table, $cols)
    {
        

        $keys = [];
        $values = [];
        foreach ($cols as $key => $value) {
            $keys[] = $key;
            $value = maybe_serialize($value);
            $values[] = "'".addslashes($value)."'";
        }

        $query = "INSERT INTO {$table} (".implode(',', $keys).") VALUES (".implode(',', $values).")";

        // echo $query; exit;
        if (!$this->connected) {
            $this->connect();
        }

        if($this->conn->query($query)) {
            $this->insert_id = $this->conn->insert_id;
            return $this->conn->insert_id;
        }
        // else
        return false;
    }


    
}
// schedule_active
// schedule_active