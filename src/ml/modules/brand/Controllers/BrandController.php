<?php

class Masteryl_BrandController
{

  public function index($req, $res)
  {
    $brand = $req->brand;
    
    return $res->data($brand);
  }

  public function update($req, $res)
  {
    $app = $req->getApp();

    $brand = $req->brand;

    // get admin user in
    $req->admin_user_id = $req->get('user_id');

    $brand->update($req);

    $data = $brand->getValues();
    $slug = $brand->getSlug();

    $page_slug = $brand->isActive() ? $slug : $app->getConfig('url_prefix');

    return $res->json(compact('data', 'slug', 'page_slug'));

  }

  public function destroy($req, $res)
  {
    $app = $req->getApp();

    $app->meta()->delete('brand');
  }
}