<?php

trait Masteryl_Db_Delete
{
  public function delete($table, $where, $limit = false)
  {
    

    // $this->db()->delete($this->db_table, $where); 
    $query = "DELETE FROM {$table} WHERE";

    foreach ($where as $key => $value) {
        $query .= " {$key} = '" . addslashes($value) . "',";
    }
    
    $query = rtrim($query, ',');

    if($limit) {
      $query .= " LIMIT {$limit}";
    }

    if (!$this->connected) {
      $this->connect();
    }
    
    return $this->conn->query($query);

  }
}