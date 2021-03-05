<?php

require __DIR__ . '/../ml/ml.php';

$app = Masteryl_App::create();

// WordPress
$app->module('wp');

// Auth
$app->module('user-auth');

// Client
$middleware = [['module' => 'user-auth', 'name' => 'user-auth']];
$app->module('client', compact('middleware'));


// Optionals
$app->module('vue');
$app->module('admin-page');

$app->module('shortcode');

// Routes
require __DIR__ . '/../routes/web.php';
require __DIR__ . '/../routes/api.php';


// footer script

add_action( 'wp_enqueue_scripts', function() {

  global $post;

  if(empty($post->ID) || empty($post)) return;
  
  global $masteryl_app;

  $handler = $masteryl_app->app_id . '-footer-js';
  $src = MASTERYL_PUBLIC_URL . '/js/live-footer.js';
  wp_enqueue_script($handler, $src, [], false, true);
});


add_action('plugins_loaded', function () use ($app) { 
  $app->run();
});