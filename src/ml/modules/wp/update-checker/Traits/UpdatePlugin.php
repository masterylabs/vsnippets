<?php


trait Masteryl_WpUpdateChecker_UpdatePlugin
{

  public function updatePlugins($update_plugins)
  {
    if(!is_object( $update_plugins)) return $update_plugins;

	  if (!isset( $update_plugins->response) || !is_array($update_plugins->response)) 
    $update_plugins->response = [];
  
    $update = $this->getUpdate();

    if(empty($update->version)) return $update_plugins;

    $updateAvailable = !empty($update) && version_compare($this->version, $update->version, '<');

    if(!$updateAvailable) {
      // append empty template to support auto updates ??
      return $update_plugins;
    }

    $response = (object) [
      'slug'         => $this->slug,
      'new_version' => $update->version,
      'package' => $update->download_url
    ];

    $update_plugins->response[$this->plugin] = $response;

    return $update_plugins;

  }

  protected function getUpdate()
  {
    // check if transiet exists, if not get new
    $value = get_transient($this->transient_key);

    if($value) return $value; 
    
    $value = $this->app->host()->getUpdate();
    
    set_transient($this->transient_key, $value, $this->check_minutes * 60);
    
    return $value;
  }


 
}