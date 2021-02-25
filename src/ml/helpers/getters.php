<?php

/**
 * WP ONLY
 */

function masteryl_get_plugin_data($key = false, $markup = true, $translate = false)
{
    if (!function_exists('get_plugin_data')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $path = defined('MASTERYL_WP_PLUGIN_PATH') ? MASTERYL_WP_PLUGIN_PATH : MASTERYL_APP_PATH;
    

    if(defined('MASTERYL_WP_PLUGIN_SLUG')) {
        $slug = MASTERYL_WP_PLUGIN_SLUG;
    } else {
        $part = explode('/', rtrim($path, '/'));
        $slug = array_pop($part);
    }
    
    $plugin = $slug.'/'.$slug.'.php';
    $file = $path . $slug . '.php';
    
    // support non-directory plugins
    if (!file_exists($file)) {
        $file = rtrim($path, '/').'.php';
        $plugin = $slug.'.php';
    }
    

    $data = get_plugin_data($file, $markup, $translate);
    

    // custom adders
    $data['plugin'] = $plugin;
    $data['slug'] = $slug;

    if ($key) {
        return $data[$key];
    }
    return $data;
}

function masteryl_get_config() {
  echo 'helpers: masteryl_get_config'; exit;
}


function masteryl_get_dir_config($name = 'config', $def = [], $ext = 'php')
{
  $path = substr(MASTERYL_CONFIG_PATH, 0, -1);

  if(!file_exists($path)) {
      return $def;
  }

  $files = scandir($path);

  $files = array_filter($files, function ($file) use ($ext) {
      return strpos($file, '.' . $ext) > 1;
  });

  $options = [];

  if (!empty($files) && is_array($files)) {
      foreach ($files as $file) {
          if ($file != $name . '.' . $ext) {
              $options[strstr($file, '.', 1)] = require "{$path}/{$file}";
          } else {
              $master = require "{$path}/{$file}";
          }
      }
  }

  if (isset($master)) {
      foreach ($master as $k => $v) {
          $options[$k] = $v;
      }
  }

  return $options;
}

function masteryl_get_env_file($file = '.env', $def = false)
{

  $path = substr(MASTERYL_APP_PATH, 0, -1); // remove trailing slash
  // echo 'masteryl_get_env_file: '.$path; exit;
  $level = 1;

  $dirs = explode('/', $path);

  $n = count($dirs);

  $env = null;

  for ($i = 0; $i < $n; $i++) {

      $dir = implode('/', $dirs) . '/' . $file;


      // found it
      if (file_exists($dir)) {
          break;
      }

      if (!array_pop($dirs)) {
          $dir = false;
          break;
      }
  }

  if (!$dir) {
      return $def;
  }

  $rows = explode(PHP_EOL, trim(file_get_contents($dir)));

  $rows = array_filter($rows, function ($row) {
      $row = trim($row);
      return empty($row) || strpos($row, '#') === 0 ? false : true;
  }, 0);

  if (empty($rows)) {
      return $def;
  }

  $values = [];

  foreach ($rows as $row) {

      // check first character is valid
      $row = trim($row);
      $fc = substr($row, 0, 1);
      if(masteryl_str_has_special_chars($fc)) {
          continue;
      }
    
      $a = explode('=', $row);
      $values[$a[0]] = trim($a[1], '"');
  }

  return $values;
}


/**
 * Non WP Fallback
 */
function masteryl_get_site_url($ext = '', $params = [])
{
    // if set in config, add that here

    if ($ext != '') {
        $ext = '/' . ltrim($ext, '/');
    }
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
        . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    preg_match('/(http\:\/\/|https\:\/\/)(www\.){0,4}([a-z0-9\-_\.]+)/', strtolower($url), $match);

    $url = $match[0] . $ext;

    if (!empty($params)) {
        $url .= '?';
        foreach ($params as $key => $value) {
            $url .= $key . '=' . urlencode($value) . '&';
        }
        $url = rtrim($url, '&');
    }

    return $url;
}

// function masteryl_get_url_args


function masteryl_get_files_v1($dirs = [], $contents = false, $requireFile = false, $fileType = 'php')
{


    $items = [];

    if (!is_array($dirs)) {
        $dirs = [$dirs];
    }

    foreach ($dirs as $dir) {

        $dir = __DIR__ . '/../' . trim($dir, '/');

        if (!file_exists($dir)) {
            // echo 'NOT FOUND: '.$dir; exit;
            continue;
        }

        $files = scandir($dir);

        if (empty($files)) {
            continue;
        }

        foreach ($files as $file) {
       
            $part = explode('.', $file);
            $type = array_pop($part);
            if ($fileType == $type) {

                $item = [
                    'path' => $dir . '/' . $file,
                    'file' => $file,
                    'type' => $type,
                    'name' => implode('.', $part),
                ];

                if ($contents) {
                    $item['contents'] = file_get_contents($dir . '/' . $file);
                }

                array_push($items, $item);

                if ($requireFile) {
                    require_once $dir . '/' . $file;
                }

            }

        }

    }

    return $items;

}





function masteryl_get_domain($url = '', $prefix = '', $postfix = '')
{

    $url = str_replace('://www.', '://', strtolower($url));
    preg_match('/(?<=:\/\/)([a-zA-Z\.]{0,255})/', $url, $m);

    return $prefix . $m[0] . $postfix;
}
