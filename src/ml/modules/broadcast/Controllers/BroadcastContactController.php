<?php


class Masteryl_BroadcastContactController
{
  protected $broadcast;

  public function __construct($req, $res) {

    // sleep(2);
  
    $bc = Masteryl_Broadcast::find($req->id);

    if(!$bc) return $res->notFound();

    $this->broadcast = $bc;

  }

  public function add($req, $res)
  {
    if(!$req->has('ids')) return $res->error('Contacts missing');

    $this->broadcast->contacts()->attach($req->ids);

    return $res->success();
  }

  public function remove($req, $res)
  {
    if(!$req->has('ids')) return $res->error('Contacts missing');

    $this->broadcast->contacts()->detach($req->ids);

    return $res->success();

  }

  public function set($req, $res)
  {
    $this->broadcast->contacts()->detach('all');
    if(!empty($req->ids)) $this->broadcast->contacts()->attach($req->ids);

    return $res->success();

  }

  public function ids($req, $res)
  {
    $ids = $this->broadcast->contacts()->getIds();
    return $res->data($ids);
  }
}