<?php

class Masteryl_EmailContactController
{
  public function __invoke($req, $res)
  {
    // ee($req);
    if(!$req->validate(['email', 'sender', 'contact']))
    return $res->error('email, sender and contact required');
    
    $email = Masteryl_Email::find($req->email);
    $sender = Masteryl_Sender::find($req->sender);
    $contact = Masteryl_Contact::find($req->contact);

    $mailer = new Masteryl_Mailer;

    $mailer->from($sender)->email($email)->to($contact);

    if(!empty($req->send_at)) $mailer->sendAt($req->send_at);

    if(!empty($req->sandbox_mode)) $mailer->sandboxMode($req->sandbox_mode);

    $sent = $mailer->send();

    if($sent) return $res->success('Test email sent!');

    $response = $mailer->getResponse('Send Failed', 400);

    return $res->error($response['message'], $response['code']);

   
  }
}