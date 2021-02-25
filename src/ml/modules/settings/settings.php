<?php

masteryl_autoload(__DIR__ . '/Traits');

class Masteryl_Settings 
{
  use Masteryl_Settings_Methods;

  private $app;

  private $use_api = true;

  private $api_endpoint = 'settings';

  private $db_key = 'settings';
  
  private $fields = [];

  private $values; // should be unset

  // TODO SETTINGS AUTH

  // Start settings (bootstrap)
  public function __construct($app, $args = [])
  {
    $this->app = $app;

    if(!empty($args)) {
      foreach($args as $key => $value) 
      $this->{$key} = $value;
    }

    if($this->use_api) $this->loadRoutes();

  }

  

  public function addFields($fields)
  {
    foreach($fields as $i) if(!in_array($i, $this->fields)) array_push($this->fields, $i);    
  }

  public function getFields()
  {
    return $this->fields;
  }

  public function useApi() {
    return $this->use_api;
  }

  private function loadRoutes()
  {
    $app = $this->app;
    $app->api([], function () use ($app) {
      $app->get('/settings', 'SettingsController@index');
      $app->post('/settings', 'SettingsController@update');  
    });
  }
}


$app->settings = new Masteryl_Settings($app, $options);



// $property->setAccessible(true);

// echo 'settings module'; exit;