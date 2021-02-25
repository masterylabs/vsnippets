<?php

/**
 * Model::find()
 */

trait Masteryl_Model_First
{
    public function first($cols = null)
    {
        if ($cols) {
            $this->addCols($cols);
        }

        // if ($this->db_table === 'contacts') {
        //     echo 'First: ' . $this->id . "\n\n";
        // }

        return $this->queryRow();
    }
}
