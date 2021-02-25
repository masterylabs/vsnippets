<?php

trait Masteryl_StopwatchTrait 
{
  
  protected $_stopwatch_start;

  protected $_stopwatch_stop;

  protected $_stopwatch_times = [];

  public function stopWatchStart($ret = false)
  {
    $this->_stopwatch_start = date('U');   
    
    if($ret) return $this->_stopwatch_start;
  }

  public function stopWatchStop()
  {
    $this->_stopwatch_stop = date('U');
    
    return $this->_stopwatch_stop - $this->_stopwatch_start;
  }

  public function stopwatchTime() {
    $value = date('U') - $this->_stopwatch_start;
    array_push($this->_stopwatch_times, $value);
    return $value;
  }

  public function stopwatchTimes() {
    return $this->_stopwatch_times;
  }

  public function stopWatchDestroy()
  {
    unset($this->_stopwatch_start);
    unset($this->_stopwatch_start);
    unset($this->_stopwatch_times);
  }

  
}