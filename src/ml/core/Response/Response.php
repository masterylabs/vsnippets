<?php


class Masteryl_Response
{
    use
    Masteryl_Response_Api,
    Masteryl_Response_Getters,
    Masteryl_Response_Headers,
    Masteryl_Response_Methods,
        Masteryl_Response_Route,
        Masteryl_Response_Download;

    private $target = '';

    private $status_code;

    private $app_path;

    private $base_route;

    private $routes;

    private $views_dir = 'views';

    private $app;

    public function __construct($app)
    {
        $this->app = $app;
        
        $path = MASTERYL_APP_PATH;

        if (!empty($app->valid_route_module)) {
            $path .= $app->valid_route_module . '/';
        }

        $this->app_path = $path;

        $this->base_route = $app->base_route;

        if (!empty($app->route_names)) {
            $this->routes = $app->route_names;
        }
    }
}
