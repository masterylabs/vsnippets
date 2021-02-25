<?php

include __DIR__ . '/Traits/ManualCheck.php';
include __DIR__ . '/Traits/UpdatePlugin.php';
include __DIR__ . '/WpUpdateChecker.php';


$checker = new Masteryl_WpUpdateChecker($app);

add_filter( 'transient_update_plugins', function($update_plugins) use($checker) {

  $update_plugins = $checker->updatePlugins($update_plugins);

  return $update_plugins;

});


add_filter( 'site_transient_update_plugins', function($update_plugins) use($checker) {

  $update_plugins = $checker->updatePlugins($update_plugins);

  return $update_plugins;

});

add_filter('plugin_row_meta', function($meta, $plugin) use($checker) {

  if($checker->plugin != $plugin || !current_user_can('update_plugins')) return $meta;
  
  return $checker->loadManualCheck($meta, $plugin);
  
}, 10, 2);  

