<?php


class Masteryl_Sender extends Masteryl_Model
{
  protected $table = 'senders';

  protected $int_cols = [
    'id', 
  ];

  // protected $default_cols = [
  //     'parent_id' => 0
  // ];

  protected $fills = [
    'identifier',
    'name',
    'email',
    'reply_email',
  ];

  public function broadcasts() {
    return $this->hasMany(new Masteryl_Broadcast);
  }
  
}