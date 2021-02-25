<?php

trait Masteryl_Sendgrid_Send
{
  public function send()
  {

    $body = $this->getBody();

    // ee('body', $body);
    return $this->post('/mail/send', $body);

    // ee('response', $response);
    
  }


  private function getHeaders()
  {
      return [
          'Authorization' => "Bearer " . $this->api_key,
          'Content-Type' => 'application/json',
      ];
  }
}