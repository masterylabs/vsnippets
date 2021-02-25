<?php


class Masteryl_BroadcastSendController
{

  public function __invoke($req, $res) {

    
    
    // sleep(2);

    $bc = Masteryl_Broadcast::find($req->id);

    if(!$bc) return $res->notFound();

    $email = $bc->email();
    
    if(!$email) return $res->notFound('Please select email');

    $sender = $bc->sender();

    if(!$sender) return $res->notFound('Please select sender');

    $contacts = $bc->unquedContacts()->paginate(1000)->get();

    $has_more = $contacts['pagin']['page'] < $contacts['pagin']['pages'];
    // ee(compact('has_more'), $contacts['pagin']);

    if(empty($contacts['pagin']['total'])) return $res->notFound('No unqued contacts');

    /**
     * Setup mailer
     */

    $mailer = new Masteryl_Mailer;

    $mailer->from($sender)->email($email)->to($contacts['data']);

    if(!empty($req->schedule))  $mailer->sendAt($req->schedule);
    elseif(!empty($bc->schedule_active) && !empty($bc->schedule_ts)) $mailer->sendAt($bc->schedule_ts);
   
    if(!empty($req->sandbox_mode)) $mailer->sandboxMode($req->sandbox_mode);

    // send
    $sent = $mailer->send();

    if($sent) {
      $bc->setQuedContacts($contacts['data']);

      $more = $contacts['pagin']['page'] < $contacts['pagin']['pages'];

      $message = $more ? 'Please wait...' : 'Broadcast quing complete';

      $response = [
        'has_more' => $more,
        'qued_count' => count($contacts['data']),
        'message' => $message
      ];
       
      return $res->json($response);
    }


    $response = $mailer->getResponse('Send Failed', 400);

    return $res->error($response['message'], $response['code']);


  }
}