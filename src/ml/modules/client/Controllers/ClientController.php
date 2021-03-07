<?php

class Masteryl_ClientController
{
  protected $app;

  protected $secret_key;

  protected $user_id;

  public function __construct($req, $res) 
  {
    // sleep(30);
    
    $this->app = $req->getApp();
    
    $this->secret_key = $this->app->getSecretKey('install', false);

    $this->user_id = $req->get('user_id');
  }

  public function __invoke($req, $res)
  {

    if (!$this->secret_key) {
      return $res->success();
    }

    $data = [
      'app' => [
        'name' => $this->app->getAppName(),
      ]
    ];

    $license = $this->app->meta()->getEncrypt('license', $this->secret_key, (object) []);
   
    if(!empty($license) && !empty($license->expire_ts)) {
      $license->expires_in = (int) $license->expire_ts - time();
      unset($license->expire_ts);
    }

    $data['license'] = $license;
    

    if(isset($this->app->settings)) $data['settings'] = $this->app->settings->get();

    
    foreach(['license', 'settings'] as $key) 
    if(isset($data[$key]) && empty($data[$key])) $data[$key] = null;

    if($this->app->hasAddon('developer')) {
      $brand = Masteryl_Brand::get($this->app);

      $data['brand'] = $brand;
      $data['isBrandClient'] = $brand->isClient($this->user_id);
    }

    // Additianal contnet
    $data['player_branding'] = new Masteryl_PlayerBranding(true);
    $data['pause_banner'] = new Masteryl_PauseBanner(true);
    $data['promo_alert'] = new Masteryl_PromoAlert(true);
    $data['end_poster'] = new Masteryl_EndPoster(true);


    // extensions
    $data['extensions'] = !empty($this->app->extensions) ? $this->app->extensions : (object) [];
    
    return $res->json($data);
  }

  public function updateLicense($req, $res)
  {
    
    $response = $this->app->host()->updateLicense($req->email, $req->password);

    $code = $response->getCode();

    if($code > 300) {
      return $res->error($response->getMessage(), $code);
    }
    
    $body = $response->getBody();

    if($body->data) {
      $license = $body->data;
      $this->app->meta()->setEncrypt('license', $license, $this->secret_key);
    }

    return $res->json($body, $code);
  }

  public function upgrade($req, $res)
  {
    $response = $this->app->host()->upgrade();

    $code = $response->getCode();

    if($code > 300) {
      return $res->error($response->getMessage(), $code);
    }
    
    $body = $response->getBody();

    return $res->data($body, $code);
  }

  public function migrate($req, $res)
  {
    $app = $req->getApp();
    $app->migrate();
    return $res->success('Migration complete');
  }

}