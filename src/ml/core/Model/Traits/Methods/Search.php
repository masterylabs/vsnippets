<?php

/**
 * Request search
 */

trait Masteryl_Model_Search
{
    protected $query_search = [];

    public function search($term, $cols = null, $table = null)
    {
        if (empty($cols)) {
            $cols = $this->search_cols;
        } elseif (is_string($cols)) {
            $cols = explode(',', $cols);
        }

        $table = $this->getTable($table);

        $term = explode(',', $term);

        foreach ($term as $q) {
            $search = [
                'term' => $term,
                'cols' => $cols,
                'table' => $table,
            ];

            // $this->addWhere("{$table}.");

            array_push($this->query_search, $search);
        }

        // build request
        return $this;

        // masteryl_send_json($this->query_search);exit;

        // echo 'search';exit;
    }
}
