<?php

/**
 * Model->destroy()
 */

trait Masteryl_Model_Destroy
{
    public function destroy()
    {
        $this->queryDelete();
    }

    public static function destroyAll($ids = [])
    {
        return (new static )->_destroyAll($ids);
    }
    public function _destroyAll($ids = [])
    {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $this->queryDeleteIds($ids);
    }
}
