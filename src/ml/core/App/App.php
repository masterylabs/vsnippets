<?php

// if (class_exists('Masteryl_App')) {
//     return;
// }

class Masteryl_App
{
    use Masteryl_NameToFile,
        Masteryl_MakeKey,

    // Router Traits
    Masteryl_App_Router_Api,
    Masteryl_App_Router_Calls,
    Masteryl_App_Router_Collection,
    Masteryl_App_Router_Events,
    Masteryl_App_Router_Group,
    Masteryl_App_Router_Methods,
    Masteryl_App_Router_Middleware,
    Masteryl_App_Router_Name,
    Masteryl_App_Router_Namespace,
    Masteryl_App_Router_Validations,
    Masteryl_App_Router_IgnoreRoutes,

    // Traits
    Masteryl_App_Create,
    Masteryl_App_Db,
    Masteryl_App_Fs,
    Masteryl_App_Getters,
    Masteryl_App_Host,
    Masteryl_App_License,
    Masteryl_App_Loaders,
    Masteryl_App_Meta,
    Masteryl_App_Migrate,
    Masteryl_App_Module,
    Masteryl_App_Run,
    Masteryl_App_Remote,
    Masteryl_App_Settings;

    public $app_id;

    public $app_url;

    public $site_url;

    public $request_method;

    public $app_prefix = 'Masteryl_';

    public $base_route;

    public $api_route;

    private $mailer; // not sure whats going on here

    private $route_atts = [];

    private $route_names = [];
    


    /**
     * Router
     */
    private $is_api_route = false;

    private $is_valid_route = false;

    private $is_valid_module_route = false;

    // private $is_valid_api = false;

    private $valid_route_middleware = [];

    private $valid_route_cb;


    /**
     * NEW VERSION
     */

    /**
     * Public
     */

    public $version = '0.0.1';

    protected $db_table_prefix = '';

    /**
     * Private
     */

    private $_config;

    private $_host;

    private $_db; // made private

    private $_info;
    
    private $_cors_allowed = false;

    private $_class_prefix = 'Masteryl_';

    public function getProp($key, $def = null)
    {
        return isset($this->{$key}) ? $this->{$key} : $def;
    }


    public static function env($key, $def = '')
    {
        return isset(self::$_env) && !empty(self::$_env[$key]) ? self::$_env[$key] : $def;
    }
}
