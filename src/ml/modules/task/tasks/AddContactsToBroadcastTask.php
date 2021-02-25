<?php

class Masteryl_AddContactsToBroadcastTask // extends Masteryl_Tasker
{
  protected $progress;

  protected $params;

  protected $broadcast;

  protected $task;

  // Optional 
  
  public function getTask($task)
  {
    $this->task = $task;
  }

  public function handle($data)
  {
    if(empty($data->broadcast_id)) return exit(5); // invalid

    $this->broadcast = Masteryl_Broadcast::find($data->broadcast_id, ['id']);
    
    $this->params = $data->params;

    $page = (int) $this->task->progress;

    if(empty($page)) $page = 1;

    return $this->getNextGroup($page);
  }

  private function onDone()
  {
    if(isset($this->params)) unset($this->params);
    if(isset($this->broadcast)) unset($this->broadcast);

  }

  public function getNextGroup($page, $limit = 1000)
  {

    $ids = Masteryl_Contact::req($this->params)->page($page)->take($limit)->getIds();

    if(empty($ids)) return $this->onDone();

    $this->broadcast->contacts()->attach($ids);

    $more = count($ids) == $limit;

    unset($ids);

    if(!$more) return $this->onDone();

    $page++;
    $this->task->updateProgress($page);

    return $this->getNextGroup($page, $limit);

  }
}