<?php
/**
 * Autoloader
 *
 * @param [type] $path
 * @param boolean $deep
 * @param string $fileType
 * @return void
 */
function masteryl_autoload($path, $deep = true, $fileType = '.php')
{
  $path = rtrim($path, '/');

  if(!file_exists($path)) {
    // var_dump(debug_backtrace()); exit;
    echo 'ERROR path does not exist: '.$path; exit;
  }

  $files =  scandir($path);

  // Load traits first
  // Traits directory is always loaded
  if(in_array('Traits', $files)) {
    masteryl_autoload($path.'/Traits', $deep, $fileType);
  }

  // Load other files and folders

  foreach($files as $file) {
    if(in_array($file, ['.', '..', 'Traits'], true)) {
        continue;
    }

    $filePath = "{$path}/{$file}";

    if(is_dir($filePath) && $deep) {
      masteryl_autoload($filePath, $fileType);
    }

    if(is_file($filePath) && masteryl_ends_width($filePath, $fileType)) {
    
      require_once $filePath;
    }
  }
}


function masteryl_load_dir($dir, $deep = true, $type = 'php')
{
    
    if(!file_exists($dir)) {
        return;
    }

    $files = scandir($dir);

    if(empty($files)) {
        return;
    }

    foreach($files as $file) {
        if(in_array($file, ['.', '..'], true)) {
            continue;
        }

        if(is_dir($file)) {
            echo 'dir'; exit;
            if($deep) {
                $dir = $dir . '/'.$file;
                echo 'directory dir: '.$dir; exit;
                return masteryl_load_dir($dir);
            }
        }

        elseif(end(explode('.', $file)) == $type) {
            require_once $dir . '/'.$file;
        }
       
    }


}