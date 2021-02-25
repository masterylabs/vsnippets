<?php

$app->settings->addFields([
  'sendgrid_api_key'
]);

class Masteryl_Sendgrid
{
  use Masteryl_Sendgrid_Getters,
  Masteryl_Sendgrid_Methods,
  Masteryl_Sendgrid_Request;

  protected $api = 'https://api.sendgrid.com/v3';

  protected $api_key; 

  protected $from;

  // protected $from_reply;

  protected $subject;

  protected $content;

  protected $send_at;

  protected $sandbox_mode = false;

  protected $personalizations = [];

  protected $personalizations_wrapper = ['{', '}'];

  protected $mail_settings;

  protected $bypass_list_management = false;

  protected $bypass_spam_management = false;

  protected $bypass_bounce_management = false;

  protected $bypass_unsubscribe_management = false;


  public function __construct($api_key = false)
  {
    $this->api_key = $api_key; 
  }

}