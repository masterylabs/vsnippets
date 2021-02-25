<?php

trait Masteryl_App_Db
{
    private $_databases = [];

    public function selectDatabse($name) {

        if(!isset($this->_databases[$name])) {
            $this->_databases[$name] = new Masteryl_Db($this->_config['db'][$name]);
        }

        return $this->_databases[$name];
    }

    public function db()
    {
        if (isset($this->_db)) {
            return $this->_db;
        }

        if (MASTERYL_IS_WP) {
            global $wpdb;
            $this->_db = $wpdb;
        } elseif (!empty($this->_config['db'])) {
            $this->_db = new Masteryl_Db($this->_config['db']);
        }

        return $this->_db;
    }
}
