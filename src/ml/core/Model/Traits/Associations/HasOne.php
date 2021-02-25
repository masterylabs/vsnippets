<?php

trait Masteryl_Model_HasOne
{
    public function hasOne($m, $cols = null, $colKey = '')
    {

        // check if self has id
        if ($colKey == '') {
            $colKey = Masteryl_Inflector::singularize($this->table) . '_id';
        }

        if (in_array($colKey, $this->fills, true)) {
            if (empty($this->{$colKey})) {
                return null;
            }
            $m->addWhere('id', $this->{$colKey});
        } else {
            $m->addWhere($colKey, $this->id);
        }

        if (isset($this->id)) {
            $m->query_association_id = $this->id;
        }

        $m->associations_type = 'has_one';

        if ($cols) {
            $m->addCols($cols);
        }

        return $m->queryRow();
    }
}
