<?php


trait Masteryl_WpUpdateChecker_ManualCheck
{
  
  public function loadManualCheck($meta, $plugin)
  {

    $text = __('Check for updates', 'plugin-update-checker');
    $link = $this->getManuCheckLink();
     
    if (!empty($text)) 
    $meta[] = sprintf('<a href="%s">%s</a>', esc_attr($link), $text);
    
    return $meta;

  }

  protected function getManuCheckLink()
  {
    $args = [
      $this->slug . $this->manual_check_url_append => 1,
      'mmcd_slug' => $this->slug
    ];

    return add_query_arg($args, self_admin_url('plugins.php'));
  }

  private function manualCheck() {
    delete_transient($this->transient_key);
      $url = self_admin_url('plugins.php');
      header("Location: ".$url); exit;
  }
 
}