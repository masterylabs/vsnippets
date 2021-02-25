<?php

trait Masteryl_App_Run
{

    public function run($cb = false, $args = null)
    {
        global $masteryl_app;

        $masteryl_app = $this;
        
        if($cb) {
            $this->onValidRoute($cb, $args);
            return $this->callRoute();
        }

        if ($this->is_valid_route) {
            $this->callRoute();
        }
    }
}
