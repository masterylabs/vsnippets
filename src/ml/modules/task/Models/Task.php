<?php

class Masteryl_Task extends Masteryl_Model
{
  protected $database = 'master';
  
  protected $table = 'tasks';
  
  protected $fills = [
    'name',
    'data',
    'ref', // used ref
    'scheduled',
    'priority', // order by
    'progress',
    'in_progress',
    'is_paused',
    'is_complete',
  ];

  


  protected $bool_cols = [
    'is_complete',
    'is_paused'
  ];

  

  public static function make($args, $ret = false) // $priority
  {
    $task = new Masteryl_Task;

    foreach($args as $key => $value) $task->{$key} = $value;  

    if(!empty($task->data) && (is_object($task->data) || is_array($task->data))) {
      $task->data = json_encode($task->data);
    }

    if(!empty($task->scheduled)) {
      
      if(!is_numeric($task->scheduled) && class_exists('Masteryl_Scheduler')) 
        $task->scheduled =  Masteryl_Scheduler::ts($task->scheduled);
      else  $task->scheduled = (int) $task->scheduled; 

    }
      
    $task->save();

    if($ret) return $task;

    return !empty($task->id);
  }

  public function updateProgress($value, $save = true) {
    $this->progress = $value;
    
    if($save) $this->save();
  }

}


