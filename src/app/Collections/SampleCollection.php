<?php

class Masteryl_SampleCollection extends Masteryl_Collection
{
  // protected $no_permissions = true;

  // protected $no_headers = true;

  protected function getModel()
  {
      return new Masteryl_Sample;
  }
}