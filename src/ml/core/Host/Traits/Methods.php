<?php

trait Masteryl_Host_Methods
{

  /**
   * Lookup installation information
   */
  public function lookup()
  {
      return $this->get('lookup')->getBody();
  }
  
  /**
   * Lookup for new updates
   *
   * @return void
   */
  public function getUpdate() 
  {
      return $this->get('update')->getBody();
  }


  public function updateLicense($email, $password)
  {
    return $this->post('license', ['email' => $email, 'password' => $password]);
  }


  public function upgrade()
  {
    return $this->get('upgrade');
  }
}