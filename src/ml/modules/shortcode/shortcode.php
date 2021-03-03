<?php

// add once, as shortcode module can be repeated multiple times

if(!class_exists('Masteryl_Shortcode')) {
  
  class Masteryl_Shortcode
  {
    protected $app;

    protected $options;

    protected $args = []; // set as default

    protected $content;

    protected $required_args = []; // fails without

    public function _validate($app, $options, $args)
    {
      if(!empty($this->required_args))
        foreach($this->required_args as $i)
          if(!isset($args[$i]) || $args[$i] == '') 
            return false;
     
    
      $this->app = $app;

      $this->options = $options;

      foreach($args as $key => $value)
      if($value != '') $this->args[$key] = $value;
    
      return true;
      
    }
    
    public function _getArgs() {
      return $this->args;
    }
  }
}


$id = is_array($options) && !empty($options['id']) ? $options['id'] : $app->getConfig('shortcode_key');


add_shortcode($id, function($args, $content = null) use($app, $options) {
  
  if(is_array($options) && !empty($options['name'])) {
    $name = $options['name'];
  }
  elseif(is_string($options) && !empty($options)) {
    $name = $options;
  }
  else {
    $name = 'ShortcodeController'; // default 
  }
  
  $file = $app->getNamespace($name);
  if(!file_exists($file)) return $content;

  include_once $file;

  $name = 'Masteryl_' . $name;

  $cl = new $name;

  if($cl->_validate($app, $options, $args, $content)) {
    $args = $cl->_getArgs();
    return $cl->handle($args, $content);
  }
  
  // invalid
  return $content;

});
