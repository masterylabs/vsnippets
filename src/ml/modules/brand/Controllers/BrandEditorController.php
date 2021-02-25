<?php

class Masteryl_BrandEditorController
{
  public function js($req, $res)
  {
    $app = $req->getApp();

    $brand = Masteryl_Brand::get($app);
    $slug = $brand->getSlug();
    $name = $brand->getName();

    $file = MASTERYL_APP_PATH . 'public/gutenberg/editor.js';
    $data = file_get_contents($file);
    $data = str_replace('WP Image Drop', $name, $data);
    $data = str_replace('admin.php?page=wp-image-drop-window', "admin.php?page={$slug}-window", $data);
    $data = str_replace('wp-image-drop-content', "{$slug}-content", $data);
    
    return $res->js($data);
   
  }

}