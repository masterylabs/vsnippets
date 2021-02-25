<?php

trait Masteryl_Db_Update
{
    public function update($table, $cols, $where)
    {

        // ee('update', $cols);
       
        $query = "UPDATE {$table} SET";

        foreach ($cols as $key => $value) {

            if(is_bool($value))
                $value = $value ? 1 : 0; 
            
            if(is_null($value)) { // this will cause issues down the track
                $query .= " {$key} = NULL,";
            }
            else {
                $query .= " {$key} = '" . addslashes($value) . "',";
            }

            
        }
        
        $query = rtrim($query, ',');

        // ee($query);

        $query .= ' WHERE';

        foreach ($where as $key => $value) {
            $query .= " {$key} = '" . addslashes($value) . "',";
        }
        $query = rtrim($query, ',');


        // ee($query);

        return $this->conn->query($query);
    }
}
