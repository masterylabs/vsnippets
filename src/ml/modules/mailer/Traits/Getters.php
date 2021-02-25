<?php

trait Masteryl_Mailer_Getters
{

  public function getResponse($message = '', $code = 200) {
    return $this->mailer->getResponse($message, $code);
  }
  


  /**
   * Privates
   */

  private function getToName($item) {
    $name = !empty($item->first_name) ? $item->first_name : '';
    if(!empty($item->last_name)) $name .= ' '.$item->last_name;
    return trim($name);
  }

  private function getVars($item) {
    $vars = [];
    foreach($this->to_vars as $i) 
      $vars[$i] = isset($item->{$i}) ? $item->{$i} : ''; // default
    
      return $vars;
  }
}