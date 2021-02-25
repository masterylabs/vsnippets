<?php

trait Masteryl_App_Loaders
{
    protected $pending_loads = [];

    

    public function addAction($action, $items = [])
    {
        $app = $this;

        if (!is_array($items)) {
            $items = [$items];
        }

        foreach ($items as $item) {
            $file = MASTERYL_APP_PATH . 'app/' . $item . '.php';

            if (file_exists($file)) {
                require_once $file;

                $a = explode('/', $item);
                $name = $this->app_prefix . end($a);

                add_action($action, function () use ($app, $name) {
                    new $name($app);
                });

            
            }
        }
    }

    public function load($items)
    {
        if (!is_array($items)) {
            $items = [$items];
        }

        foreach ($items as $item) {
            $file = MASTERYL_APP_PATH . 'app/' . $item . '.php';

            if (file_exists($file)) {
                require_once $file;

                $a = explode('/', $item);
                $name = $this->app_prefix . end($a);

                $this->pending_loads[] = $name;

            }
        }
    }
}
