<?php

class Masteryl_Scheduler
{
  use Masteryl_Scheduler_Getters,
  Masteryl_Scheduler_Setters,
  Masteryl_Scheduler_Adders;

  public $date;

  public $time;

  public $tz;

  public $hrs;

  public $mins;
  
  public function __construct($str = '')
  {
    $this->setTime($str);
  }

  // Helper Static 
  // Masteryl_Scheduler::ts
  public static function ts($str)
  {
    $sc = new Masteryl_Scheduler($str);
    return $sc->getTimestamp();
  }
  
}

// $str = "2021-01-27,18:25,Africa/Dakar";
// // $str = ",18:25,Africa/Dakar";
// // $str = ",,Africa/Dakar";
// // $str = ",18:25,";

// $scheduler = new Masteryl_Scheduler($str);


// $ts = $scheduler->getTimestamp();
// $secondsToGo = $scheduler->getSecondsToGo();
// $elapsed = $scheduler->getElapsed();
// $mins = $scheduler->getMinutesToGo('ceil');

// ee('done', compact('ts', 'secondsToGo', 'elapsed', 'mins'));
