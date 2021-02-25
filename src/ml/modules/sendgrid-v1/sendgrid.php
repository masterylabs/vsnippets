<?php

$app->settings->addFields([
  'sendgrid_api_key'
]);

// ee('sendgrid module');
class Masteryl_Sendgrid
{
  use Masteryl_Sendgrid_Compose, 
  Masteryl_Sendgrid_Send,
  Masteryl_Sendgrid_Request,
  Masteryl_Sendgrid_Getters,
  Masteryl_Sendgrid_BulkSend;

  public $response_code = '';

  public $response_body = '';

  public $response_message = '';

  public $errors = [];

  protected $api = 'https://api.sendgrid.com/v3';

  protected $api_key; 

  protected $from_name = '';

  protected $from_email;

  protected $to_name = '';

  protected $to_email;

  protected $subject = '';

  // protected $teaser;

  protected $body_html = '';

  protected $body_text = '';

  protected $to = []; // bulk

  protected $personalizations;

  protected $send_at = '';

  protected $sandbox_mode = false;

  protected $bypass_list_management = false;

  protected $bypass_spam_management = false;

  protected $bypass_bounce_management = false;

  protected $bypass_unsubscribe_management = false;



  public function __construct($api_key = false)
  {
    global $masteryl_app;
    
    if(!$api_key) $api_key = $masteryl_app->settings->get('sendgrid_api_key');

    $this->api_key = $api_key;
    
  }

  public function sendAt($ts) {
    $this->send_at = $ts;
  }

  public function testMode($active = true)
  {
    $this->sandbox_mode = $active;
  }

  public function getErrors($def = false)
  {
    return isset($this->errors) ? $this->errors : $def;
  }

  public function getCode($def = 200)
  {
    return isset($this->response_code) ? $this->response_code : $def;
  }

  public function getResponse() {
    
    $response = [
      'code' => $this->response_code,
      'message' => $this->response_message,
    ];

    if(!empty($this->errors)) $response['errors'] = $this->errors;

    return $response;
  }

}


// $app->api([], function() use($app) {

//   // can be moved to 
// });