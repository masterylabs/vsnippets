<?php

/**
 * Model::find()
 */

trait Masteryl_Model_FindOrCreate
{
    public static function findOrCreate($match, $data = null, $cols = '*')
    {
        return (new static )->_findOrCreate($match, $data, $cols);
    }

    // data can be added to self model, or passed through data
    public function _findOrCreate($match, $data, $cols)
    {
        foreach ($match as $key => $val) {
            $this->addWhere($key, $val);
            $this->{$key} = $val;
        }

        if(is_string($cols)) {
          $rowCols = [$this->db_table . '.'.$cols];
        } else {
            $rowCols = [];
            foreach($cols as $col) {
              $rowCols[] = "{$this->db_table}.{$col}";
            }
        }
        

        $this->queryRow($rowCols);

        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $this->{$key} = $val;
            }
        }

        return $this->save();
    }
}
