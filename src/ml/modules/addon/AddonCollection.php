<?php

class Masteryl_AddonCollection extends Masteryl_Collection
{

    protected function getModel()
    {
        return new Masteryl_Addon;
    }

    public function getTableHeaders()
    {
        return ['id', 'name', 'created', 'updated'];
    }

    protected function getContactTableHeaders()
    {
        return ['id', 'email', 'first_name', 'last_name', 'created', 'updated'];
    }

    public function updateContact($req, $res)
    {
        $item = Masteryl_Addon::find($req->id);
        $ids = explode(',', $req->contact);
        $item->contacts()->attach($ids);

        $res->success();
    }

    public function destroyContact($req, $res)
    {

        $item = Masteryl_Addon::find($req->id);
        $ids = explode(',', $req->contact);
        $item->contacts()->detach($ids);

        $res->success();
    }

    public function beforeShow($item)
    {
        $product = $item->product();

        $this->show_append = compact('product');

        return $item;
    }
}
