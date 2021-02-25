<?php

// This can be extended to other associations like hasOne and hasMany

trait Masteryl_Model_Attach
{
    public function attachSet($ids, $data = null)
    {
        $this->detachAll();
        return $this->attach($ids, $data);
    } 

    public function attachCheck($ids, $data = null)
    {
        return $this->attach($ids, $data, true);
    }

    public function attach($ids, $data = null, $check = false)
    {
        
        $ids = $this->idsToArray($ids);

        if ($this->pivot_timestamps) {
            $t = current_time('mysql');
        }

        if (empty($data)) {
            $data = [];
        }

        // belongs to many

        $table = $this->pivot_table;

        foreach ($ids as $id) {
            if ($check) {
                $exists = $this->db()->get_var("SELECT id FROM {$table} WHERE {$this->foreign_key}={$this->foreign_value} AND {$this->local_key}={$id}");
            }

            // check if exists

            if (!$check || !$exists) {

                // product
                $pivot = [
                    $this->foreign_key => $this->foreign_value,
                    $this->local_key => $id,
                ];

                if ($this->pivot_timestamps) {
                    if (is_bool($this->pivot_timestamps) || $this->pivot_timestamps === 'created') {
                        $pivot['created'] = $t;
                    }

                    if (is_bool($this->pivot_timestamps) || $this->pivot_timestamps === 'updated') {
                        $pivot['updated'] = $t;
                    }
                }

                if (!$this->db()->insert($table, array_merge($data, $pivot))) {
                    $this->error = 'attach';
                    echo 'not able to attache';
                    exit;
                    break;
                }
            }
        }
    }

    // remove belong to many
    public function detach($ids, $single = true)
    {
        if(is_string($ids) && $ids ==  'all') return $this->detachAll();

        $ids = $this->idsToArray($ids);

        // belongs to many
        $table = $this->pivot_table; // $this->getTable($this->pivot_table);

        foreach ($ids as $id) {
            if ($single) {
                if ($exists = $this->db()->get_var("SELECT id FROM {$table} WHERE {$this->foreign_key}={$this->foreign_value} AND {$this->local_key}={$id}")) {
                    $delete = $this->db()->delete($table, ['id' => $exists]);
                }
            }

            // find dublicates
            else {
                $delete = $this->db()->delete($table, [
                    $this->foreign_key => $this->foreign_value,
                    $this->local_key => $id,
                ]);
            }
        }
    }

    public function detachAll()
    {
        $table = $this->pivot_table;

        $query = "DELETE FROM {$table} WHERE {$this->foreign_key}={$this->foreign_value}";

        $this->db()->query($query);
    }
}
