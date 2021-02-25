<?php

trait Masteryl_App_Router_Name
{
    /**
     * Route name
     */

    public function name($name = 'X')
    {
        $name = str_replace('.', '_', $name);

        $this->route_names[$name] = $this->processing_route;
    }

    public function getRoutes()
    {
        return $this->route_names;
    }
}
