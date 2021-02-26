<?php

class Masteryl_VideoCollection extends Masteryl_Collection
{
  // protected $no_permissions = true;

  // protected $no_headers = true;

  protected function getModel()
  {
      return new Masteryl_Video;
  }
}