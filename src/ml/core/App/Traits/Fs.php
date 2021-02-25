<?php

trait Masteryl_App_Fs
{
  public function fs($name = '') {
    return new Masteryl_FileSystem($this->app_id, $name);
  }
}
