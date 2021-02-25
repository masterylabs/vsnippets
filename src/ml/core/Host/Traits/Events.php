<?php

trait Masteryl_Host_Events
{
    public function onActivate()
    {

        $data = $this->app->getInfo();
        

        $endpoint = 'activate';

        $response = $this->post($endpoint, $data);

      
        $body = $response->getBody();
        $code = $response->getCode();
        
        
        if (in_array($code, [400, 402, 403, 405])) {
            echo !empty($body->message) ? $body->message : 'Not allowed';
            exit;
        }

        if( !empty($body->public_key)) 
        $this->app->meta()->set('install_public_key', $body->public_key);
            
       
    }

    public function onDeactivate()
    {
        $data = [
            'secret_key' => $this->app->getSecretKey('install')
        ];

        $endpoint = 'deactivate';

        // no response processing required
        $this->post($endpoint, $data);
       

    }
    

    
}
