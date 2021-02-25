<?php
class Masteryl_BrandMiddleware extends Masteryl_Middleware
{
  public function handle($req, $res)
  {
    $app = $req->getApp();

    $req->brand = Masteryl_Brand::get($app);

    // ee($req);
    return $req;
  }
}