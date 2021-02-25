<?php

class Masteryl_RunTaskController
{
  use Masteryl_StopwatchTrait;

  protected $ts;

  protected $res;

  protected $tasks_path;

  protected $max_duration = 60;

  public function __invoke($req, $res)
  {
    $this->ts = $this->stopWatchStart(true);

    $this->res = $res;

    $this->tasks_path = __DIR__ . '/../tasks/';

    return $this->loadTask();

  }

  private function loadTask()
  {
    
    $task = Masteryl_Task::where('is_complete', 0)
    ->andWhere('in_progress', 0)
    ->andWhere('scheduled', '<', $this->ts)
    ->first();

    // all done!
    if(!$task) return $this->onDone();


    $name = masteryl_camelize($task->name . '_task');

    $cname = 'Masteryl_'.$name;

    // include task if not included
    if(!class_exists($cname)) {
      $file = $this->tasks_path . $name . '.php';
      if(file_exists($file)) include_once $file;
      else exit('Missing Task File: '.$name); // does not exist
    }

    /**
     * Starting Task
     */

    // set task to active
    $task->update(['in_progress' => 1]);

    // create task class

    $m = new $cname();
    
    $data = !empty($task->data) ? json_decode($task->data) : '';

    if(method_exists($m, 'getTask')) $m->getTask($task);

    $m->handle($data);

    // if(method_exists($m, 'getProgress')) {
    //   $task->progress = $m->getProgress();
    // }

    // if(empty($m->progress)) {
    //   if($m->progress == 100) {

    //   }
    // }

    if(empty($m->not_complete)) $task->is_complete = 1;

    $task->in_progress = 0;

    $task->save();

    unset($task);

    // check time
    $dur = $this->stopwatchTime();
    
    // still time for another task
    if($dur <= $this->max_duration) return $this->loadTask();

    // all done
    return $this->onDone();

  }

  private function onDone()
  {
    $this->stopWatchDestroy();
    return $this->res->ok();
  }

}
