<?php

trait Masteryl_Model_Update
{
    // public static function update($data = [])
    // {
    //     return (new static )->_update($data);
    // }

    public function update($data = [])
    {
        // masteryl_send_json($this->fills);exit;
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fills, true)) {
                $this->{$key} = $this->parseKeyValue($key, $value);
            }
        }

        return $this->save();
    }

    // Nov. 2020
    public function parseKeyValue($key, $value)
    {
        if(in_array($key, $this->int_cols)) {
            return !empty($value) ? (int) $value : 0;
        }

        if(in_array($key, $this->bool_cols)) {
            return !empty($value) ? 1 : 0;
        }

        return $value;
    }

    // public function updatePivotWhere($where, )

    public function updatePivot($data = [], $id = false)
    {
        $table = $this->pivot_table;

        $where = [$this->foreign_key => $this->foreign_value];

        if (is_numeric($id)) {
            $where[$this->local_key] = $id;
        }
        if (!empty($this->id)) {
            $where[$this->local_key] = $this->id;
        }

        $this->db()->update($table, $data, $where);

        global $wpdb;

        return empty($wpdb->last_error);

       
    }
}
