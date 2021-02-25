<?php


class Masteryl_CreateTaskController
{

  public function __invoke($req, $res)
  {
    if(!$req->validate(['name'])) return $res->error('Missing task name');

    $added = Masteryl_Task::make($req);

    if($added) return $res->success();

    return $res->error();


    // $id = 2;
    // $task = [
    //   'broadcast_id' => $id,
    //   'params' => [
    //     'fwi' => 'product,1|all'
    //   ]
    //   ];

    

    // $taskArgs = [
    //   'name' => 'add_contacts_to_broadcast',
    //   'data' => json_encode($task),
    //   'ref' => 'broadcast_'.$id
    // ];

    // // ee($taskArgs);
    
    


    
    // ee('task created', $taskArgs);
  }
}