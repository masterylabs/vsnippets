<?php

trait Masteryl_Model_QueryBuilders
{
    public function table($req = null)
    {
        if ($req) {
            return $this->_req($req)->paginate()->get();
        }
        return $this->paginate()->get();
    }

    public function order($by = 'id', $order = 'asc', $table = null)
    {
        $table = $this->getTable($table);

        if (strstr($by, '.') == false) {
            $by = $table . '.' . $by;
        }
        $order = strtoupper($order);

        $this->query_order = [$by, $order];

        // echo $by;exit;

        return $this;
    }

    public function offset($n)
    {
        $this->query_offset = (int) $n;

        return $this;
    }

    public function take($n)
    {
        $this->query_limit = (int) $n;

        return $this;
    }

    public function setPage($n)
    {
        $this->query_page = (int) $n;

        return $this;
    }
}
