<?php

class Masteryl_Remote
{
    use Masteryl_Remote_Request;

    public function success()
    {
        return isset($this->response_code) && $this->response_code < 400;
    }
    

    public function get($url, $params = [], $headers = [])
    {
        return $this->request('GET', $url, compact('params', 'headers'));
    }

    public function post($url, $body = [], $headers = [])
    {
        return $this->request('POST', $url, compact('body', 'headers'));
    }

    public function getCode($def = false)
    {
        return isset($this->response_code) ? $this->response_code : $def;
    }

    public function getBody($def = false)
    {
        return isset($this->response_body) ? json_decode($this->response_body) : $def;
    }

    public function getMessage($def = false)
    {
        $body = $this->getBody();

        if(!$body || empty($body->message))
        return $def;

        return $body->message;
    }


    public function head($headers = [])
    {
    }

    public function getJson()
    {
        
        return [
      'status_code' => !empty($this->response_code) ? $this->response_code : null,
      'body' => !empty($this->response_body) ? json_decode($this->response_body) : null
    ];
    }
}
