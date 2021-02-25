<?php

trait Masteryl_Response_Getters
{
    public function getView($view, $args = null, $ext = '.php')
    {
        return $this->view($view, $args, $ext, true);
    }
}
