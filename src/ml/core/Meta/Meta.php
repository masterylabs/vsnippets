<?php

class Masteryl_Meta  
{
    use Masteryl_Meta_Encrypt;

    private $_cache = [];

    private $key_prefix = ''; // used for WP

    public function __construct($app_id, $args = [])
    {
        // $this->app_id = $app_id;

        $this->key_prefix = '_'.$app_id;

        if(!empty($args)) {
            foreach($args as $key => $val) $this->{$key} = $val;
        }

    }

    public function delete($key) {
        $this->dbDelete($key);
    }

 

    public function get($key, $def = false, $cc = true)
    {

        if ($cc && isset($this->_cache[$key])) {
            return $this->_cache[$key];
        }

        $value = $this->dbGet($key, $def);

        $this->_cache[$key] = $value;
       
        return $value;
    }

    public function set($key, $value)
    {
        $this->_cache[$key] = $value;

        $this->dbSet($key, $value);
    }

    public function update($key, $values = null) {
        return $this->setValues($key, $values = null);
    }

    public function setValues($key, $values = null) {

        if(is_array($values)) return $this->setValuesArr($key, $values);

        return $this->setValuesObj($key, $values);
    }




    /** extend */

    protected function dbDelete($key)
    {
        $key = $this->getDbKey($key);
        delete_option($key);
    }
    
    protected function dbSet($key, $value)
    {
        $key = $this->getDbKey($key);
        update_option($key, $value);
    }


    protected function dbGet($key, $def = '')
    {
        $key = $this->getDbKey($key);
        return get_option($key, $def);
    }

    /**
     * Privates
     */

    protected function setValuesArr($key, $values = []) {
        $item = $this->get($key, []);
        foreach($values as $k => $v) {
            $item[$k] = $v;
        }
        $this->set($key, $item);
    }

    protected function setValuesObj($key, $values) {
        $def = new stdClass();
        $item = $this->get($key, $def);
        foreach($values as $k => $v) {
            $item->{$k} = $v;
        }
        $this->set($key, $item);
    }

   

    protected function getDbKey($key) {
        if(!empty($this->key_prefix)) return $this->key_prefix.'_'.$key;
        return $key;
    }
}
