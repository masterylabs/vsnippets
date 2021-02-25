<?php

$app->collection('broadcast', ['email', 'sender', 'contacts']);

$app->api([], function() use($app) {
  $app->post('broadcasts/{id}/add-contacts', 'BroadcastContactController@add');
  $app->post('broadcasts/{id}/remove-contacts', 'BroadcastContactController@remove');
  $app->post('broadcasts/{id}/set-contacts', 'BroadcastContactController@set');
  $app->get('broadcasts/{id}/contacts-ids', 'BroadcastContactController@ids');

  // send
  $app->post('broadcasts/{id}/send', 'BroadcastSendController');
  
});
