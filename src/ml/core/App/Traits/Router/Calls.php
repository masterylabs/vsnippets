<?php

trait Masteryl_App_Router_Calls
{
    private function callRoute()
    {
     
        $req = new Masteryl_Request($this);
        
        // not sure response needs app
        $res = new Masteryl_Response($this);

        if (!$req = $this->validateMiddleware($req, $res)) {
            return;
        }

        $cb = $this->valid_route_cb;

        
        if (!is_string($cb)) {
            return call_user_func($cb, $req, $res);
        }

        // get method if not invoke

        if (strpos($cb, '@') > -1) {
            $method = str_replace('@', '', strstr($cb, '@', 0));
            $cb = strstr($cb, '@', 1);
        }

        $path = explode('/', $cb);
        $name = end($path);
        $naming = preg_split('/(?=[A-Z])/', $name);
        $group = Masteryl_Inflector::pluralize(end($naming));
        
        
        $file = $this->getNamespace($cb, $group);

        // ad class prefix
        $name = 'Masteryl_' . $name;

        if(!class_exists($name)) {

            if (!file_exists($file)) {
                // secondary location, no sub-directory
                $file = $this->getNamespace($cb);
                if (!file_exists($file)) exit('File missing: ' . $file);
            }
        
            include_once $file;

        }

        

        $mod = new $name($req, $res);

        if (!empty($this->valid_route_module_config) && method_exists($mod, 'setConfig')) {
         
            $mod->setConfig($this->valid_route_module_config);
        }

        if (isset($method)) {
            $data = $mod->$method($req, $res);
        } else {
            // ee($mod);
            $data = $mod($req, $res);
        }

        if (!empty($data)) {
            if (is_string($data)) {
                echo $data;
            } elseif (is_object($data) || is_array($data)) {
                masteryl_send_json($data);
            }
            exit;
        }
    }
}
