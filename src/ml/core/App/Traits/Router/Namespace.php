<?php

trait Masteryl_App_Router_Namespace
{
    private $route_namespace = [];

    private $valid_route_namespace = [];

    private $fixed_namespace_groups = ['Middleware', 'Collection'];


    private function getNamespace($file, $group = '', $ext = '.php')
    {

        foreach(['Middleware', 'Collection', 'Controller'] as $i) {
            if(strpos($file, $i) > 0) {

                if (!empty($this->valid_route_module)) {
                    if(!empty($group)) $group .= '/';
                    return MASTERYL_MODULES_PATH . $this->valid_route_module . '/' . $group . $file.$ext;
                }

                return constant('MASTERYL_'.strtoupper($i).'S_PATH').$file.$ext;
            }
        }

        return MASTERYL_APP_PATH.$file.$ext;
    }


    private function getNamespaceFromModule($module = 'ModuleName', $file, $group = null, $ext = '.php')
    {
        if (!empty($this->valid_route_module)) {
            $dir = $this->valid_route_module;
        }

        $path = MASTERYL_MODULES_PATH . $module . '/';


        if ($group) {
            $path .= $group . '/';
        }

        if (!empty($this->valid_route_namespace) && !in_array($group, $this->fixed_namespace_groups, true)) {
            $path .= implode('/', $this->valid_route_namespace) . '/';
        }

        return $path . $file . $ext;
    }

    
    private function addNamespace($m)
    {
        if (!is_array($m)) {
            array_push($this->route_namespace, $m);
        } else {
            foreach ($m as $i) {
                array_push($this->route_namespace, $i);
            }
        }
    }

    // required for gorups

    private function removeNamespace($m)
    {
        if (!is_array($m)) {
            $m = [$m];
        }

        foreach ($m as $i) {
            $index = array_search($i, $this->route_namespace);
            unset($this->route_namespace[$index]);
        }
    }
}
