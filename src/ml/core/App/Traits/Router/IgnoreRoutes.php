<?php

trait Masteryl_App_Router_IgnoreRoutes
{
    protected $ignore_routes = [];

    public function ignoreRoutes($routes = [])
    {
        if (!is_array($routes)) {
            $routes = [$routes];
        }

        foreach ($routes as $route) {
            $route = trim($route, '/');
            if (!in_array($route, $this->ignore_routes)) {
                $this->ignore_routes[] = trim($route, '/');
            }
        }
    }

    private function ignoreRoutePath($path)
    {
        $path = trim($path, '/');

        foreach ($this->ignore_routes as $route) {
            if (strstr($route, '*') == true) {
                $route = rtrim($route, '*');
                $pos = strpos($path, $route);
                if ($pos === 0) {
                    return true;
                }
            } elseif ($route == $path) {
                return true;
            }
        }

        return false;
    }
}
