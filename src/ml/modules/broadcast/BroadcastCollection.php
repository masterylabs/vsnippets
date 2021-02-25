<?php

class Masteryl_BroadcastCollection extends Masteryl_Collection
{
  protected $no_permissions = true;
  
  protected function getModel()
  {
    // $test = Masteryl_BroadcastContact::where('broadcast_id', $this->id)
    // ->andWhere('qued', null);
    // // ->_leftJoin('contacts', $cols, 'contact_id')
    // // ->andWhere("{$contactTable}.opted_out", 0);
    // ee('test', $test->get());
    return new Masteryl_Broadcast;
  }

  protected function showAppend($data, $item)
  {
    if(empty($data['data'])) return $data;

    // $data['contacts'] = $item->contacts()->getIds();
    // $data['contacts_count'] = $item->contacts()->count();

    $data['contacts_count'] = $item->contactsCount();
    $data['qued_count'] = $item->quedCount();

    return $data;
  }

  public function beforeUpdate($item, $req)
  {
    // enable deset
    if(isset($item->schedule)) {
      if(empty($item->schedule)) $item->schedule_ts = '';
      else $item->schedule_ts = Masteryl_Scheduler::ts($item->schedule);
    }

    return $item;
  }



}