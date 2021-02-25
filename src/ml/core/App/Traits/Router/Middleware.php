<?php

trait Masteryl_App_Router_Middleware
{
    protected $middleware = [];

    private function validateMiddleware($req, $res)
    {
        if (empty($this->valid_route_middleware)) {
            return $req;
        }

        // middlewares
        foreach ($this->valid_route_middleware as $mw) {
           
             /**
              * Version 2
              */

             $module = false;
             $path = MASTERYL_MIDDLEWARE_PATH;

            //  ee($mw);

             if (is_array($mw)) {
                 $name = $this->nameToFile($mw['name']);
                 

                 if (!empty($mw['module'])) {
                    $module = $mw['module'];
                    $path = MASTERYL_MODULES_PATH . $module . '/Middleware/';
                 }
             }
             else {
                $name = $this->nameToFile($mw);
             }

              $name = $name.'Middleware';
              $file = $path . $name . '.php';
            
            // echo 'name: '.$name."\n file: ".$file . "\n" . file_exists($file); exit;
            
            // echo $file;exit;

            if (!file_exists($file)) {
                exit('App/Traits/Router/Middleware: 48 file missing: ' . $file);
            }

           /**
            * back to version 1
            */

            include_once $file;

            $name = $this->getClassPrefix($name);

            $mod = new $name();

            if (!empty($this->valid_route_module_config) && method_exists($mod, 'setConfig')) {
        
                $mod->setConfig($this->valid_route_module_config);
            }

            if ($module && isset($this->module_configs[$module])) {
                $mod->setConfig($this->module_configs[$module]);
            }

            if (!$req = $mod->handle($req, $res)) {
             
                break;
            } elseif (is_string($req)) {
                exit($req);
            }
        }

        if (!$req && method_exists($mod, 'onFail')) {
            $mod->onFail($req, $res);
        }

        return $req; // true or false
    }

    private function addMiddleware($m)
    {
        if (!is_array($m)) {
            array_push($this->middleware, $m);
        } else {
            foreach ($m as $i) {
                array_push($this->middleware, $i);
            }
        }
    }

    // required for gorups

    private function removeMiddleware($m)
    {
        if (!is_array($m)) {
            $m = [$m];
        }

        foreach ($m as $i) {
            $index = array_search($i, $this->middleware);
            unset($this->middleware[$index]);
        }
    }
}
