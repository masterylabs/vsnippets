<?php
include_once __DIR__ . '/WpUploader.php';

$app->api([], function() use($app) {
 
  $app->post('upload', function($req, $res){

    if(empty($_FILES) || empty($_FILES['upload'])) return $res->error('Missing upload');

    add_action( 'wp_loaded', function() use($res) {
     
      $uploader = new Masteryl_WpUploader;

      $response = $uploader->upload();

      $args = [
        'uploaded' => !empty($response['url']),
        'url' => !empty($response['url']) ? $response['url'] : ''
      ];
 
      return $res->json($args);
      
    });
  });
});


// // get media thumb
// function masteryl_upload_get_attachment_url($url) {
//   // exit($url);
//   return 'https://images.unsplash.com/photo-1581863019847-11047c7ceca0?fit=crop&ixid=MXwxMjA3fDB8MHxzZWFyY2h8Mjd8fHN3aXNzJTIwbW91bnRhaW5zfGVufDB8fDB8&ixlib=rb-1.2.1&q=80&w=500';
// }
// add_filter('wp_get_attachment_url', 'masteryl_upload_get_attachment_url');

