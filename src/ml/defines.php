<?php

// version 2 always defined

define('MASTERYL_IS_WP', defined('MASTERYL_WP_PLUGIN_FILE'));

if(!defined('MASTERYL_PATH')) 
define('MASTERYL_PATH', __DIR__.'/');

if(!defined('MASTERYL_APP_PATH'))
define('MASTERYL_APP_PATH', substr(MASTERYL_PATH, 0, -3));

if(!defined('MASTERYL_CONFIG_PATH'))
define('MASTERYL_CONFIG_PATH', MASTERYL_APP_PATH . 'config/');

if(!defined('MASTERYL_MIGRATIONS_PATH'))
define('MASTERYL_MIGRATIONS_PATH', MASTERYL_APP_PATH . 'db/migrations/');

// used for non-wp file system
if(!defined('MASTERYL_UPLOADS_PATH'))
define('MASTERYL_UPLOADS_PATH', MASTERYL_PATH . '../');


/**
 * Structure change options
 */

if(!defined('MASTERYL_MODULES_PATH'))
define('MASTERYL_MODULES_PATH', MASTERYL_PATH . 'modules/');


// module migrations is always modules path/migrations

// eg. MASTERYL_CONTROLLERS_PATH

foreach(['Collections', 'Controllers', 'Middleware', 'Models'] as $i) {
  $d = 'MASTERYL_'.strtoupper($i).'_PATH';  
  if(!defined($d)) 
  define($d, MASTERYL_APP_PATH . 'app/'.$i.'/');
}

