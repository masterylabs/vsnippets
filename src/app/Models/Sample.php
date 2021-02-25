<?php


class Masteryl_Sample extends Masteryl_Model
{
  protected $table = 'samples';

  protected $bool_cols = ['active'];

  protected $int_cols = [
    'id', 'user_id', 'parent_id'
  ];

  protected $default_cols = [
      'parent_id' => 0
  ];

  protected $fills = [
    'identifier',
    'user_id',
    'parent_id',
    'name',
    'active'
  ];
}