<?php

class Masteryl_Product extends Masteryl_Model
{
  protected $database = 'master';

    protected $table = 'products';

    protected $fills = [
        'identifier',
        'name',
        'slug',
        'description',
        'image',
        'thumb',
        'poster',
        'app_id',
        'tag_id',
        'email_id',
        'page_id',
        'promote_page_id',
        'download_url',
        'active',
        'can_promote',
        'promote_hot',
        'promote_ht',
        'promote_url',
        'download_id'
    ];

    // protected $int_cols = [];

    protected $bool_cols = ['active', 'can_promote', 'promote_hot', 'promote_ht'];

    public function addons(
        $cols = ['id', 'app_id', 'name', 'name_prepend', 'name_append', 'description', 'description_prepend', 'description_append']
    ) {
        return $this->hasMany(new Masteryl_Addon, $cols);
    }

    // public function tag($cols = ['name', 'description', 'is_id'])
    // {
    //     return $this->belongsTo(new Masteryl_Tag, $cols);
    // }

    public function contacts($fields = ['id', 'first_name', 'last_name', 'email'], $pivotFields = ['id as PID', 'expire', 'start', 'created', 'updated'])
    {
        return $this->belongsToMany(new Masteryl_Contact, $fields, $pivotFields)
            ->pivotOrder('id', 'desc');
    }

    // public function email($cols = ['*'])
    // {
    //     return $this->hasOne(new Masteryl_Email, $cols);
    // }

    // public function page($cols = ['*'])
    // {
    //     return $this->hasOne(new Masteryl_Page, $cols);
    // }

    // public function promotionPage($cols = ['*'])
    // {
    //     return $this->hasOne(new Masteryl_Page, $cols, 'promote_page_id');
    // }

    // public function downloads($cols = ['*'], $pivotCols = '*')
    // {
    //     return $this->belongsToMany(new Masteryl_Download, $cols, $pivotCols);
    // }
}
