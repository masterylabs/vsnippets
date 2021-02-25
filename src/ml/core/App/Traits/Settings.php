<?php

trait Masteryl_App_Settings
{
  // private $_settings_api = 'settings';

  // private $_settings_path = 'settings';
  
  // private $_settings_fields = [];

  // // TODO SETTINGS AUTH

  // // Start settings (bootstrap)
  // public function settings($fields = false, $args = false)
  // {
  //   if($fields) {
  //     $this->addSettingsFields($fields);
  //   }

  //   if($args && isset($args['api'])) {
  //     $api = $args['api'];
  //    if(gettype($api) == true) $this->_settings_api = $args['endpoint'];
  //     elseif(gettype($api) == 'boolean' && !$api) $this->_settings_api = false;

  //   }

  //   if($this->_settings_api) $this->loadSettingsRoutes();

  // }

  // public function addSettingsFields($fields = []) {
  //    $this->_settings_fields = array_merge($this->_settings_fields, $fields);
  // }

  // private function loadSettingsRoutes()
  // { 
  //   $app = $this;
  //   $this->api([], function() use($app) {
  //     // $app->get()
  //   });
  // }
}
