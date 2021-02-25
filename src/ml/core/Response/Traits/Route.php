<?php

trait Masteryl_Response_Route
{
    public function getRoutes()
    {
        return $this->routes;
    }
    public function route($name, $args = [], $def = '')
    {
        $key = str_replace('.', '_', $name);

        if (strstr($name, '/') == true || !isset($this->routes[$key])) {
            $route = trim($name, '/');
        } else {
            $route = $this->routes[$key];
        }

        $route = preg_replace_callback('/\{[a-zA-Z0-9]{1,255}\}/', function ($vars) use ($args, $def) {

            // get key
            preg_match('/(?<=\{)[a-zA-Z0-9]{1,255}/', $vars[0], $match);

            $key = $match[0];

            if (isset($args[$key])) {
                return $args[$key];
            }
            return $def;
        }, $route);

        // build url

        $url = $this->base_route;

        if (!empty($route)) {
            $url .= '/' . $route;
        }

        return $url;
    }

    public function routeTo($name, $args = [], $def = '')
    {
        $route = $this->route($name, $args, $def);

        return $this->redirect($route);
    }
}
