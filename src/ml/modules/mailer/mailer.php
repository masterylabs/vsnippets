<?php



class Masteryl_Mailer
{
  use Masteryl_Mailer_Methods,
  Masteryl_Mailer_Getters;

  protected $mailer;

  protected $_from;

  protected $_email;

  protected $_to = [];

  // From

  public $from_name = '';

  public $from_email = '';

  public $from_reply_email = '';

  // Email

  public $subject = '';

  public $body_html = '';

  public $body_text = '';

  public $teaser = '';

  public $to_vars = ['first_name', 'last_name', 'email', 'identifier', 'id'];
  

  public function __construct()
  {
    global $masteryl_app;

    $api_key = $masteryl_app->settings->get('sendgrid_api_key');
    
    // configure mailer
    $this->mailer = new Masteryl_Sendgrid($api_key);
  }
}