<?php

/**
 * Model::find()
 */

/*

output_type
One of three pre-defined constants. Defaults to OBJECT.
OBJECT - result will be output as an object.
ARRAY_A - result will be output as an associative array.
ARRAY_N - result will be output as a numerically indexed array.
row_offset
(integer) The desired row (0 being the first). Defaults to 0.

 */

trait Masteryl_Model_QueryRow
{
    public function isRow()
    {
        return $this->query_is_row;
    }

    private function queryRow($cols = null)
    {
        $this->query_is_row = true;

        // NOT SURE THIS IS NECESSARY (CHECK AUTH TOKEN: CreateOrUpdate)
        if (empty($cols)) {
            $cols = $this->getQueryCols(true);
         
        } elseif (is_array($cols)) {
            $cols = implode(',', $cols);
        }


        // masteryl_send_json($cols);

        $joins = $this->getQueryJoins();

        $where = $this->getQueryWheres();

        $query = "SELECT {$cols} FROM {$this->db_table}{$joins}{$where}";

        // if ($this->db_table === 'page') {
        //     echo $this->db_table . ': ' . $query . "\n\n";
        //     exit;
        // }

        $this->_last_query = $query;


        // echo $query."\n\n"; //exit;

        $result = $this->db()->get_row($query, $this->query_output_type, $this->query_offset);

        if (empty($result)) {
            return null;
        }

        if ($this->query_children && method_exists($this, 'children')) {

            // avoid infinate loop
            $this->query_children = false;

            $id = $result->{$this->primary_key};

            if (!empty($id)) {
                $result->children = $result->children = $this->_pk($id)->children($this->query_cols)->get();
            }
        }

        if ($this->hidden_id) {
            $this->hidden_id = $result->{$this->primary_key};
            unset($result->{$this->primary_key});
        }

        $this->db_row_values = [];

        foreach ($result as $key => $value) {
            $this->db_row_values[$key] = $value;
            $value = maybe_unserialize($value);

            if (is_null($value) || in_array($key, $this->query_hidden_fields, true)) {
                unset($this->{$key});
            } else {
                // echo $key . ' ';
                $this->{$key} = $this->parseColValue($key, $value);
                // $this->db_row_values[$key] = $this->{$key};
            }
        }

        if (isset($this->query_with)) {
            $this->addQueryWithRow();
        }

        return $this;
    }
}
