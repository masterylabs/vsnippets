<?php

trait Masteryl_Sendgrid_BulkSend
{
  public function bulkSend()
  {

    $body = $this->getBulkBody();

    

    return $this->post('/mail/send', $body);

    
  }

  protected function getBulkBody()
  {
    $args = [
      'personalizations' => $this->personalizations,
      'from' => [
          'email' => $this->from_email,
          'name' => $this->from_name,
      ],
      'subject' => $this->subject,
      'content' => $this->getContent(),
       'mail_settings' => $this->getMailSettings()
      //[
      //   'sandbox_mode' => [
      //     'enable' => $this->sandbox_mode
      //   ],
      //   'bypass_list_management' => [
      //     'enable' => $this->bypass_list_management
      //   ],
      //   'bypass_spam_management' => [
      //     'enable' => $this->bypass_spam_management
      //   ],
      //   'bypass_bounce_management' => [
      //     'enable' => $this->bypass_bounce_management
      //   ],
      //   'bypass_unsubscribe_management' => [
      //     'enable' => $this->bypass_unsubscribe_management
      //   ],

      //   'tracking_settings' => [
      //     'enable' => $this->click_tracking
      //   ]
      //   // footer
      // ]
        // 'send_at' => $this->send_at 
    ];

    if(!empty($this->send_at)) {
      $args['send_at'] = $this->send_at;
    }
    // ee($args);

    return $args;
  }

  public function getMailSettings() {
    $args = [
      'sandbox_mode' => [
        'enable' => $this->sandbox_mode
      ],
      // 'bypass_list_management' => [
      //   'enable' => $this->bypass_list_management
      // ],
      // 'bypass_spam_management' => [
      //   'enable' => $this->bypass_spam_management
      // ],
      // 'bypass_bounce_management' => [
      //   'enable' => $this->bypass_bounce_management
      // ],
      // 'bypass_unsubscribe_management' => [
      //   'enable' => $this->bypass_unsubscribe_management
      // ],
      // 'send_at' => $this->send_at,
      // 'tracking_settings' => [
      //   'enable' => $this->click_tracking
      // ]
      // footer

    ];

    

   

    return $args;
  }

  
  public function forceSend() {
    return;
    $this->bypass_list_management = true;
    $this->bypass_spam_management = true;
    $this->bypass_bounce_management = true;
    $this->bypass_unsubscribe_management = true;
    // return $this;
  }

}