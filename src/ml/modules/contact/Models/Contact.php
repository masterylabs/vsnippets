<?php


class Masteryl_Contact extends Masteryl_Model
{
  protected $database = 'master';
  
  protected $table = 'contacts';

  protected $bool_cols = ['active'];

  protected $search_cols = ['first_name', 'last_name', 'email'];

  protected $int_cols = [
    'email_confirmed',
    'opted_out', 
    'blocked'
  ];

  protected $fills = [
    'identifier',
    'first_name',
    'last_name',
    'email',
    'phone',
    'email_confirmed',
    'opted_out', 
    'blocked'
  ];


  public function broadcasts() {
    return $this->belongsToMany(new Masteryl_Broadcast);
  }

  public function products($cols = ['name', 'slug', 'description', 'id', 'identifier as pid'], $pivotCols = ['start', 'expire', 'created'])
    {
      // resolve missing
      
      if(!class_exists('Masteryl_Product')) return;

        return $this->belongsToMany(new Masteryl_Product, $cols, $pivotCols);
    }

    public function addons($cols = ['id', 'name', 'name_prepend', 'name_append', 'description', 'identifier as aid'], $pivotCols = ['start', 'expire', 'created'])
    {
        return $this->belongsToMany(new Masteryl_Addon, $cols, $pivotCols);
    }

}