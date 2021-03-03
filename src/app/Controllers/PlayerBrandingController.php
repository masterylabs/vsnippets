<?php
class Masteryl_PlayerBrandingController
{

  public function index($req, $res)
  {
    $value = new Masteryl_PlayerBranding(true);
    return $res->data($value);
  }

  public function update($req, $res)
  {
    Masteryl_PlayerBranding::update($req->jsonData);
    return $res->success('Updated');
  }

 
}