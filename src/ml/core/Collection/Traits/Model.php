<?php

trait Masteryl_Collection_Model
{
    private function modelItem($req)
    {
   
        if (isset($this->association)) {
            $a = $this->association;

            $m = $this->getModel()->_pk($req->id)->{$a}()->_where('id', $req->{$a}); 
        }

        // standard

        else {

            if (!is_object($req)) {
                $id = $req;
            } else {
                $id = $req->id;
            }
            $m = $this->getModel()->_pk($id);
        }

        /**
         * Query Append
         */
        if (method_exists($this, 'queryAppend')) {
            $m = $this->queryAppend($m);
        }

        if(isset($req->view) && $req->view == 'list' && $this->allow_list_view) {
            $this->cols = $this->getListView($req);
        }

        $m = $m->first($this->cols);



        if (!$m) {
            return null;
        }

        foreach (['fills', 'hidden', 'timestamps'] as $i) {
            if (!isset($this->{$i})) {
                $this->{$i} = $m->getProp($i);
            }
        }

        return $m;
    }

    private function model($req, $params = false)
    {
        if (isset($this->association)) {
            $m = $this->getModel()->_pk($req->id)->{$this->association}();
            if(!$m) return $m; // not exist
            if ($params) {
                $m->_req($req);
            }
        }
        // association
        elseif ($params) {
            $m = $this->getModel()->_req($req);
        } else {
            $m = $this->getModel();
        }

        if(!$m) return $m; // not exist

        foreach (['fills', 'hidden', 'timestamps'] as $i) {
            if (!isset($this->{$i})) {
                $this->{$i} = $m->getProp($i);
            }
        }

        return $m;
    }
}
