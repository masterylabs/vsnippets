<?php

class Masteryl_ShortcodeController extends Masteryl_Shortcode
{
  protected $args = [
    'somethign_else' => 2,
    'aspect_ratio' => '16/9',
    'max_width' => '1280px'
    // 'id' => '100'
  ];
    // protected $required_args = ['ss']; // fails without
  
  function handle($args, $content) {

    global $masteryl_app;

    $video = Masteryl_Video::find($args['id'], ['identifier']);

    if(!$video) return $content;

    // ee($video->identifier);
    $id = str_replace('vide_', '', $video->identifier);
    $url = "{$masteryl_app->base_route}/embed/{$id}";

    // get aspect ratio
    $part = explode('/', $args['aspect_ratio']);
    $aspectRatio = ((int) $part[1] / (int) $part[0]) * 100;

    if(empty($aspectRatio)) $aspectRatio = 56.25;

    if(!empty($args['aspect_ratio'])) {
      $part = explode('/', $args['aspect_ratio']);
      $val = (int) $part[1] / (int) $part[0];
      if(!empty($val) && is_numeric($val)) {
        $aspectRatio = $val * 100;
      }
    }
    // ee($aspectRatio);
    if(is_numeric($args['max_width'])) $args['max_width'] .= 'px';
  
  
    $content .= '<div style="width: 100%;max-width: '.$args['max_width'].';margin:auto;clear:both"><div  class="vsnippets-player-container" style="position: relative;padding-bottom: '.$aspectRatio.'%;height: 0;overflow: hidden;"><iframe src="'.$url.'" width="1280" height="480" frameborder="0" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%; padding:0px; margin: 0px" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" scrolling="no"></iframe></div></div>';
    
    // add script once
    // if(empty($this->app->shortcode_embedded)) {
    //   $this->app->shortcode_embedded = 1;
    //   $url = MASTERYL_PUBLIC_URL . '/js/embed.js';
    //   $content .= '<script src="'.$url.'"></script>'; 
    // }

    // $content .= "RETURNING<div class='wp-video-surveys-embed' data-contact='cont_".rand()."' data-survey='surv_".rand()."'>EMBED</div>";

    // $content .= "<script>window.WPVideoSurveyEmbed('MY-SURVEY-ID')</script>";

    return $content;


  }
}