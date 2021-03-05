<?php


class Masteryl_VideoController
{
  // Get Survey API 
  protected $meta_fields = [
    'player_branding', 'pause_banner', 'promo_alert', 'end_poster'
  ];
  

    public function api($req, $res) 
    {
      if(strstr($req->video, '_') == false) $req->video = "vide_{$req->video}";

      $video = Masteryl_Video::where('identifier', $req->video)->first();

      if(!$video || empty($video->content)) return $res->error();

      $data = json_decode($video->content);

      $pb = new Masteryl_PlayerBranding(true);
      if($pb->active) $data = masteryl_object_merge($data, $pb);
      
      $item = new Masteryl_PauseBanner(true);
      if($item->active) $data->pauseBanner = $item;

      $item = new Masteryl_PromoAlert(true);
      if($item->active) $data->promoAlert = $item;

      $item = new Masteryl_EndPoster(true);
      if($item->active) $data->endPoster = $item;

      return $res->data($data);
    }

    public function web($req, $res) {

      $video = Masteryl_Video::where('identifier', "vide_{$req->video}")->first();

      $app = $req->getApp();

      $data = [
        'route' => $app->base_route,
        'video' => $req->video
      ];
  
      $vue =  new Masteryl_Vue('client/live', $data);
  
      $args = [
        'title' => $video->name,
        'head' => $vue->getHead(true),
        'body' => $vue->getBody()
    ];

    foreach($video as $key => $value) {
      $args[$key] = $value;
    }
  
    return $res->view('live', $args);
    }

    
    public function embed($req, $res) {

      $app = $req->getApp();

      $data = [
        'route' => $app->base_route,
        'video' => $req->video
      ];
  
      $vue =  new Masteryl_Vue('client/live', $data);
  
      $args = [
        'title' => 'vSnippet',
        'head' => $vue->getHead(true),
        'body' => $vue->getBody()
    ];
  
    return $res->view('live', $args);

     ee('videoPlayer');
      
    }
  
    // private function loadWindow()
    //   {
    //       $vue = $this->createVue();
  
    //       $args = [
    //           'title' => $this->page_title,
    //           'head' => $vue->getHead(true),
    //           'body' => $vue->getBody()
    //       ];
  
    //       $res = new Masteryl_Response($this->app);
    //       $view = !empty($this->view) ? $this->view : 'window';
    //       $res->view($view, $args);
    //   }
  
    //   private function createVue() {
          
    //       $data = !empty($this->app->custom_admin_page_data) ? $this->app->custom_admin_page_data : [];
  
    //       $data['route'] =$this->app->base_route;        
          
    //       if(!empty($this->auth)) $data['token'] = $this->getAuthToken();
  
    //       return new Masteryl_Vue($this->vue, $data);
    //   }
   
}