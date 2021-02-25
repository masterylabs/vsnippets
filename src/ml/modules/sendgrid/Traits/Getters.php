<?php

trait Masteryl_Sendgrid_Getters
{

  public function getResponse($message = '', $code = 200) 
  {
    $res = $this->response;
    // ee($res);
    $code = (int) $res['response']['code'];
    $body = json_decode($res['body']);

    if(!empty($body->errors) && !empty($body->errors[0]->message)) {
      $message = $body->errors[0]->message;
    }
    else if(!empty($res['message'])) $message = $res['message'];

    return compact('message', 'code');

  }
  
  private function getBody()
  {
    $body = [
      'personalizations' => $this->personalizations,
      'from' => $this->from,
      'subject' => $this->subject,
      'content' => $this->content,
    ];

    if(!empty($this->send_at)) $body['send_at'] = $this->send_at;

    // date passed
    $body['send_at'] = 500;

    $settings = $this->getSettings();

    if($settings) $body['mail_settings'] = $settings;
  
    return $body;
  }

  private function getSettings()
  {
    $set = [];

    if($this->sandbox_mode) {
      $set['sandbox_mode'] = [
        'enable' => true
      ];
    }

    if(empty($set)) return false;

    return $set;

  }


  private function getHeaders()
  {
      return [
          'Authorization' => "Bearer " . $this->api_key,
          'Content-Type' => 'application/json',
      ];
  }
}