<?php

/**
 * Activation
 */

register_activation_hook($this->app_file, function() use($app) {
  $app->activate();
  $app->migrate();
});

register_deactivation_hook($this->app_file, function() use($app) {
  $app->deactivate();
});

/**
 * Update
 */
include __DIR__ . '/update-checker/index.php';


/**
 * Auto update complete
 */
add_action( 'upgrader_process_complete', function($uo, $opt) use($app) {

  if ($opt['action'] == 'update' && $opt['type'] == 'plugin' )
  foreach($opt['plugins'] as $i)
  if ($i == MASTERYL_WP_PLUGIN_FILE) $app->migrate();  

},10, 2);