<?php

trait Masteryl_App_Router_Group
{
    public function group($args, $cb)
    {
        if ($this->is_valid_route) {
            return;
        }

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

        // return $this;
    }
}
