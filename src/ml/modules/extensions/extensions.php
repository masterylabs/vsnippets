<?php

$app->extensions = [];

$plugins = get_option( 'active_plugins', []);

foreach($options as $ext) {

  $plugin = "{$ext['name']}/{$ext['name']}.php";
  $active = in_array($plugin, $plugins);

  if(!$active) {
    $app->extensions[$ext['name']] = false; 
    continue;
  }

  $path = masteryl_get_plugin_path($ext['name']);

  if(!file_exists(rtrim($path, '/'))) {
    $app->extensions[$ext['name']] = false;
    continue;
  }


  $app->extensions[$ext['name']] = true;

  if(!empty($ext['routes'])) {
    $routes = $ext['routes'];

    if(gettype($routes) == 'boolean') $routes = ['web', 'api'];
    elseif(gettype($routes) == 'string') $routes = [$routes];

    foreach($routes as $route) {
      $route = "{$path}routes/{$route}.php";
      if(file_exists($route)) include_once $route;
    }
  }
}
