<?php

trait Masteryl_App_Meta
{
    // Meta Cache

    private $_meta = [];

    private $_user_meta = [];

    public function meta($args = [])
    {
        if (!isset($_meta)) {
            $this->_meta = new Masteryl_Meta($this->app_id, $args);
        }
        return $this->_meta;
    }

    public function userMeta($userId = null, $args = [])
    {
        if(!$userId) $userId = get_current_user();

        if (!empty($this->_user_meta[$userId])) return $this->_user_meta[$userId];
        
        $args['user_id'] = $userId;

        $this->_user_meta[$userId] = new Masteryl_UserMeta($this->app_id, $args);
        
        return $this->_user_meta[$userId];
        
    }
}
