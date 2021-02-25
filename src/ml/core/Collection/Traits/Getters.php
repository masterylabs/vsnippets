<?php

trait Masteryl_Collection_Getters
{
    // helper can be improved! COULD ALSO BE A TRAIT
    public function getPaginationTemplate($limit = 25)
    {
        return [
            'data' => [],
            'pagin' => [
                "total" => 0,
                "page" => 1,
                "pages" => 0,
                "perpage" => $limit,
                "orderby" => "id",
                "order" => "ASC"
            ]
        ];
    }

    /**
     * Privates
     */

    private function getColsFromHeaders($headers)
    {
        $keys = [];

        foreach ($headers as $key => $value) {
            if (isset($value['value'])) {
                array_push($keys, $value['value']);
            }
        }

        return $keys;
    }

    private function getAssociateMethodName($prefix = '', $append = '', $singularize = true)
    {
        $name = $this->association;

        if ($singularize) {
            $name = Masteryl_Inflector::singularize($name);
        }

        if ($prefix != '') {
            $name = ucfirst($name);
        }

        return $prefix . $name . $append;
    }

    private function getPermissions()
    {
        $items = ['create', 'edit', 'dublicate', 'delete'];

        $value = [];

        foreach ($items as $i) {
            $i = 'can_' . $i;
            $value[$i] = $this->{$i};
        }

        return $value;
    }
}
