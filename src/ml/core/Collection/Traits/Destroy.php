<?php

trait Masteryl_Collection_Destroy
{
    public function destroy($req, $res, $noReturn = false)
    {
        return $this->_destroy($req, $res, $noReturn);
    }

    private function _destroy($req, $res, $noReturn = false)
    {
        $this->query_method = 'destroy';
        
        $this->req = $req;

        if(method_exists($this, 'beforeDestroy')) $this->beforeDestroy();

        // ee('destroy');

        // multiple delete id seperated by comma
        if (!empty($req->id) && strstr($req->id, ',') == true) {
            $ids = explode(',', $req->id);
            foreach ($ids as $id) {
                $data = $this->modelItem($id)->destroy();
            }
        }

        // standard single item
        else {
            $data = $this->modelItem($req)->destroy();
        }

        if (!$noReturn) {
            return $res->json($data);
        }
    }
}
