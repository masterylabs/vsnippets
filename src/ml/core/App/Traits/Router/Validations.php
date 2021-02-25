<?php

trait Masteryl_App_Router_Validations
{
    private $processing_route;

    private function validateRoute($method, $route = '', $cb, $args = [])
    {
        // ee(compact('method', 'route'));

        if (!empty($this->router_group_path)) {
            $route = implode('/', $this->router_group_path) . '/' . trim($route, '/');
        }

        $route = trim($route, '/');

        if ($this->is_processing_collection && strpos($route, 'api/') !== 0) {
            $route = 'api/' . $route;
        }

        // echo $route;exit;

        // store route
        $this->processing_route = $route;

        // route already mached or wrong method
        if ($this->is_valid_route || !in_array($this->request_method, [$method, 'OPTIONS'], true)) {
            return $this->onRouteDone();
        }

        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // if (!empty($this->_config['url_prefix']) && empty($args['root'])) {
        //     $route = $this->_config['url_prefix'] . '/' . $route;
        // }
        if (!empty($this->_config['url_prefix']) && empty($args['root'])) {
            $prefix = $this->_config['url_prefix'];
            
            $route = $prefix . '/' . $route;

            $n = strpos($path, '/'.$prefix); 
            if(!empty($n)) {
                $n++;
                $path = substr($path, $n); 
            }
            // exit;
        }

        if ($this->ignoreRoutePath($path)) {
            return $this->onRouteDone();
        }

        if ($route === $path && strpos($route, '{') == false) {
            return $this->onValidRoute($cb, $args, $path);
        }

        // varable routes

        $p = explode('/', trim($path, '/'));
        $r = explode('/', trim($route, '/'));

        if (count($p) != count($r)) {
            return $this->onRouteDone();
        }

        $count = 0;

        $atts = [];

        foreach ($r as $ri) {
            if (strpos($ri, '{') === 0) {
                $key = substr($ri, 1, -1);
                $atts[$key] = urldecode($p[$count]);
            } elseif ($ri != $p[$count]) {
                $count = -1;
                break;
            }

            $count++;
        }

        if ($count < 0) {
            return $this->onRouteDone();
        }

        if (!empty($atts)) {
            $this->route_atts = array_merge($this->route_atts, $atts);
        }
        return $this->onValidRoute($cb, $args, $path);
    }
}
