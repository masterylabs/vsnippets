<?php
$args = [
  'middleware' => [['module' => 'user-auth', 'name' => 'user-auth']]
];

$app->api($args, function() use($app) {
$app->collection('video');
$app->get('player-branding', 'PlayerBrandingController@index');
$app->post('player-branding', 'PlayerBrandingController@update');
$app->post('pause-banner', 'MarketingController@updatePauseBanner');
$app->post('promo-alert', 'MarketingController@updatePromoAlert');
$app->post('end-poster', 'MarketingController@updateEndPoster');
});

$app->api([], function() use($app) {
  $app->get('video/{video}', 'VideoController@api');
});
