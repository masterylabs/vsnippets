<?php

trait Masteryl_Sendgrid_Methods
{

  /**
   *  Primary methods
   * 
   */


    // MAILER CLIENT
    public function setFrom($email, $name = '', $reply = '') 
    {
      $this->from = [
        'email' => $email
      ];

      if(!empty($name)) $this->from['name'] = $name;

    }

    
    public function setEmail($subject = '', $html = '', $text = '', $teaser = '')
    {
      $this->subject = $subject;

      $this->teaser = $teaser;

      $this->content = [];

      if (!empty($text)) {
          array_push($this->content, [
              'type' => 'text/plain',
              'value' => $text,
          ]);
      }

      if (!empty($html)) {
          array_push($this->content, [
              'type' => 'text/html',
              'value' => $html,
          ]);
      }

    }


    /**
     * addRecipient
     */

  public function addRecipient($email, $name = '', $vars = [], $wrapper = null)
  {
    if(!$wrapper) $wrapper = $this->personalizations_wrapper;

    $to = ['email' => $email];
    if(!empty($name)) $to['name'] = $name;

    $entry = [
      'to' => [$to]
    ];

    if(!empty($vars)) {
      $subs = [];
      foreach($vars as $key => $value) {
        $key = "{$wrapper[0]}{$key}{$wrapper[1]}";
        $subs[$key] = (string) $value;
      }
      $entry['substitutions'] = $subs;
    }

    $this->personalizations[] = $entry;
  }


    public function send()
    {

      $body = $this->getBody();

      // ee('SEND', $body);

      return $this->post('/mail/send', $body);

      // ee('response', $response);
      
    }


  /**
   * Additional Fields
   */

  public function sendAt($ts) {
    $this->send_at = $ts;
  }

  public function sandboxMode($active = true)
  {
    $this->sandbox_mode = $active;
  }

}