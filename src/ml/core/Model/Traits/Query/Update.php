<?php

trait Masteryl_Model_QueryUpdate
{

  public function beforeUpdateUniqueCols()
  {
    foreach($this->unique_cols as $key) {
      
      $text = !empty($this->{$key}) ? $this->{$key} : $this->makeKey();
      // ee(['update', $this], [$text, $this->makeKey()]);
      $value = $this->_getUnique($key, $text, true);
      // ee($this->{$key});
      $this->setUpdateCol($key, $value);
      // ee($this->query_update_cols);
    } 
    
  }

  

    private function queryUpdate($table = false, $cols = false)
    {
        
      if(!empty($this->unique_cols)) $this->beforeUpdateUniqueCols();


        if (!$table) {
            $table = $this->db_table;
        }

        if (!$cols) {
            // already serialized
            $cols = $this->query_update_cols;
        } elseif(is_array($cols)) {
            $count = 0;
            foreach ($cols as $key => $value) {
                $cols[$key] = maybe_serialize($value);
                $count++;
            }
        }

        $pk = $this->primary_key;

        if (!empty($this->{$pk})) {
            $where = [$pk => $this->{$pk}];
        } elseif (!empty($this->hidden_id)) {
            $where = [$pk => $this->hidden_id];
        } else {
            $where = $this->getQueryWheresArray();
        }

        if (method_exists($this, 'beforeUpdate')) {
            $cols = $this->beforeUpdate($cols);
        }



        // Add Created, Updated
        if ($this->timestamps) {
            if (is_bool($this->timestamps) || $this->timestamps === 'updated') {
                $t = current_time($this->_timestamps_format);
                $this->updated = $t;
                $cols['updated'] = $t;
            }
        }
        
        // ee('query', $cols);
        $this->db()->update($table, $cols, $where);

        foreach ($this->query_update_cols as $key => $value) {
            $this->db_row_values[$key] = $value;
        }

        // clear update cols
        $this->query_update_cols = [];
    }
}
