<?php

class Masteryl_Addon extends Masteryl_Model
{
  protected $database = 'master';

    protected $table = 'addons';

    protected $fills = [
        'identifier',
        'product_id',
        'app_id',
        'name',
        'description',
        'name_prepend', // eg product name, unlimited
        'name_append', // eg product name, life time
        'description_prepend',
        'description_append',
        'tag_id',
        'email_id',
        'download_url',
        'active',
    ];

    // protected $int_cols = [];

    protected $bool_cols = ['active'];

    public function product($cols = ['id', 'name', 'description', 'app_id', 'tag_id']) {
        return $this->belongsTo(new Masteryl_Product, $cols);
    }

    public function contacts($fields = ['id', 'first_name', 'last_name', 'email'], $pivotFields = ['id as PID', 'expire', 'start', 'created', 'updated'])
    {
        return $this->belongsToMany(new Masteryl_Contact, $fields, $pivotFields)
            ->pivotOrder('id', 'desc');
    }

    // public function downloads($cols = ['*'], $pivotCols = '*')
    // {
    //     return $this->belongsToMany(new Masteryl_Download, $cols, $pivotCols);
    // }
}
