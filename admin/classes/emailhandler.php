<?php
use Mailgun\Mailgun;

class EmailHandler{
  
    public static function send($to, $subject, $values){
          $mg = Mailgun::create(env('MAILGUN_API_KEY'));
          $value = EmailHandler::loadTemplate($values);
          $parameters = array(
            'from'    => env('MAILGUN_EMAIL_SENDER'),
            'to'      => $to,
            'subject' => $subject,
            'text'    => $value,
            'html'    => $value
          );
          $response = $mg->messages()->send(env('MAILGUN_DOMAIN'), $parameters);
    }

    public static function loadTemplate(Array $args){
      global $template;
      $vars['email'] = $args;
      $page = $template->load('emails/default', $vars);
      return $page;
    }
}