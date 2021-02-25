<?php
$args = [
  // 'path' => '',
  // 'namespace' => '',
  // 'middleware' => ''
];

$app->api($args, function() use($app) {
  $app->get('/sample', 'SampleController@api');
});