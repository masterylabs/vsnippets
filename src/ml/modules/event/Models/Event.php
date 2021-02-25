<?php


class Masteryl_Event extends Masteryl_Model
{
  protected $table = 'events';

  protected $bool_cols = ['archived'];

  protected $fills = [
    'name',
    'value',
    'cleint_ip',
    'data',
    'archived',
  ];
  
}