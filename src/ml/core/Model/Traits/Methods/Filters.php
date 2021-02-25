<?php

/**
 * Model::find()
 */

trait Masteryl_Model_Filters
{
    public function filterMatch($value = 'all')
    {
        $this->query_filter_match_any = strtolower($value) === 'any';
        return $this;
    }

    public function filterWithStr($str)
    {
        if (strstr($str, '|') == true) {
            $items = explode('|', $str);
        } else {
            $items = [$str];
        }

        $last = strtolower(end($items));

        if (in_array($last, ['any', 'all'], true)) {
            $matchAny = $last === 'any';
            array_pop($items);
        } else {
            $matchAny = false;
        }

        foreach ($items as $i) {
            $ids = explode(',', $i);
            $name = array_shift($ids);
            $this->filterWith($name, $ids, $matchAny);
        }

        return $this;
    }

    public function filterWithoutStr($str)
    {
        if (strstr($str, '|') == true) {
            $items = explode('|', $str);
        } else {
            $items = [$str];
        }

        $last = strtolower(end($items));

        if (in_array($last, ['any', 'all'], true)) {
            $matchAny = $last === 'any';
            array_pop($items);
        } else {
            $matchAny = false;
        }

        foreach ($items as $i) {
            $ids = explode(',', $i);
            $name = array_shift($ids);
            $this->filterWithout($name, $ids, $matchAny);
        }

        return $this;
    }

    public function filterWith($name, $ids = [], $matchAny = false)
    {
        $table = $this->getTable(Masteryl_Inflector::pluralize($name));

        $pivotTable = $this->getPivotTable($this->table, $table);

        $foreignKey = Masteryl_Inflector::singularize($name) . '_id';

        $localKey = Masteryl_Inflector::singularize($this->table) . '_id';

        foreach ($ids as $id) {
            $query = "SELECT {$localKey} FROM {$pivotTable} WHERE {$foreignKey} = {$id}";

            $ids = $this->db()->get_col($query);

            if (empty($ids)) {
                continue;
            }

            // first with values

            if (empty($this->query_in)) {
                $this->query_in = $ids;
            } else {
                if ($matchAny) {
                    $this->query_in = array_unique(array_merge($this->query_in, $ids), SORT_REGULAR);
                } else {
                    $this->query_in = array_intersect($this->query_in, $ids);
                }
            }
        }

        return $this;
    }

    public function filterWithout($name, $ids = [], $matchAny = false)
    {
        // Pivot
        // first array,

        $table = $this->getTable(Masteryl_Inflector::pluralize($name));

        $pivotTable = $this->getPivotTable($this->table, $table);

        $foreignKey = Masteryl_Inflector::singularize($name) . '_id';

        $localKey = Masteryl_Inflector::singularize($this->table) . '_id';

        foreach ($ids as $id) {
            $query = "SELECT {$localKey} FROM {$pivotTable} WHERE {$foreignKey} = {$id}";

            $ids = $this->db()->get_col($query);

            if (empty($ids)) {
                continue;
            }

            $this->query_not_in = array_unique(array_merge($this->query_not_in, $ids), SORT_REGULAR);

            if (empty($this->query_not_in)) {
                // first with values
                $this->query_not_in = $ids;
            } else {
                if ($matchAny) {
                    $this->query_not_in = array_unique(array_merge($this->query_not_in, $ids), SORT_REGULAR);
                } else {
                    $this->query_not_in = array_intersect($this->query_not_in, $ids);
                }
            }
        }

        // echo count($this->query_not_in);exit;

        // 1688,4149,3178

        return $this;
    }
}
