<?php

trait Masteryl_Request_Headers
{
  public function getHeaders()
  {
    return $this->headers;
  }

  public function isBrowser()
  {
    return $this->headerAccepts('text/html');
  }

  public function headerAccepts($value = 'text/html') 
  {

      if(!empty($this->headers['accept'])) {
          $items = explode(',', $this->headers['accept']);
          return in_array($value, $items);
      }
     
      return false;
  }

}