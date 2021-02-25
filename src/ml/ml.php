<?php

/**
 * ML Version: 0.0.3
 */


// required before helpers

require __DIR__ . '/defines.php';

require __DIR__ . '/helpers/helpers.php';

// define app
$masteryl_app;

/**
 * Conditional Defines
 */

if(!defined('MASTERYL_PUBLIC_URL')) {
  if(MASTERYL_IS_WP) define('MASTERYL_PUBLIC_URL', plugin_dir_url(__DIR__).'public');
  else define('MASTERYL_PUBLIC_URL', masteryl_get_site_url());
}

if(!defined('MASTERYL_PUBLIC_PATH')) define('MASTERYL_PUBLIC_PATH', MASTERYL_APP_PATH . 'public/');

if(!defined('MASTERYL_SITE_URL')) {
  if(MASTERYL_IS_WP) define('MASTERYL_SITE_URL', get_site_url());
  else define('MASTERYL_SITE_URL', masteryl_get_site_url());
}


// Load Core
masteryl_autoload(MASTERYL_PATH . 'core');

// Load Models 
if(file_exists(MASTERYL_MODELS_PATH)) masteryl_autoload(MASTERYL_MODELS_PATH);
