<?php

trait Masteryl_Collection_Show
{
    public function show($req, $res)
    {
        return $this->_show($req, $res);
    }

    private function _show($req, $res)
    {
        $this->query_method = 'show';
        
        $this->req = $req;

        $item = $this->modelItem($req);

        // ee($item);

        if(!$item) return $res->notFound();

        if(!empty($item)) $item = $this->_onItem($item);

        if (method_exists($this, 'beforeShow')) {
            $item = $this->beforeShow($item);
        }
        // if (method_exists($this, 'beforeItem')) {
        //     $item = $this->beforeItem($item);
        // }

        // hide hidden field
        if (!empty($this->hidden)) {
            $item = $this->parseItem($item);
        }

        $data = [
            'data' => $item,
        ];

        if (method_exists($this, 'showAppend')) {
            $data = $this->showAppend($data, $item);
        }

        

        if (!empty($this->show_append)) {
            $data = array_merge($data, $this->show_append);
        }

        return $res->json($data);
    }
    
}
