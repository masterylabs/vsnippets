<?php

trait Masteryl_Model_QueryWith
{
    private $query_hidden_fields = [];

    public function remove($fields)
    {
        if (!is_array($fields)) {
            $fields = [$fields];
        }

        foreach ($fields as $i) {
            if (isset($this->{$i})) {
                unset($this->{$i});
            }
        }

        // add collection support

        return $this;
    }

    public function hide($fields)
    {
        if (!is_array($fields)) {
            $fields = [$fields];
        }

        foreach ($fields as $i) {
            array_push($this->query_hidden_fields, $i);
        }
    
        return $this;
    }

    private function addQueryWithCollection($items)
    {
        $valid = [];

        foreach ($items as $item) {
            if (empty($item->id)) {
                array_push($valid, $item);
                continue;
            }

            $id = $item->id;

            foreach ($this->query_with as $query) {
                $args = $query[1];
                $cols = !empty($args) && !empty($args[0]) ? $args[0] : '*';
                $name = $query[0];

                $value = (new static )->_pk($id)->setValues($item)->{$name}($cols);

                // single
                if (empty($value->associations_type) || strpos($value->associations_type, '_many') < 1) {
                    $item->{$name} = $value;
                } else {
                    $item->{$name} = $value->get();
                }
            }

            array_push($valid, $item);
        }

        return $valid;
    }


    private function addQueryWithRow()
    {
        foreach ($this->query_with as $i) {
            $args = $i[1];

            $cols = !empty($args) && !empty($args[0]) ? $args[0] : '*';

            $name = $i[0];
            $item = $this->{$name}($cols);
            // single
            if (empty($item->associations_type) || strpos($item->associations_type, '_many') < 1) {
                return $this->{$name} = $item;
            }

            // multipe
            $this->{$name} = $item->get();
        }
    }
}
