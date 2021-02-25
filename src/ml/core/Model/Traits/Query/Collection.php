<?php

trait Masteryl_Model_QueryCollection
{
    public function isCollection()
    {
        return $this->query_is_collection;
    }

    private function queryCollection()
    {
        $this->query_is_collection = true;

        $cols = $this->getQueryCols();

        $joins = $this->getQueryJoins();

        $where = $this->getQueryWheres();

        $query = "SELECT {$cols} FROM {$this->db_table}{$joins}{$where}";

        if (!empty($this->query_order)) {
            if (strstr($this->query_order[0], '.') == false) {
                $this->query_order[0] = $this->db_table . '.' . $this->query_order[0];
            }
            $query .= " ORDER BY {$this->query_order[0]} {$this->query_order[1]} ";
        }

        if ($this->query_limit) {
            $query .= " LIMIT ";
            $query .= $this->getOffset();
            $query .= ", {$this->query_limit}";
        }

        // echo $query; exit;

        $this->_last_query = $query;

        $items = $this->db()->get_results($query, $this->query_output_type);

        if (!empty($items)) {

            // unserialize
            $count = 0;
            foreach ($items as $item) {
                if (!empty($item)) {
           
                    foreach ($item as $key => $val) {
                        if (!empty($val)) {
                            $items[$count]->$key = maybe_unserialize($val);
                        }
                    }
                }
                $count++;
            }

            if (isset($this->query_with)) {
                $items = $this->addQueryWithCollection($items);
            }
            $items = $this->parseItems($items);
        }

        //
        if (!empty($items) && $this->query_children && method_exists($this, 'children')) {
            $items = $this->queryCollectionAppendChildren($items);
        }

        if (!empty($this->query_paginate)) {
            $total = $this->db()->get_var("SELECT COUNT(*) FROM {$this->db_table}{$joins}{$where}");

            return [
                'data' => $items,
                'pagin' => $this->getPagination($total),
            ];
        }

        return $items;
    }

    private function queryCollectionAppendChildren($items)
    {
        // avoid infinate loop
        $this->query_children = false;

        $cols = $this->query_cols;

        $count = 0;

        foreach ($items as $item) {
            if (!empty($item->id)) {
                $items[$count]->children = $this->_pk($item->id)->children($cols)->get();
            }

            $count++;
        }
        return $items;
    }
}
