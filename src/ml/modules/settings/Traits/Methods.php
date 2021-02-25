<?php

trait Masteryl_Settings_Methods
{

  public function update($values = [])
  {
    $this->updateValues($values);
  }
  public function getWithKeys($keys = null, $def = '', $unsetArrayDefault = '')
  {
    if(!isset($this->values)) $this->loadValues();

    $values = [];

    foreach ($this->fields as $key) {

      if(!empty($keys) && !in_array($key, $keys)) continue;

      if(!isset($this->values[$key])) {
        $values[$key] = is_array($def) && isset($def[$key]) ? $def[$key] : $unsetArrayDefault;
      } else {
        $values[$key] = $this->values[$key];
      }
    }

    return $values;

  }

  // returns values
  public function get($keys = null, $def = '', $unsetArrayDefault = '')
  {

    if(!isset($this->values)) $this->loadValues();

    if(!$keys) return $this->values;

    if(gettype($keys) == 'string') return isset($this->values[$keys]) ? $this->values[$keys] : $def;

    $values = [];

    foreach($keys as $key) {
      $d = is_array($def) && isset($def[$key]) ? $def[$key] : $unsetArrayDefault;
      $values[$key] = isset($this->values[$key]) ? $this->values[$key] : $d;
    }

    return $values;
  }


  private function loadValues()
  {
    $this->values = $this->app->meta()->get($this->db_key, []);
  }

  private function updateValues($values) 
  {
    $this->app->meta()->setValues($this->db_key, $values);
  }
}