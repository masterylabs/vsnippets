<?php
$args = [
  // 'path' => '',
  // 'namespace' => '',
  // 'middleware' => ''
];

$app->collection('video');


$app->api([], function() use($app) {

  $app->get('video/{video}', 'VideoController@api');

  $app->get('player-branding', 'PlayerBrandingController@index');
  $app->post('player-branding', 'PlayerBrandingController@update');
  
  
  // $app->get('marketing', 'MarketingController@index');
  $app->post('pause-banner', 'MarketingController@updatePauseBanner');
  $app->post('promo-alert', 'MarketingController@updatePromoAlert');
  $app->post('end-poster', 'MarketingController@updateEndPoster');

  // $app->get('test', function($req, $res) use($app) {
  //   $model = new Masteryl_TestModel(true);
  //   return $res->data($model);
  // });

  // $app->post('test', function($req, $res) use($app) {
  //   // ee($update, $req);
  //   Masteryl_TestModel::update($req->jsonData);
  //   ee('done');
  //   $model = new Masteryl_TestModel(true);
  //   return $res->data($model);
  // });
});
