<?php

class Masteryl_Request
{
    use Masteryl_Request_Getters,
        Masteryl_Request_Validate,
        Masteryl_Request_Headers;

    private $_vars = [];

    private $_app;

    // private $__config;

    private $request_method;

    private $route_vars = [];

    private $headers;

    private $request_uri;

    private $request_protocol;

    private $request_url;

    // private $request_query_string;

    private $request_vars = [];

    public function getApp()
    {
        return $this->_app;
    }

    public function __construct($app)
    {
        $this->_app = $app;

        $vars = $app->getProp('route_atts');
        $method = $app->getProp('request_method');
        $appPath = MASTERYL_APP_PATH;
        $appConfig = $app->getConfig();

        $this->request_method = $method ? $method : $_SERVER['REQUEST_METHOD'];

        $this->set('_config', $appConfig);

        if ($appPath) {
            $this->set('app_path', MASTERYL_APP_PATH);
        }

        if (!empty($_REQUEST)) {
            $this->request_vars = $_REQUEST;

            foreach ($_REQUEST as $k => $v) {
                $this->{$k} = $v;
            }
        }

        $data = json_decode(file_get_contents('php://input'));
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $this->{$k} = $v;
            }
        }

        if (!empty($vars)) {
            $this->route_vars = $vars;
            foreach ($vars as $k => $v) {
                $this->{$k} = $v;
            }
        }

        $this->headers = getallheaders();

        if (is_array($this->headers)) {
            $this->headers = array_change_key_case($this->headers);
        }


        /**
         * Get Request URI
         */

        $this->request_uri = $_SERVER['REQUEST_URI'];

        $this->request_protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        $this->request_url = $this->request_protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        // not sure is needed
        // $this->request_query_string = $_SERVER['QUERY_STRING'];
    }

    public function only($keys = []) {
        $values = [];
        foreach($keys as $key) {
            if(isset($this->{$key})) {
                $values[$key] = $this->{$key};
            }
        }
        return $values;
    }

    public function toArray()
    {
        if(empty($this->request_vars)) {
            return [];
        }
        
        $arr = [];

        foreach($this->request_vars as $key => $val) {
            $arr[$key] = $value;
        }
        return $arr;
    }

    public function getMethod()
    {
        return $this->request_method;
    }

    public function header($key, $val = '')
    {
        $key = strtolower($key);
        return is_array($this->headers) && !empty($this->headers[$key]) ? $this->headers[$key] : $val;
    }

    public function has($key)
    {
        return !empty($this->request_vars[$key]);
    }

    public function hasAny($arr = [])
    {
        $has = false;

        foreach ($arr as $i) {
            if ($this->has($i)) {
                $has = true;
                break;
            }
        }

        return $has;
    }

    public function hassAll($arr = [])
    {
        $has = true;

        foreach ($arr as $i) {
            if (!$this->has($i)) {
                $has = false;
                break;
            }
        }

        return $has;
    }
}
