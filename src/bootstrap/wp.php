<?php

require __DIR__ . '/../ml/ml.php';

$app = Masteryl_App::create();

// WordPress
$app->module('wp');

// Auth
// $app->module('user-auth');

// Client
// $middleware = [['module' => 'user-auth', 'name' => 'user-auth']];
// $app->module('client', compact('middleware'));
$app->module('client');
// Settings
// $app->module('settings');

// Optionals
// $app->module('vue');
// $app->module('admin-page', ['vue' => 'client/index', 'auth' => 'user-auth']); 

// Routes
require __DIR__ . '/../routes/web.php';
require __DIR__ . '/../routes/api.php';

add_action('plugins_loaded', function () use ($app) { 
  $app->run();
});