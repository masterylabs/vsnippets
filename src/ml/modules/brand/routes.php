<?php

$args = ['path' => 'brand'];

$args['middleware'] = !empty($options['middleware']) ? $options['middleware'] : [];

array_push($args['middleware'], ['module' => 'brand', 'name' => 'brand']);

// ee($args); only if active
$app->get('custom-gutenberg-editor-js', 'BrandEditorController@js');

$app->api($args, function() use($app) {
  $app->get('', 'BrandController@index');
  $app->post('', 'BrandController@update');
  $app->post('delete', 'BrandController@destroy');
});
