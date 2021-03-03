<?php

class Masteryl_MetaModel
{
  protected $meta_key;

  protected $_meta;

  protected $_is_loaded = false;

  protected $is_json; // checks fields

  private function setIsJson()
  {
    
    foreach($this->fields as $val)
    if(is_array($val)) return $this->is_json = true;
   
  }
  
  public function __construct($load = false)
  {
    if(!isset($this->is_json)) $this->setIsJson();

    global $masteryl_app;
    $this->_meta = $masteryl_app->meta();

    if($load) $this->loadSelf();
  }

  public static function get()
  {
    $item = (new static );
    $item->loadSelf();
    return $item;
  }

  // SaveMode prevents to override changed self
  protected function loadSelf()
  {
    $data = $this->_meta->get($this->meta_key, false);

    foreach($this->fields as $key => $value) {

      $exists = isset($this->{$key});
      
      if(!$exists && $data && isset($data[$key])) {
        $type = gettype($value);
        $value = $this->parseValueType($data[$key], $type);
      }

      // set property
      $this->{$key} = $value;
    }

    $this->_is_loaded = true;
  }

  protected function isLoaded() 
  {
    return $this->_is_loaded;
  }

  protected function parseValueType($value, $type)
  {
    if($type == 'boolean') return !empty($value);
    
    return $value;
  }

  public function save()
  {
    
    $values = [];

    foreach($this->fields as $key => $val) {
      if(isset($this->{$key})) $val = $this->{$key};
      $values[$key] = $val;
    }

    $this->_meta->set($this->meta_key, $values);

  }

  public static function update($fields = []) 
  {
    $item = (new static);
    return $item->_update($fields);
    
  }

  public  function _update($fields = []) 
  {
    
    if(!$this->isLoaded()) $this->loadSelf();


    if(is_string($fields)) {
      $fields = json_decode($fields, true);
      $fields = array_merge($this->fields, $fields);
    }

    
    
    foreach($fields as $key => $val) {
      $this->{$key} = $val;
    }
    
    $this->save();
    
  }
}