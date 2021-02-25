<?php

$app->api(['path' => 'email-contact'], function() use($app) {

  // can be moved to 
  $app->post('', 'EmailContactController');
});