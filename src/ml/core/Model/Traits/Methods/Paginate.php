<?php

/**
 * Model::find()
 */

trait Masteryl_Model_Paginate
{
    public function paginate($limit = false)
    {
        $this->query_paginate = true;

        if ($limit) {
            $this->query_limit = $limit;
        } elseif (empty($this->query_limit)) {
            $this->query_limit = $this->query_paginate_default_limit;
        }

        return $this;
    }
}
