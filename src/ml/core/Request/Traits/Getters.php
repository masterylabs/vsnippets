<?php

trait Masteryl_Request_Getters
{
    public function getRouteVars()
    {
        return $this->route_vars;
    }

    public function getValue($key, $value, $def = '')
    {
        if (isset($this->_vars[$key]) && is_array($this->_vars[$key]) && isset($this->_vars[$key][$value])) {
            return $this->_vars[$key][$value];
        }

        return $def;
    }

    public function get($key, $def = '')
    {
        if (isset($this->_vars[$key])) {
            return $this->_vars[$key];
        }

        if (isset($this->{$key})) {
            return $this->{$key};
        }

        return $def;
    }

    public function set($key, $value)
    {
        $this->_vars[$key] = $value;
    }

    public function add($key, $value='')
    {
        if(is_array($key)) {
            foreach($key as $k => $v) {
                $this->_vars[$k] = $v;
            }
            return;
        }
        $this->_vars[$key] = $value;
    }

    public function getHeaderAuthToken($def = false) {
        return $this->getAuthToken($def, true);
    }

    public function getAuthToken($def = false, $headerOnly = false)
    {
       
        if (empty($this->headers) && ($headerOnly || empty($this->_vars['auth_token']))) {
            return $def;
        }

        $token = '';

        foreach (['authorization', 'x-ml-authorization'] as $i) {
            if (!empty($this->headers[$i])) {
                $token = $this->headers[$i];
            }
        }

        if ($token == '') {
            return (!$headerOnly && !empty($this->request_vars['auth_token'])) ? $this->request_vars['auth_token'] : $def;
        }

        if (strpos($token, ' ') > -1) {
            $part = explode(' ', $token);
            $token = $part[1];
        }

        return $token;
    }
}
