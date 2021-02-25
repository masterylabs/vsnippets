<?php

trait Masteryl_App_Remote
{
    private $_remote;

    public function remote($forceNew = false)
    {
        if ($forceNew || !isset($this->_remote)) {
            $this->_remote = new Masteryl_Remote();
        }
    
        return $this->_remote;
    }
}
