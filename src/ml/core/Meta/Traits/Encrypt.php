<?php

trait Masteryl_Meta_Encrypt
{
  use Masteryl_Encrypt;

  public function getDecrypt($metaKey, $secretKey = 'secret', $def = false)
  {
    return $this->getEncrypt($metaKey, $secretKey, $def);
  }

  public function getEncrypt($metaKey, $secretKey = 'secret', $def = false)
  {
    $value = $this->get($metaKey);

    if(!$value) {
      return $def;
    }

    return $this->decrypt($value, $secretKey);

  }

  public function setEncrypt($metaKey, $value = '', $secretKey = 'secret')
  {
    $value = $this->encrypt($value, $secretKey);
  
    return $this->set($metaKey, $value);

  }

}