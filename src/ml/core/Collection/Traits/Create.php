<?php

trait Masteryl_Collection_Create
{
    public function create($req, $res, $noReturn = false)
    {
        return $this->_create($req, $res, $noReturn);
    }

    private function _create($req, $res, $noReturn = false)
    {
        $this->query_method = 'create';
        
        $this->req = $req;

        $item = $this->model($req)
            ->_create($req);

        // user string id same as collection and show
        if(!empty($item->id)) $item->id = (string) $item->id;

        if(!empty($item)) $item = $this->_onItem($item);

        if(method_exists($this, 'onCreated')) $item = $this->onCreated($item);

        if (!$noReturn) {
            return $res->data($item);
        }
    }
}
