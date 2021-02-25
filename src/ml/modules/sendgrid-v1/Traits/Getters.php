<?php

trait Masteryl_Sendgrid_Getters
{

  /**
   * Public
   */

  public function getErrors()
  {
      return $this->errors;
  }

  /**
   * Protected
   */

  protected function getPersonalizations() {

    $to = ['email' => $this->to_email];
    if(!empty($this->to_name)) $to['name'] = $this->to_name;

    $values = [[
      'to' => [
          $to,
      ],
    ]];

    return $values;

  }

  protected function getContent()
  {
    $content = [];

    if ($this->body_text) {
        array_push($content, [
            'type' => 'text/plain',
            'value' => $this->body_text,
        ]);

        // ok
        // $content[] = [
        //   'type' => 'text/plain',
        //   'value' => $this->body_text,
        // ];
    }

    if ($this->body_html) {
        array_push($content, [
            'type' => 'text/html',
            'value' => $this->body_html,
        ]);
    }

    // ee('getContent', $content);

    return $content;
    
  }

  protected function getBody()
  {
    return [
      'personalizations' => $this->getPersonalizations(),
      'from' => [
          'email' => $this->from_email,
          'name' => $this->from_name,
      ],
      'subject' => $this->subject,
      'content' => $this->getContent(),
    ];
  }
}