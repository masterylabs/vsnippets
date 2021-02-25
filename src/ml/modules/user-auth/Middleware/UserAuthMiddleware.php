<?php

class Masteryl_UserAuthMiddleware extends Masteryl_Middleware
{

    public function handle($req, $res)
    {
      $token = $req->getAuthToken();

      if(empty($token)) {
        return $res->noAuth('Authentication requred');
      }

      $auth = new Masteryl_UserAuth($req->getApp());

      if(!$auth->validateToken($token)) return $res->noAuth('Invalid authentication');

      $userId = $auth->getUserId();

      $req->add('user_id', $userId);
      
      return $req;
    }

}