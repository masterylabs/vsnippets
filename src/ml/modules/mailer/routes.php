<?php

$app->api(['pathx' => 'mailer'], function() use($app) {

  // can be moved to 
  $app->post('test-email', 'TestEmailController@send');
});