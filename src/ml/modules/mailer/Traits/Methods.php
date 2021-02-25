<?php

trait Masteryl_Mailer_Methods
{
  

  public function from($from)
  {
    $this->_from = $from;

    foreach(['email', 'name', 'reply_email'] as $i)
    if(!empty($from->{$i})) {
      $key = "from_{$i}";
      $this->{$key} = $from->{$i};
    }
    
    $this->mailer->setFrom($this->from_email, $this->from_name, $this->from_reply_email);

    return $this;

  }


  public function email($email)
  {
    $this->_email = $email;

    foreach(['subject', 'body_html', 'body_text', 'teaser'] as $i)
    if(!empty($email->{$i})) $this->{$i} = $email->{$i};

    $this->mailer->setEmail($this->subject, $this->body_html, $this->body_text, $this->teaser);

    return $this;
  }



  public function to($items) 
  {
    if(!is_array($items)) $items = [$items];
    
    $this->_to = $items;

    foreach($items as $item) {

      if(empty($item->email) || !filter_var($item->email, FILTER_VALIDATE_EMAIL))
      continue; // skip invalid emails
     
      $name = $this->getToName($item);
      $vars = $this->getVars($item);

      $this->mailer->addRecipient($item->email, $name, $vars);
    }

    return $this;
  }

  public function send()
  {
    return $this->mailer->send();
  }

  /**
   * Optional
   */

   public function sendAt($value) {

    if(!method_exists($this->mailer, 'sendAt')) return $this;

    if(!is_numeric($value)) $value = Masteryl_Scheduler::ts($value);
    else $value = (int) $value;

    $this->mailer->sendAt($value);

    return $this;
   }

   public function sandboxMode($value = true) {

    if(method_exists($this->mailer, 'sandboxMode')) {
      $value = !empty($value); // true or false
      return $this->mailer->sandboxMode($value);
    }

    return $this;
   }
}