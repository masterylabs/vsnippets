<?php

class Masteryl_SettingsController
{
  public function index($req, $res)
  {
    
    $sett = $req->getApp()->settings->getWithKeys();

    $res->data($sett);
  }

  public function update($req, $res)
  {
    $sett = $req->getApp()->settings;

    $fields = $sett->getFields();

    $values = [];

    foreach($fields as $key) {
      if(isset($req->{$key})) $values[$key] = $req->{$key};
    }

    // ee($values);

    $sett->update($values);
    
    $res->data($values);
  }
}