<?php

trait Masteryl_Model_Getters
{
    public function getCreatedAge($type = null, $col = 'created')
    {
        if (empty($this->{$col})) {
            return false;
        }

        $age = current_time('U') - strtotime($this->{$col});

        if (!$type) {
            return $age;
        }

        if ($type == 'mins') {
            return floor($age / 60);
        }

        if ($type == 'hours') {
            return floor($age / 3600);
        }
    }

    public function getUpdatedAge($type = null)
    {
        return $this->getCreatedAge($type, 'updated');
    }
    /**
     * Default prefix can be disabled by passing empty string: ''
     */

    // public function getLastQuery()
    // {
    //     return $this->_last_query;
    // }

    private function getOffset()
    {

        $value = $this->query_limit * $this->query_page - $this->query_limit;
        return $value;
    }

    private function getPagination($total)
    {
        $orderby = $this->query_order[0];
        if (strstr($orderby, '.') == true) {
            $part = explode('.', $orderby);
            $orderby = end($part);
        }
        $pagin = [
            'total' => (int) $total,
            'page' => !empty($this->query_page) ? $this->query_page : 1,
            'pages' => ceil($total / $this->query_limit),
            'perpage' => $this->query_limit,
            'orderby' => $orderby,
            'order' => $this->query_order[1],
        ];

        return $pagin;
    }

    private function getPivotTable($a, $b)
    {
        $a = Masteryl_Inflector::singularize($a);
        $b = Masteryl_Inflector::singularize($b);

        $tables = [$a, $b];

        sort($tables);

        $table = implode('_', $tables);

        // Add prefix

        return $this->getTable($table);
    }

    private function getQueryWheresArray()
    {
        $data = [];

        foreach ($this->query_wheres as $i) {
            $col = $i['col'];

            if (strstr($col, '.') == true) {
                $part = explode('.', $col);
                $col = array_pop($part);
            }

            $data[$col] = $i['value'];
        }

        return $data;
    }

    private function getQueryWheres()
    {
        $str = '';

        foreach ($this->query_wheres as $i) {
            // ee($this->query_wheres);
            if ($str != '') {
                $str .= !empty($i['ao']) ? " {$i['ao']} " : ' AND ';
            }

            $compare = !empty($i['compare']) ? $i['compare'] : '=';

            if (is_array($i['value'])) {
                $value = ' (' . implode(',', $i['value']) . ') ';
                $compare = ' ' . $compare;
            } elseif (is_null($i['value'])) {
                if ($compare == '!=') {
                    $compare = ' IS NOT ';
                } else {
                    $compare = ' IS ';
                }
                $value = 'NULL';
            } else {
                $value = is_numeric($i['value']) ? $i['value'] : "'" . addslashes($i['value']) . "'";
            }

            // try add slashes
            $str .= "({$i['col']}{$compare}{$value})";
        }

        if (!empty($this->query_not_in)) {
            $str .= " {$this->db_table}.id NOT IN (" . implode(',', $this->query_not_in) . ") ";
        }

        if (!empty($this->query_in)) {
            if (!empty($this->query_not_in)) {
                $str .= $this->query_filter_match_any ? ' OR' : ' AND';
            }
            $str .= " {$this->db_table}.id IN (" . implode(',', $this->query_in) . ") ";
        }

        $where = !empty($str) ? " WHERE {$str}" : '';


      

        if (empty($this->query_search)) {
            return $where;
        }

        /**
         * Add Search
         */

        $searches = '';

        $count = 0;

        foreach ($this->query_search as $search) {
            if ($count > 0) {
                $query .= ' OR ';
            }
            $query = "(";

            $firstCol = true;
            foreach ($search['cols'] as $col) {
                if (!$firstCol) {
                    $query .= ' OR ';
                }
                $query .= "{$search['table']}.{$col} LIKE '%{$search['term'][0]}%'";
                $firstCol = false;
            }

            $query .= ")";

            $count++;
        }

        // append to where
        $where .= empty($where) ? ' WHERE ' : ' AND ';

        $where .= "({$query})";




        return $where;
    }

    // private function getColsRaw()
    // {

    // }

    private function getQueryCols($reqId = false)
    {
        // ee('getQueryCols',$this->query_cols);

        if (is_array($this->query_cols) && !empty($this->query_cols)) {

            // check id is present
            if ($reqId) {
                // query_hidden_pk
                $pk = "{$this->db_table}.{$this->primary_key}"; // will be converted to number after
                if (!in_array($pk, $this->query_cols)) {
                    array_push($this->query_cols, $pk);
                    $this->hidden_id = true;
                }
                // jecho($this->query_cols);
            }

            // jecho([$this->query_cols, $pk]);

            return implode(',', $this->query_cols);
        }

        // jecho($this->query_cols);

        return $this->db_table . '.*';
    }

    private function getQueryJoins()
    {
        $query = '';

        if (!empty($this->inner_joins)) {
            $join = $this->inner_joins[0];

            $query = " INNER JOIN {$join['table']} ON {$join['on'][0]} = {$join['on'][1]}";
        }

        if (!empty($this->left_joins)) {
            foreach ($this->left_joins as $join) {
                $query = " LEFT JOIN {$join['table']} ON {$join['on'][0]} = {$join['on'][1]}";
            }
        }

        return $query;
    }
}
