<?php

trait Masteryl_Sendgrid_Compose
{
  public function compose($args)
  {
    foreach($args as $key => $value)
    {
      $this->{$key} = $value;
    }
  }
}