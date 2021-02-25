<?php

class Masteryl_WpOptionsPage
{
    protected $app;

    protected $page_title = 'Options'; // = 'Page Title';

    protected $menu_title = 'Options'; //'Menu Title';

    protected $capability = 'install_plugins';

    protected $menu_slug = null;

    protected $position = null;

    public function __construct($app)
    {
        $this->app = $app;

        if (!$this->page_title) {
            $this->page_title = $app->config('name');
        }

        if (!$this->menu_title) {
            $this->menu_title = $this->page_title;
        }

        if (!$this->menu_slug) {
            $url_prefix = $app->config('url_prefix');
            $this->menu_slug = !empty($url_prefix) ? $url_prefix : $app->config('app_id');
            $this->menu_slug .= '-admin';
        }

        add_options_page(
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            [$this, 'handle'],
            $this->position
        );
    }

    public function handle()
    {
        return 'Options Page';
    }
}
