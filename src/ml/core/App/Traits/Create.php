<?php

trait Masteryl_App_Create
{
    private static $_env;

    public static function create($config = [])
    {
        // Load ENV
    
        if (!empty($config['env'])) {
            $key = gettype($config['env']) == 'string' ? $config['env'] : '.env';
            self::$_env = masteryl_get_env_file($key);
        }


        return (new static )->_create($config);
    }

    private function _create($config)
    {

        // WP
        if (MASTERYL_IS_WP) {
            $this->app_file = MASTERYL_WP_PLUGIN_FILE;
        }

        $this->request_method = $_SERVER['REQUEST_METHOD'];


        $this->app_url = masteryl_get_app_url();

        // Config Options
        $dirConfig = masteryl_get_dir_config('config', false);

        if ($dirConfig) {
            $this->_config = $dirConfig;
        }

        if (!empty($config)) {
            foreach ($config as $key => $value) {
                $this->_config[$key] = $value;
            }
        }

        // not sure this is needed
        $this->app_id = $this->_config['app_id'];

        // echo $this->app_id; exit;

        // ee($this->_config);

        


        // autoload models

     
        // add site url
        $this->base_route = !empty($this->_config['site_url']) ? $this->_config['site_url'] : MASTERYL_SITE_URL;

        if(!empty($this->_config['url_prefix'])) $this->base_route .= '/'.$this->_config['url_prefix'];

        $this->api_route = $this->base_route . '/api';

        // DB Prefix
        if(!empty($this->_config['db'])) $this->setupDbConfig($this->_config['db']);

        
        // Define URLS
        // global $masteryl_app;

        // $masteryl_app = $this;
        
                
        return $this;
    }

    private function setupDbConfig($db)
    {
        global $wpdb;

        if(!empty($db['table_prefix'])) 
        $this->db_table_prefix = gettype($db['table_prefix']) == 'boolean' ? $this->app_id.'_' : $db['table_prefix'];

        if(MASTERYL_IS_WP) $this->db_table_prefix = $wpdb->prefix . $this->db_table_prefix;

        self::$_s_db_table_prefix = $this->db_table_prefix;
        
    }

    protected static $_s_db_table_prefix = '';

    public static function getTablePrefix()
    {
        return self::$_s_db_table_prefix;
    }
}
