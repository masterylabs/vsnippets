<?php


trait Masteryl_Scheduler_Setters
{
  public function setTime($str) 
  {

    if(!empty($str) && is_string($str)) $i = explode(',', $str);
    else $i = ['','',''];
   
    $this->date = !empty($i[0]) ? $i[0] : $this->getNewDate(); // getTime
    $this->time = !empty($i[1]) ? $i[1] : $this->getNewTime(); // getTime
    $this->tz = !empty($i[2]) ? $i[2] : $this->getDefaultTimezone(); // getTime

    // set time
    $t = explode(':', $this->time);
    $this->hrs = (int) $t[0];
    $this->mins = (int) $t[1];

  }
}