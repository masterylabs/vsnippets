<?php


class Masteryl_Host
{
    use Masteryl_Host_Events, Masteryl_Host_Methods;

    private $app;
  
    private $site_info;

    private $app_host;

    public function __construct($app)
    {
        $this->app = $app;
        $this->app_host = $app->getConfig('app_host').'/'.$app->app_id;
    }



    /**
     * Privates
     */

    private function get($endpoint, $data = [])
    {
        $headers = [
            'x-ml-authorization' => $this->app->getSecretKey('install')
        ];

        $url = $this->app_host . '/' . ltrim($endpoint, '/');
    
        return $this->app->remote()->get($url, $data, $headers);
    }

    private function post($endpoint, $data = [])
    {
        $headers = [
            'x-ml-authorization' => $this->app->getSecretKey('install')
        ];

        $url = $this->app_host . '/' . ltrim($endpoint, '/');
    
        return $this->app->remote()->post($url, $data, $headers);
    }
}
