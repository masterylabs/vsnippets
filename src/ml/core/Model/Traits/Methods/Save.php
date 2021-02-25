<?php

/**
 * ->save()
 */

trait Masteryl_Model_Save
{
    public function save($args = null)
    {
        $pk = $this->primary_key;

        if (empty($this->{$pk}) && empty($this->hidden_id)) {
            return $this->queryCreate();
        }

        $this->setUpdateCols(true);

        return $this;
    }
}
