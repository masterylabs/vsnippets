<?php

trait Masteryl_Model_QueryCreate
{
  public function beforeCreateUniqueCols()
  {
    foreach($this->unique_cols as $key) {
      $text = !empty($this->{$key}) ? $this->{$key} : $this->makeKey();
      $this->{$key} = $this->getUnique($key, $text, true);
    } 
    
  }


    private function queryCreate()
    {
        if (method_exists($this, 'beforeCreate')) {
            $this->beforeCreate();
        }

        if(!empty($this->unique_cols)) $this->beforeCreateUniqueCols();


        // auto generate identifier
        if (in_array('identifier', $this->fills) && empty($this->identifier)) {
            $this->identifier = $this->createIdentifier();
        }

        $data = [];

        if(isset($this->default_cols)) {
            foreach($this->default_cols as $key => $val) if(!isset($this->{$key}) || is_null($this->{$key})) $this->{$key} = $val; 
        }

        // ee($this->default_cols, $this);

        foreach ($this->fills as $i) {
            if (isset($this->{$i}) && !is_null($this->{$i})) {
                $this->{$i} = $this->parseColValue($i, $this->{$i});
                $data[$i] = maybe_serialize($this->{$i});
            }
        }

        // Add Created, Updated

        if ($this->timestamps) {
            $t = current_time($this->_timestamps_format);

            if (is_bool($this->timestamps) || $this->timestamps === 'created') {
                $this->created = $t;
                $data['created'] = $t;
            }

            if (is_bool($this->timestamps) || $this->timestamps === 'updated') {
                $this->updated = $t;
                $data['updated'] = $t;
            }
        }

        if (isset($this->query_has_many)) {
            $data[$this->query_has_many[0]] = $this->query_has_many[1];
        } elseif (isset($this->query_belogs_to)) {
            $data[$this->query_belogs_to[0]] = $this->query_belogs_to[1];
        }

        // ee($this->db_table, $data);
        
        if($this->db()->insert($this->db_table, $data)) {

            $insertId = $this->db()->insert_id;
            $pk = $this->primary_key;

            $this->{$pk} = $insertId;

            // attach query_belongs_to_many
            if (isset($this->query_belongs_to_many)) { // could just use pivot_table isset
                $this->attach($insertId);
            }
        }
        

        

        // Set DB Values
        $this->db_row_values = $data;

        return $this;
    }
}
