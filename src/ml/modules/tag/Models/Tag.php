<?php

class Masteryl_Tag extends Masteryl_Model
{
  protected $database = 'master';

    protected $table = 'tags';

    protected $fills = [
        'name',
        'description',
        'is_id',
    ];

    public function contacts($cols = ['id', 'first_name', 'last_name', 'email'], $pCols = ['created as added'])
    {
        return $this->belongsToMany(new Masteryl_Contact, $cols, $pCols);
    }
}
