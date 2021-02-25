<?php

class Masteryl_WpUpdateChecker
{
  use Masteryl_WpUpdateChecker_UpdatePlugin, 
  Masteryl_WpUpdateChecker_ManualCheck;

  public $check_minutes = 720; 
  
  public $app;

  public $info;

  public $plugin;

  public $slug;

  public $transient_key;

  public $version; // currentv ersion

  protected $manual_check_url_append = '-check-updates';

  public function __construct($app, $manualCheck = true)
  {
    $this->app = $app;

    $this->plugin = "{$app->app_id}/{$app->app_id}.php";

    $this->transient_key = $app->app_id . '_wp_update_checker';

    $data = $app->getPluginInfo();

    $this->plugin = $data['plugin'];

    $this->slug = $data['slug'];

    $this->version = $data['Version'];

    // autoupdates clear
    if($manualCheck && !empty($_GET) && !empty($_GET[$this->slug.$this->manual_check_url_append])) {
      $this->manualCheck();
    }

  }

  
  
}


































//
