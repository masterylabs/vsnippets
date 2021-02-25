<?php


trait Masteryl_Scheduler_Getters
{

  // date,time,tz
  public function getTimestamp($str = false) 
  {
        return (int) $this->getTime($str);
  }

  public function getTime($str = false, $format = 'U')
  {
    if($str) $this->setTime($str);

    $tz = new DateTimeZone($this->tz);
    
    $dt = new DateTime($this->date, $tz);
    
    $dt->setTime($this->hrs, $this->mins);

    return $dt->format($format);
    
  }



  
  public function getSecondsToGo($from = false, $adjust = 0)
  {
    if(!$from) $from = date('U');
    $ts = $this->getTimestamp();
    return $ts - $from + $adjust;
  }

  public function getElapsed($from = false, $adjust = 0) {
    if(!$from) $from = date('U');
    $ts = $this->getTimestamp();
    return $from - $ts + $adjust;
  }

  // decimals: numeric, floor or ceil
  public function getMinutesToGo($decimals = 0, $decSep = '.', $thSep = '', $from = false, $adjust = 0)
  {
   return $this->getCustomToGo(60, $decimals, $decSep, $thSep, $from, $adjust);
  }


  public function getHoursToGo($decimals = 0, $decSep = '.', $thSep = '', $from = false, $adjust = 0)
  {
   return $this->getCustomToGo(3600, $decimals, $decSep, $thSep, $from, $adjust);
  }


  public function getDaysToGo($decimals = 0, $decSep = '.', $thSep = '', $from = false, $adjust = 0)
  {
   return $this->getCustomToGo(86400, $decimals, $decSep, $thSep, $from, $adjust);
  }


  public function getWeeksToGo($decimals = 0, $decSep = '.', $thSep = '', $from = false, $adjust = 0)
  {
   return $this->getCustomToGo(604800, $decimals, $decSep, $thSep, $from, $adjust);
  }


  public function getMonthsToGo($decimals = 0, $decSep = '.', $thSep = '', $from = false, $adjust = 0)
  {
   return $this->getCustomToGo(2628000, $decimals, $decSep, $thSep, $from, $adjust);
  }


  public function getYearsToGo($decimals = 0, $decSep = '.', $thSep = '', $from = false, $adjust = 0)
  {
   return $this->getCustomToGo(31536000, $decimals, $decSep, $thSep, $from, $adjust);
  }


  public function getNewDate($format = 'Y-m-d')
  {
    return date($format);
  }

  public function getNewTime()
  {
    return date('H:i');
  }

  public function getDefaultTimezone()
  {
    return date_default_timezone_get();
  }

  /**
   * Privates
   */


  private function getCustomToGo($seconds = 60, $decimals = 0, $decSep = '.', $thSep = '', $from = false, $adjust = 0) {

    $secs = $this->getSecondsToGo($from);
    $value = ($secs / $seconds) + $adjust;

    if(is_string($decimals)) {
      if($decimals == 'floor') return floor($value);
      if($decimals == 'ceil') return ceil($value);
    }
    return number_format($value, $decimals, $decSep, $thSep);
  }
  
}