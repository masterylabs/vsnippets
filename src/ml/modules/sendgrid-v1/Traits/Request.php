<?php

trait Masteryl_Sendgrid_Request
{

  protected function post($endpoint, $body = false)
  {
    return $this->apiRequest('POST', $endpoint, $body);
  }

  protected function apiRequest($method, $endpoint, $body = false)
  {
    $this->errors = [];

    if ($body) {
      $body = json_encode($body);
  }

  $args = [
      'method' => $method,
      'timeout' => 45,
      'redirection' => 5,
      'body' => $body,
      'headers' => $this->getHeaders(),
  ];

  $url = $this->api . $endpoint;

  // return false;

  $response = wp_remote_post($url, $args);

  if (empty($response)) return false;

  $this->response = $response;

  if(!empty($response['response'])) {
    
    $this->response_code = isset($response['response']['code']) ? $response['response']['code'] : '';
    $this->response_message = isset($response['response']['message']) ? $response['response']['message'] : ''; // default error message
    $this->response_body = json_decode($response['body']);
    
    if(!empty($this->response_body->errors) && is_array($this->response_body->errors)) {
     
      $errors = $this->response_body->errors;
      
      $this->errors = $errors;

      if(!empty($errors[0]) && isset($errors[0]->message)) {
        $this->response_message = $errors[0]->message;
      }
    }

  }

  if (empty($response['response']['code']) || $response['response']['code'] >= 300) {
    return false;
  }


  return true;

  }
}