<?php

trait Masteryl_Collection_Update
{
    public function update($req, $res, $noReturn = false)
    {
        return $this->_update($req, $res, $noReturn);
    }

    private function _update($req, $res, $noReturn = false)
    {
        $this->query_method = 'update';

        $this->req = $req;

        $item = $this->modelItem($req);

        if (!$item) {
            return $res->error('no item');
        }

        $fills = $item->getProp('fills');

        foreach($fills as $i) if(isset($req->{$i})) $item->{$i} = $req->{$i};
        
        if(method_exists($this, 'beforeUpdate')) $item = $this->beforeUpdate($item, $req);
      

        $item->save($req);

        // get updated item
        $data = $item->first();

        if (!$noReturn) {
            return $res->data($data);
        }
    }
}
