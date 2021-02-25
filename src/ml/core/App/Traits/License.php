<?php


trait Masteryl_App_License
{
  protected $_license;

  public function getLicense($no = false)
  {
    if(!isset($_license)) {
      $secret_key = $this->getSecretKey('install', false);
      if(empty($secret_key)) { return $no; }
      $lic = $this->meta()->getEncrypt('license', $secret_key);

      if(!empty($lic) && !empty($lic->expire_ts)) {
        $lic->expires_in = (int) $lic->expire_ts - time();
        unset($lic->expire_ts);
      }

      $this->_license = $lic;

    }

    return $this->_license;
  }

  public function hasValidLicense() 
  {
    $lic = $this->getLicense();

    if(!$lic) return false;

    return is_object($lic) && !empty($lic->value); 
  }

  public function getLicensedAddons($def = []) 
  {
    if(!$this->hasValidLicense() || empty($this->_license->addons)) return $def;

    $addons = $this->_license->addons;

    return $addons;
  }

  public function getLicensedAddonIds($def = [])
  {
    return array_map(function($item){
      return $item->app_id;
    }, $this->getLicensedAddons($def));
  }

  public function hasAddon($ids) {
    
    if(!is_array($ids)) $ids = [$ids];

    $items = $this->getLicensedAddonIds();

    if(empty($items)) return false;

    foreach($items as $i) {
      if(in_array($i, $ids)) return true;
    }

    return false;
  }
}