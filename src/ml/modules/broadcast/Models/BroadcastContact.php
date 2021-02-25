<?php

class Masteryl_BroadcastContact extends Masteryl_Model
{
  protected $database = 'master';

  protected $table = 'broadcast_contact';

  protected $fills = [
    'broadcast_id',
    'contact_id',

    // first entry event ids
    'qued',
    'processed',
    'deferred',
    'delivered',
    'open',
    'click',
    'bounce',
    'dropped',
    'spamreport',
    'unsubscribe',
    'group_unsubscribe',
    'group_resubscribe',
  ];

}