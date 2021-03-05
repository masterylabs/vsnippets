<?php

require __DIR__ . '/getters.php';
require __DIR__ . '/loaders.php';
require __DIR__ . '/make-key.php';
require __DIR__ . '/provisional.php';
require __DIR__ . '/remote.php';

if(!MASTERYL_IS_WP) {
require __DIR__ . '/nwp/serialize.php';
}

// wp functions
// else {

// }

if (!function_exists('getallheaders')) {
    function getallheaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}

/**
 * Check dir and return valid files
 */

 function masteryl_get_name_from_path($path)
 {
     $i = explode('/', rtrim($path, '/'));
     $e = end($i);
     if(strstr($e, '.') == false) {
         return $e;
     }
     $ii = explode('.', $e);
     return $ii[count($ii)-2];

 }

 function masteryl_get_files($dir, $types = ['php', 'js', 'css', 'html', 'json'], $false = false)
 {
    $items = masteryl_scandir($dir);

    if(!$items) {
        return $false;
    }

    $files = [];

    foreach($items as $item) {
        $ext = explode('.', $item);
        if(in_array(end($ext), $types)) {
            $files[] = $item;
        }
    }

    return $files;
 }


 function masteryl_get_dirs($dir) 
 {
    $items = masteryl_scandir($dir);

    if(!$items) {
        return $false;
    }

    $dirs = [];

    foreach($items as $item) {
        if(is_dir($item)) {
            $dirs[] = $item;
        }
    }

    return $dirs;
 }

function masteryl_scandir($path, $false = false) {
    $path = rtrim($path, '/');
    
    if(!file_exists($path)) {
        return $false;
    }

    $files = [];

    $items =  scandir($path);

    foreach ($items as $item) {
        if (in_array($item, ['.', '..'], true)) {
            continue;
        }
        $files[] = $path.'/'.$item;
    }

    return $files;
}

function masteryl_path_exists($path)
{
    return file_exists(substr($path, 0, -1));
}

function masteryl_url_append_params($url, $params = [])
{
    $url .= strpos($url,'?') > -1 ? '&' : '?';

    foreach($params as $key => $val) {
        $val = urlencode($val);
        $url .= "{$key}={$val}&";
    }
    return rtrim($url, '&');
}

function masteryl_ends_width( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
  }


function masteryl_env($key, $def = '')
{
    return Masteryl_App::env($key, $def);
}




function masteryl_str_has_special_chars( $string ) {
    return preg_match('/[^a-zA-Z\d]/', $string);
}


function masteryl_slugify($str, $sep = '-')
{
    $str = strtolower(str_replace(' ', '-', trim($str)));
    $str = preg_replace('/(\-){2,10}/', '-', $str);
    $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
    if ($sep != '-') {
        $str = str_replace('-', $sep, $str);
    }
    return $str;
}

function masteryl_db_decode_str($str = '', $array = false)
{
    return json_decode(urldecode(base64_decode($str)), $array);
}

function masteryl_db_encode_str($str = '')
{
    return base64_encode(urlencode(json_encode($str)));
}

function masteryl_db()
{
    global $wpdb;

    // WordPress (could be in app)
    if (is_object($wpdb) && isset($wpdb->base_prefix)) {
        return $wpdb;
    }

    // No WordPress
    global $app;
    return $app->db();
}


function masteryl_send_json($data = '', $code = 200)
{
    header('Content-type: application/json');
    http_response_code($code);
    echo json_encode($data);
    exit;
}

function masteryl_get_client_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return $_SERVER['REMOTE_ADDR'];

}

function masteryl_use_dir($dirs = [], $fileType = 'php')
{
    if (!is_array($dirs)) {
        $dirs = [$dirs];
    }

    foreach ($dirs as $dir) {

        $dir = __DIR__ . '/../' . trim($dir, '/');

        if (!file_exists($dir)) {
            continue;
        }

        $files = scandir($dir);

        if (empty($files)) {
            continue;
        }

        foreach ($files as $file) {
            $part = explode('.', $file);
            if ($fileType == end($part)) {
                require_once $dir . '/' . $file;
            }

        }
    }

}



/**
     * v2
 */

function masteryl_camelize($i, $sep = '_')
 {
    $i = str_replace(' ', $sep, $i);
    $i = str_replace('-', $sep, $i);
    return str_replace($sep, '', ucwords($i, $sep));
 }


 function masteryl_object_merge($a, $b) {
  return (object) array_merge((array) $a, (array) $b);
}
