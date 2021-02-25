<?php


class Masteryl_Broadcast extends Masteryl_Model
{
  protected $database = 'master';

  protected $table = 'broadcasts';

  protected $bool_cols = ['sent'];


  // protected $default_cols = [
  //     'parent_id' => 0
  // ];

  protected $fills = [
    'identifier',
    'name',
    'description',
    'sender_id',
    'email_id',
    'schedule', // required for form
    'schedule_ts',
    'schedule_active',
    'sent',
  ];

  public function email() {
    return $this->belongsTo(new Masteryl_Email);
  }

  public function sender() {
    return $this->belongsTo(new Masteryl_Sender);
  }

  public function contacts() {
    return $this->belongsToMany(new Masteryl_Contact);
  }

  // unqued contacts
  public function quedCount() 
  {
    return Masteryl_BroadcastContact::where('broadcast_id', $this->id)
    ->andWhere('qued', '!=', null)
    ->count();
  }

  public function contactsCount() {
    return Masteryl_BroadcastContact::where('broadcast_id', $this->id)->count();

  }
  
  public function quedContacts($cols = ['id', 'identifier', 'email', 'first_name', 'last_name']) {

    // required for full
    // $contactTable = $this->getTable('contacts');
    
    return Masteryl_BroadcastContact::where('broadcast_id', $this->id)
    ->andWhere('qued', '!=', null);
    // ->_leftJoin('contacts', $cols, 'contact_id')
    // ->andWhere("{$contactTable}.opted_out", 0);

  }
  
  public function unquedContacts($cols = ['id', 'identifier', 'email', 'first_name', 'last_name']) {

    // required for full
    $contactTable = $this->getTable('contacts');
    
    return Masteryl_BroadcastContact::where('broadcast_id', $this->id)
    ->andWhere('qued', null)
    ->_leftJoin('contacts', $cols, 'contact_id')
    ->andWhere("{$contactTable}.opted_out", '!=', 1);

  }

  public function setQuedContacts($contacts) {

    // if object, convert to array
    if(is_object($contacts[0])) {
      $contacts = array_map(function($contact){
        return $contact->id;
      }, $contacts);
    }

    $ts = current_time('U');
    
    foreach($contacts as $id) {
      $pivot = Masteryl_BroadcastContact::where('broadcast_id', $this->id)->andWhere('contact_id', $id)->first(['id']);
      if($pivot) $pivot->update(['qued' => $ts]);
    }
  }
  
}

