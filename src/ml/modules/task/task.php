<?php

// load tasks
// masteryl_autoload(__DIR__ . '/tasks');

// echo urldecode('1%7Call'); exit;

// $str = 'q=&page=1&pages=936&limit=25&order=desc&orderby=updated&fwi=product,1%7Call&fwo=';

// $query = [
//   'fwi' => 'product,1|all'
// ];

$app->api(['path' => 'tasks'], function() use($app) {
  $app->get('run', 'RunTaskController');
  $app->post('', 'CreateTaskController');
});
