<?php
trait Masteryl_App_Module
{
    private $is_module = null;

    private $valid_route_module;

    private $valid_route_module_config;

    private $module_config;

    private $module_configs = [];

    private $_modules = [];

    // Activate module
    private $modules = [];

    // private $module_options = [];

    public function getModules()
    {
        return $this->_modules;
    }

    public function module($name, $_options = [])
    {

        $options = $_options;
        
        // merge config settings
        if(!empty($this->_config[$name])) {
            $config = $this->_config[$name];
            foreach($config as $key => $value) {
                if(!isset($options[$key])) $options[$key] = $value;
            }
        }
        else $config = [];

        // ee(['moduleConfig', $options], $this->_config[$name]);
        

        // can allow 
        $path = (!empty($options['path']) ? $options['path'] : MASTERYL_MODULES_PATH) . $name . '/';

        $this->modules[] = [
            'name' => $name,
            'path' => $path 
        ];


        $this->_modules[] = $name;
   
        $this->is_module = $name;

        $file = $path . "{$name}.php";


        // if(file_exists(MASTERYL_CONFIG_PATH . $name . '.php'))
        // $config = masteryl_get_config($name, []);

        // ee('module.php', [$name, $config]);

        // not sure this should be options and not just config
        if (!empty($config)) {
            $this->module_config = $options;// $config;
            $this->module_configs[$name] = $options;//$config;
        }

        // required to access app in module
        $app = $this;

        $autoloads = !empty($options['autoloads']) ? $options['autoloads'] : ['Models', 'Traits'];

        foreach($autoloads as $i) 
            if(file_exists($path.$i)) masteryl_autoload($path.$i);
        

        $includes = !empty($options['includes']) ? $options['includes'] : [$name, 'index', 'routes'];

        foreach($includes as $i) {
            $file = $path.$i.'.php';
            if(file_exists($file)) include_once $file;
        }

        $this->is_module = null;

        $this->module_config = null;
    }
}
