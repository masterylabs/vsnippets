<?php

trait Masteryl_App_Router_Methods
{
    protected $router_group_path = [];

    // required

    public function get($route, $cb, $args = null)
    {
        return $this->validateRoute('GET', $route, $cb, $args);
    }

    public function post($route, $cb, $args = null)
    {
        return $this->validateRoute('POST', $route, $cb, $args);
    }

    public function put($route, $cb, $args = null)
    {
        return $this->validateRoute('PUT', $route, $cb, $args);
    }

    public function patch($route, $cb, $args = null)
    {
        return $this->validateRoute('PATCH', $route, $cb, $args);
    }

    public function delete($route, $cb, $args = null)
    {
        return $this->validateRoute('DELETE', $route, $cb, $args);
    }

    public function head($route, $cb, $args = null)
    {
        return $this->validateRoute('HEAD', $route, $cb, $args);
    }

    public function options($route, $cb, $args = null)
    {
        return $this->validateRoute('OPTIONS', $route, $cb, $args);
    }

    public function allowCors($value = '*')
    {
        $this->_cors_allowed = true;
        
        header("Access-Control-Allow-Origin: ".$value);
        header("Access-Control-Allow-Headers: ".$value);
        header("Access-Control-Allow-Methods: ".$value);
    }
}
