<?php

/**
 * Model::find()
 */

trait Masteryl_Model_Find
{
    public static function pk($id, $pk = 'id')
    {
        return (new static )->_pk($id, $pk);
    }
    public function _pk($id, $pk = 'id')
    {
        $this->{$pk} = $id;
        $this->addWhere($pk, $id);
        // echo 'id set ' . $pk . ' ' . $this->{$pk};exit;
        return $this;
    }

    public function setValues($values)
    {
        foreach ($values as $key => $value) {
            $this->{$key} = $value;
        }
        return $this;
    }

    public static function find($id, $cols = '*', $pk = 'id')
    {
        return (new static )->_find($id, $cols, $pk);
    }

    protected function _find($id, $cols = '*', $pk = 'id')
    {

        // $this->query_row = true;

        $this->addWhere($pk, $id);

        $this->addCols($cols);
        
        return $this->queryRow();
    }
}
