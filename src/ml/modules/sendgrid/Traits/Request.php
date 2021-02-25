<?php

trait Masteryl_Sendgrid_Request
{

  protected function post($endpoint, $body = false)
  {
    return $this->apiRequest('POST', $endpoint, $body);
  }

  protected function apiRequest($method, $endpoint, $body = null)
  {
    // ee($body);

    return true;

    $this->errors = [];

    if (!empty($body)) {
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

  $response = wp_remote_post($url, $args);

  // test
  $body = json_decode($response['body']);
 
  $this->response = $response;

  if (empty($response) || empty($response['response'])) return false;

  $code = $response['response']['code'];

  return !empty($code) && $code < 300;

  }
}