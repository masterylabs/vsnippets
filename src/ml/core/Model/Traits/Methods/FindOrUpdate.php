<?php

/**
 * Model::find()
 */

trait Masteryl_Model_CreateOrUpdate
{
    public static function createOrUpdate($match, $data = null)
    {
        return (new static )->_createOrUpdate($match, $data);
    }

    // data can be added to self model, or passed through data
    public function _createOrUpdate($match, $data)
    {
        foreach ($match as $key => $val) {
            $this->addWhere($key, $val);
            $this->{$key} = $val;
            // masteryl_send_json([$key, $val]);exit;
        }

        //$row =
        $this->queryRow([$this->db_table . '.id']);

        // foreach ($match as $key => $val) {
        //     $this->{$key} = $val;
        // }

        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $this->{$key} = $val;
            }
        }

        // masteryl_send_json(compact('this', 'match'));exit;

        return $this->save();
    }
}
