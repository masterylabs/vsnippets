<?php

trait Masteryl_Db_Query
{
  public function query($data)
  {
    ee('query', $data);
  }
}