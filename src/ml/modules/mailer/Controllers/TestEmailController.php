<?php

class Masteryl_TestEmailController
{
  public function send($req, $res)
  {
    
    $email = Masteryl_Email::find($req->email);
    $sender = Masteryl_Sender::find($req->sender);
    $contact = Masteryl_Contact::find($req->contact);

    $contact->fname = $contact->first_name;
    
  
    $mailer = new Masteryl_Mailer;

    $mailer->setEmail($email);
    $mailer->setSender($sender);
    $mailer->setContact($contact);

    $mailer->personalize();

    $sent = $mailer->send();

    if($sent) {
      return $res->success('Test email sent!');
    }

    $code = $mailer->getCode(400);
    $message = $mailer->getErrorMessage('Send failed');
  
    return $res->error($message, $code);
  }
}