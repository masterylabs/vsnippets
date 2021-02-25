<?php


class Masteryl_UserAuth
{
  use Masteryl_MakeKey;

  protected $app;

  protected $token_length = 128;

  protected $token_key = 'auth_token';

  protected $expires_key = 'auth_expires';

  protected $expire_mins = 43200; // 24h

  protected $create_new_buffer_mins = 120;

  protected $meta;

  protected $user_id;

  public function __construct($app, $args = [])
  {
    $this->app = $app;

    if(!empty($args)) {
      foreach($args as $key => $val) $this->{$key} = $val;
    }

    if(empty($this->user_id)) $this->user_id = get_current_user_id();

    $this->meta = $app->userMeta($this->user_id);
  }

  public function delete()
  {
    $this->meta->delete($this->token_key);
  }

  // return or create token
  public function getOrCreateToken()
  {
    $token = $this->meta->get($this->token_key, false);

    // no token
    if(!$token) return $this->createNewToken();

    $expires = $this->meta->get($this->expires_key);

    $d = date('U');

    // has expired
    if(empty($expires) || $expires < $d) return $this->createNewToken();

    // is about to expire
    if($expires - $this->create_new_buffer_mins < $d) return $this->createNewToken();

    // valid
    return [
      'token' => $token,
      'expires_in' => $expires - $d
    ];

  }

  public function validateToken($token)
  {
    // invalid
    if(empty($token) || strlen($token) != $this->token_length) return false;

    // support api validation
    if(empty($this->user_id)) {
      $user = $this->meta->getUserMetaByValueOnly('auth_token', $token);
      if(empty($user) || empty($user->user_id)) return false;
      
      // token is match
      $this->setUserId($user->user_id);
    }

    else {
      $token2 = $this->meta->get($this->token_key, false);
      
      // no exists or no match
      if(!$token2 || $token != $token2) return false;
    }

    

    

    // expired
    $expires = $this->meta->get($this->expires_key);

    return !empty($expires) && $expires > date('U');

  }

  public function getUserId()
  {
    return $this->user_id;
  }

  public function setUserId($id)
  {
    $this->user_id = $id;
    $this->meta->setUserId($id); // required to get a valid expire
  }

  /**
   * Projected
   */

  protected function createNewToken()
  {
    $token = $this->makeKey($this->token_length);
    $expires = date('U') + ($this->expire_mins * 60);

    $this->meta->set($this->token_key, $token);
    $this->meta->set($this->expires_key, $expires);

    return [
      'token' => $token,
      'expires_in' => $expires - date('U')
    ];
  }
  
}

add_action( 'wp_logout', function($userId) use($app) {
  $auth = new Masteryl_UserAuth($app, ['user_id' => $userId]);
  $auth->delete();
} );
