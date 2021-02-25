<?php

if(!class_exists('Masteryl_Meta')) {
    include __DIR__ . '/Meta.php';
}

class Masteryl_UserMeta extends Masteryl_Meta
{
    protected $user_id;

    protected function dbSet($key, $value)
    {
        $key = $this->getDbKey($key);
       
        update_user_meta($this->user_id, $key, $value);
    }


    protected function dbGet($key, $def = '')
    {
        $key = $this->getDbKey($key);
        // $single
        return get_user_meta($this->user_id, $key, true);
    }

    protected function dbDelete($key)
    {
        $key = $this->getDbKey($key);
        delete_user_meta($this->user_id, $key);
    }

    // SPECIAL CASE USE does a value match search with no key

    public function getUserMetaByValueOnly($key, $value, $cols = 'user_id') {

        $key = $this->getDbKey($key);
        
        global $wpdb;

        $table = $wpdb->usermeta;

        $value = maybe_serialize($value);

        $query = "SELECT {$cols} FROM {$wpdb->usermeta} WHERE meta_key = '{$key}' AND meta_value = '{$value}'";

        return $wpdb->get_row($query);
    }

    public function setUserId($id) {
        $this->user_id = $id;
    }
}
