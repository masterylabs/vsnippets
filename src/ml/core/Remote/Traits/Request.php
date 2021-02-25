<?php

trait Masteryl_Remote_Request
{
    private $response_body;

    private $response_code;

    
  
    public function request($method = 'GET', $url = '', $args = [])
    {
        if(!empty($args['params'])) {

            $url = masteryl_url_append_params($url, $args['params']);
            unset($args['params']);

        }

        if (MASTERYL_IS_WP) {
            $args['method'] = $method;
            
            if(empty($args['timeout'])) $args['timeout'] = 120;

            // echo $url; exit;
            // ee($args);

            $response = wp_remote_request($url, $args);

            $this->response_body = $response['body'];

            // ee($url, $response);

            $this->response_code = (int) $response['response']['code'];

            return $this;
        }
    
        // masteryl_remote_request()
    }
}
