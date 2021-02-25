<?php

class Masteryl_TagCollection extends Masteryl_Collection
{
    protected $no_permissions = true;

    protected function getModel()
    {
        return new Masteryl_Tag;
    }

    public function updateContact($req, $res)
    {
        $item = Masteryl_Tag::find($req->id);
        $ids = explode(',', $req->contact);
        $item->contacts()->attach($ids);

        $res->success();
    }

    public function destroyContact($req, $res)
    {

        $item = Masteryl_Tag::find($req->id);
        $ids = explode(',', $req->contact);
        $item->contacts()->detach($ids);

        $res->success();
    }
}
