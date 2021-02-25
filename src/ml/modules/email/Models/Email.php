<?php


class Masteryl_Email extends Masteryl_Model
{
  protected $table = 'emails';

  protected $bool_cols = ['active'];

  protected $int_cols = [
    'id', 
  ];

  // protected $default_cols = [
  //     'parent_id' => 0
  // ];

  protected $fills = [
    'identifier',
    'name',
    'description',
    'subject',
    'teaser',
    'subject',
    'body_html',
    'body_text'
  ];

  public function broadcasts() {
    return $this->hasMany(new Masteryl_Broadcast);
  }
  
}