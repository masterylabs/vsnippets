<?php

class Masteryl_ProductCollection extends Masteryl_Collection
{

    protected function getModel()
    {
        return new Masteryl_Product;
    }

    public function getTableHeaders()
    {
        return ['id', 'name', 'created', 'updated', 'active'];
    }

    protected function getContactTableHeaders()
    {
        return ['id', 'email', 'first_name', 'last_name', 'created', 'updated'];
    }

    public function updateContact($req, $res)
    {
        $item = Masteryl_Product::find($req->id);
        $ids = explode(',', $req->contact);
        $item->contacts()->attach($ids);

        $res->success();
    }

    public function destroyContact($req, $res)
    {

        $item = Masteryl_Product::find($req->id);
        $ids = explode(',', $req->contact);
        $item->contacts()->detach($ids);

        $res->success();
    }
}
