<?php


trait Masteryl_App_Getters
{
    private $_plugin_data;

    public function getAppName($def = '')
    {
        return !empty($this->_config['app_name']) ? $this->_config['app_name'] : $def;
    }

    public function getRoute($route = '', $params = false)
    {
        if(!empty($route)) {
            $url = $this->base_route . '/' . ltrim($route, '/');
        }
        else {
            $url = $this->base_route;
        }
        

        if($params) {
            $url = masteryl_url_append_params($url, $params);
        }

        return $url;
    }

    public function getPluginInfo($key = false)
    {
        if(!isset($this->_plugin_data)) 
        $this->_plugin_data = masteryl_get_plugin_data();
        
        if($key)
        return $this->_plugin_data[$key];
       
        return $this->_plugin_data;
    }

    public function getInfo()
    {
        if (isset($this->_info)) {
            return $this->_info;
        }

        $info = [
            'app_id' => $this->app_id,
            'base_route' => $this->base_route,
            'app_url' => $this->app_url,
            'client_ip' => masteryl_get_client_ip()
        ];
        
        if (MASTERYL_IS_WP) {
            $plugin = get_plugin_data($this->app_file);
            $info['app_version'] = $plugin['Version'];
            $info['site_name'] = get_bloginfo('name');
            $info['site_url'] = get_bloginfo('url');
        } else {
            $info['version'] = $this->version;
            $info['site_name'] = masteryl_get_domain();
            $info['site_url'] = masteryl_get_site_url();
        }

        $this->_info = $info;

        return $info;
    }

    // public function getInfoWithSecretKey($name = 'install')
    // {
    //     $info = $this->getInfo();
    //     $info['secret_key'] = $this->getSecretKey($name);
    //     return $info;
    // }

    public function getSecretKey($name = 'install')
    {
        $key = "{$name}_secret_key";
      
        $token = $this->meta()->get($key, false);
        if (!$token) {
            $token = masteryl_make_secret_key($name);
            $this->meta()->set($key, $token);
        }
        return $token;
    }

    


    //??
    /**
     * Undocumented function
     *
     * @param boolean $key, can be stirng or array for deep value
     * @param string $def
     * @return void
     */
    public function getConfig($key = '', $def = '')
    {
        if (!$key) {
            return $this->_config;
        }

        if (strstr($key, '.') == true) {
            $config = $this->_config;
            foreach (explode('.', $key) as $k) {
                $config = $config[$k];
            }
            return !empty($config) ? $config : $def;
        }

        // check if doesnt exist or empty string
        return !isset($this->_config[$key]) || is_string($this->_config[$key]) && $this->_config[$key] == '' ? $def  : $this->_config[$key];
    }

    /**
     * Private
     */

    private function getClassPrefix($append = '')
    {
        return $this->_class_prefix . $append;
    }
    
    // belongs in the setup
    private function getEnv($file = '.env', $def = false)
    {
        return masteryl_get_env_file($file, $def);
    }
    

    private function getConfigDir($path='', $name = 'config', $ext = 'php')
    {
        $path = MASTERYL_APP_PATH . $name;

        $files = scandir($path);

        $files = array_filter($files, function ($file) use ($ext) {
            return strpos($file, '.' . $ext) > 1;
        }, 0);

        $options = [];

        foreach ($files as $file) {
            if ($file != $name . '.' . $ext) {
                $options[strstr($file, '.', 1)] = require "{$path}/{$file}";
            } else {
                $master = require "{$path}/{$file}";
            }
        }

        if (isset($master)) {
            foreach ($master as $k => $v) {
                $options[$k] = $v;
            }
        }

        return $options;
    }
}
