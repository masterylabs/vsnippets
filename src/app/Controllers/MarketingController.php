<?php


class Masteryl_MarketingController
{
  public function updatePauseBanner($req, $res) 
  {
    Masteryl_PauseBanner::update($req);
    return $res->success();
  }


  public function updatePromoAlert($req, $res) 
  {
    Masteryl_PromoAlert::update($req);
    return $res->success();
  }


  public function updateEndPoster($req, $res) 
  {
    Masteryl_EndPoster::update($req);
    return $res->success();
  }

}