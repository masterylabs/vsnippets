<?php

trait Masteryl_App_Router_Events
{
    private function onRouteDone()
    {
        // echo " onRouteDone ";
        return $this;
    }

    public function setValidRoute($cb, $args = null) {
        return $this->onValidRoute($cb, $args);
    }

    private function onValidRoute($cb, $args = null, $path = '')
    {
        
        if (($this->is_api_route || $this->is_processing_collection) && !$this->_cors_allowed) {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: *");
            header("Access-Control-Allow-Methods: *");
        }

        if ($this->request_method === 'OPTIONS') {
            masteryl_send_json();
            exit;
        }

        if (!empty($args)) {

            // add middlewares
            if (is_string($args)) {
                $this->addMiddleware($args);
            } elseif (is_array($args) && !empty($args['middleware'])) {
                $this->addMiddleware($args['middleware']);
            }

            // other args
            // if(!empty($args['route_args']))
        }

        if (!empty($this->middleware)) {
            $this->valid_route_middleware = $this->middleware;
        }

        if (!empty($this->route_namespace)) {
            $this->valid_route_namespace = $this->route_namespace;
        }

        if ($this->is_module) {
           
            $this->valid_route_module = $this->is_module;
            $this->valid_route_module_config = $this->module_config;
        }

        // self::$current_url = masteryl_get_site_url($path);

        $this->is_valid_route = true;

        $this->valid_route_cb = $cb;

        return $this->onRouteDone();
    }
}
