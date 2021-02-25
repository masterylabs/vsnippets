<?php

class Masteryl_EmailCollection extends Masteryl_Collection
{
  protected $no_permissions = true;

  // protected $no_headers = true;

  // protected $can_create = true;

  protected function getModel()
  {
      return new Masteryl_Email;
  }

  public function getHeaders() {
    return [
      'id', 'name', 'description'
    ];
  }
}