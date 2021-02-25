<?php

$args = [];

if(!empty($options['middleware'])) $args['middleware'] = $options['middleware'];

$app->api($args, function () use ($app) {

    // $app->get('/app', function($req, $res) use($app) {
    //   return $res->text('client plugin app route');
    // });
    $app->get('/app', 'ClientController');
    $app->post('/license', 'ClientController@updateLicense');
    $app->get('/upgrade', 'ClientController@upgrade');
    $app->post('/migrate', 'ClientController@migrate');

  });
