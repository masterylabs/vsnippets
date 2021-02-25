<?php

function masteryl_camel_to_snake($input) 
  {
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
    $ret = $matches[0];
    foreach ($ret as &$match) {
      $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    }
    return implode('_', $ret);
  }


function masteryl_get_app_url($ext='')
{
  
    
  if(MASTERYL_IS_WP) {

    $url = plugin_dir_url(__FILE__);
    
    $url = strstr($url . '/', '/ml/', 1);

    // echo 'appurl: '.$url; exit;
  }
  else {
    $url = masteryl_get_site_url();
  }

  if($ext != '') {
    $url .= '/'.ltrim($ext, '/');
  }

  return $url;
}