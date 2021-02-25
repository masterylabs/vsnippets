<?php

if(!$app->hasAddon('developer')) return; // !is_admin() || !empty($options['frontend']) || 


class Masteryl_Brand
{
  protected $fills = [
    'topbar_title', 
    'topbar_label',
    'menu_title',
    'theme_color', 
    'allow_volt',
    'allow_search', 
    'allow_settings',
    'logo',
    'active',
    'admin_user_id'
  ];

  protected $app;

  protected $meta;

  protected $bools = [
    'allow_volt',
    'allow_search', 
    'allow_settings',
    'active'
    ];

  public function __construct($app)
  {
    $this->app = $app;

    $this->meta = $app->meta();
    
    $item = (object) $this->meta->get('brand', []);

    if(empty($item)) return;

    foreach($item as $key => $val) {
      if(!in_array($key, $this->fills)) continue;
      if(in_array($key, $this->bools)) $val = !empty($val);
      $this->{$key} = $val;
    }
    
    return $this;
  }

  public function isClient($id) {
    return !empty($this->admin_user_id) && $this->admin_user_id != $id ? true : false;
  }

  public function isActive() {
    return !empty($this->active);
  }

  public static function get($app)
  {
    return new self($app);

    // return $brand->getValues();
  }

  public function getValues() 
  {
    $values = [];
    foreach($this->fills as $i) {
      if(isset($this->{$i})) $values[$i] = $this->{$i};
    }

    return (object) $values;
  }

  public function update($values) {
    
    // update self

    foreach($values as $key => $val) {
      if(!in_array($key, $this->fills)) continue;
      if(in_array($key, $this->bools)) $val = !empty($val);
      $this->{$key} = $val;
    }

    // create update
    $values = $this->getValues();

    $this->meta->set('brand', $values);
  }

  public function getSlug() 
  {
    $slug = '';

    if(!empty($this->menu_title)) $slug = sanitize_title($this->menu_title);
    else $slug = 'custom';

    if(strlen($slug) < 8) $slug = $this->app_id . '-'.$slug;

    return $slug;
  }

  public function getName() {
    
    if(!empty($this->topbar_title)) $name = $this->topbar_title;
    elseif(!empty($this->menu_title))  $name = $this->menu_title; 
    else $name = 'WP Image Drop';
    return preg_replace("/[^A-Za-z0-9 ]/", '', $name);
  }
}


$brand = Masteryl_Brand::get($app);

// we can include brand
include __DIR__ . '/routes.php';


if(empty($brand) || empty($brand->active)) return;

$url_prefix = $app->getConfig('url_prefix');

$app->custom_admin_page_menu_title = $brand->menu_title;
$app->custom_admin_page_menu_slug = $brand->getSlug();

$app->custom_gutenberg_editor_js = $app->getRoute('custom-gutenberg-editor-js');

$data = [];

if(!empty($brand->theme_color)) $data['color'] = $brand->theme_color;
if(!empty($brand->logo)) $data['logo'] = $brand->logo;
if(!empty($data)) $app->custom_admin_page_data = $data;