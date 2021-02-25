<?php

trait Masteryl_App_Router_Api
{
    public function api($args, $cb = null)
    {
        if ($this->is_valid_route) {
            return;
        }

        $this->is_api_route = true;

        if (!$cb) {
            $cb = $args;
            $args = [];
        }
        array_push($this->router_group_path, 'api');
        // add group path
        if (!empty($args['path'])) {
            array_push($this->router_group_path, trim($args['path'], '/'));
        }

        if (!empty($args['namespace'])) {
            $this->addNamespace($args['namespace']);
        }

        if (!empty($args['middleware'])) {
            $this->addMiddleware($args['middleware']);
        }

        // add group middleware
        
        // call function

        call_user_func($cb, $this);

        // remove group path
        // remove api
        array_pop($this->router_group_path);

        if (!empty($args['path'])) {
            array_pop($this->router_group_path);
        }

        if (!empty($args['namespace'])) {
            $this->removeNamespace($args['namespace']);
        }

        // print_r($this->middleware);exit;
        if (!empty($args['middleware'])) {
            $this->removeMiddleware($args['middleware']);
        }

        $this->is_api_route = false;
    }
}
