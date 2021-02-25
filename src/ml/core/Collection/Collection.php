<?php

abstract class Masteryl_Collection
{
    use
    Masteryl_Collection_Index,
    Masteryl_Collection_Create,
    Masteryl_Collection_Destroy,
    Masteryl_Collection_Events,
    Masteryl_Collection_Getters,
    Masteryl_Collection_Headers,
    Masteryl_Collection_ListView,
    Masteryl_Collection_Model,
    // Masteryl_Collection_Order,
    Masteryl_Collection_Parsers,
    Masteryl_Collection_Show,
    Masteryl_Collection_Slug,
    // Masteryl_Collection_Unique,
        Masteryl_Collection_Update;

    protected $can_create = false;

    protected $can_edit = false;

    protected $can_delete = false;

    protected $can_dublicate = false;

    protected $no_permissions = false;

    protected $no_headers = false;

    protected $no_pagin = false;

    protected $use_slug = false;

    protected $fills;

    protected $hidden;

    protected $timestamps;

    protected $cols = ['*'];

    protected $show_append;

    protected $query_method;

    private $association;

    private $id;

    public function __call($name, $re)
    {
        if (method_exists($this, $name)) {
            if (!in_array($name, ['index', 'create'], true)) {
                $this->id = $re[0]->id;
            }
            return;
        }
       
        preg_match_all('/((?:^|[A-Z])[a-z]+)/', $name, $words);

        $words = $words[0];

        // Inversion Method Name

        $method = ucFirst($words[0]);
        $type = strtolower(end($words));
        if ($type === 'index') {
            $method = 'list' . $method;
        } else {
            $method = $type . Masteryl_Inflector::singularize($method);
        }

        if (method_exists($this, $method)) {

            // no list, convert to singular
            if (!in_array($type, ['index', 'create'], true)) {
                $this->id = $re[0]->id;
                // add singular to request
                $itemKey = $words[0];
                $itemValue = $re[0]->{$itemKey};

                unset($re[0]->{$itemKey});

                $itemKey = Masteryl_Inflector::singularize($itemKey);
                $re[0]->{$itemKey} = $itemValue;
            }

            return $this->{$method}($re[0], $re[1]);
        }

        // Doesn't exist

        // $req = $re[0];

        $method = strtolower(array_pop($words));
        $sub = lcfirst(implode('', $words));

        $this->association = lcfirst(implode('', $words));

        // non index will have it

        if (!in_array($method, ['index', 'create'], true)) {
      
            $this->id = $re[0]->{$this->association};
        }

        // required to skip custom primary methods
        if (isset($this->association)) {
            $method = '_' . ucfirst($method);
        }

        return $this->{$method}($re[0], $re[1]);
    }
}
