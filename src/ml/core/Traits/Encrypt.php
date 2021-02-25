<?php

trait Masteryl_Encrypt
{

  private function encrypt($data, $key = 'secret')
  {
    $data = maybe_serialize($data);
    $data = base64_encode($data);

    if (!$this->canEncrypt()) {
      return $data;
    }

    $method = $this->getEncryptionMethod();

    $iv = substr(hash('sha256',$key), 0, 16);

    return base64_encode(openssl_encrypt($data, $method, $key, 0, $iv));
  }

  private function decrypt($data, $key = 'secret')
  {
    $data = base64_decode($data);

    if ($this->canEncrypt()) {
      $method = $this->getEncryptionMethod();

      $iv = substr(hash('sha256',$key), 0, 16);

      $data = openssl_decrypt($data, $method, $key, 0, $iv);
      $data = base64_decode($data);
    }

    return maybe_unserialize($data);
  }


  private function getEncryptionMethod()
  {
    return 'AES-128-CBC';
  }

  private function canEncrypt()
  {
    return function_exists('openssl_encrypt') && function_exists('openssl_decrypt') && function_exists('hash');
  }
}