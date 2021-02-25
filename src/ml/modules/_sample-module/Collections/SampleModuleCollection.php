<?php

class Masteryl_SampleModuleCollection extends Masteryl_Collection
{
  // protected $no_permissions = true;

  // protected $no_headers = true;

  protected function getModel()
  {
      return new Masteryl_ModuleSample;
  }
}