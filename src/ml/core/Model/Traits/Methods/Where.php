<?php

/**
 * Model::find()
 */

trait Masteryl_Model_Where
{
    public function wherePivot($a, $b, $c = '_EMPTY', $ao = 'AND')
    {
        $a = $this->pivot_table . '.' . $a;

        if ($c != '_EMPTY') {
            $this->addWhere($a, $c, $b, $ao);
        } else {
            // ee($a, [$b]);
            $this->addWhere($a, $b, null, $ao);
        }

        return $this;
    }

    public static function where($a, $b, $c = '_EMPTY')
    {
        return (new static )->_where($a, $b, $c);
    }

    public function _where($a, $b, $c = '_EMPTY', $ao = 'AND')
    {
        if ($c != '_EMPTY') {
            $this->addWhere($a, $c, $b, $ao);
        } else {
            $this->addWhere($a, $b, '=', $ao);
        }

        return $this;
    }

    public function andWhere($a, $b, $c = '_EMPTY')
    {
        return $this->_where($a, $b, $c);
    }

    public function orWhere($a, $b, $c = '_EMPTY')
    {
        return $this->_where($a, $b, $c, 'OR');
    }
}
