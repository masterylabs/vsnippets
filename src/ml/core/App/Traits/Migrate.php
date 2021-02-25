<?php

trait Masteryl_App_Migrate
{
  private $_migration;


  public function migrate() 
  {
    // $m = new Masteryl_Migration($this);

    Masteryl_Migration::createOrUpdateDir(MASTERYL_MIGRATIONS_PATH, $this);

    if(!empty($this->modules)) {
      foreach($this->modules as $mod) {
        $dir = $mod['path'].'migrations';
        
        if(file_exists($dir))
        Masteryl_Migration::createOrUpdateDir($dir, $this);
      }
    }

  }
}