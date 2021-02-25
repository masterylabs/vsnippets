<?php

class Masteryl_TestTaskController
{
  use Masteryl_StopwatchTrait;

  public function test($req, $res)
  {
    $this->stopWatchStart();

    return $this->getContactsNext();

    $contacts = Masteryl_Contact::where('id', '!=', null)->take(10000)->get();

    $ids = [];

    foreach($contacts as $c) {
      $contact = Masteryl_Contact::find($c->id);
      $contact->products()->attach('102');
      array_push($ids, $contact->id);
    }
    $dur = $this->stopwatchStop();
    ee(count($ids), $dur);
  }

  protected $_count = 0;

  public function getContactsNext($page = 1, $limit = 1000)
  {
    $this->_count++;

    // $memory_limit = ini_get('memory_limit');

    // ee($memory_limit);
    
    $contacts = Masteryl_Contact::where('id', '!=', null)->page($page)->take($limit)->get();

    foreach($contacts as $c) {
      $contact = Masteryl_Contact::find($c->id);
      $contact->products()->attach('103');
      // array_push($ids, $contact->id);
      $this->_count++;
    
    }

    // if($contacts) unset($contacts);

    $this->stopwatchTime();

    // continue
    if($contacts && count($contacts) == $limit) {
      $page++;
      unset($contacts); // required to freeup 
      return $this->getContactsNext($page, $limit);
    }

    if($contacts) {
      $count = count($contacts);
      unset($contacts);
    } else {
      $count = 0;
    }

    $dur = $this->stopwatchStop();

    $times = $this->stopwatchTimes();

    $requests = $this->_count;

    ee([$page, $count], compact('dur', 'requests', 'times'));
  }
}


/**
  

58 seconds, attache with check, 10k
7 seconds, without check

 */