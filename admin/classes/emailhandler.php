<?php
use Mailgun\Mailgun;

class EmailHandler{
  
    public static function send($to, $subject, $template_name, $values){
          $mg = Mailgun::create(env('MAILGUN_API_KEY'));
          $value = EmailHandler::loadTemplate($template_name,$values);
          $parameters = array(
            'from'    => env('MAILGUN_EMAIL_SENDER'),
            'to'      => $to,
            'subject' => $subject,
            'text'    => $value,
            'html'    => $value
          );
          $response = $mg->messages()->send(env('MAILGUN_DOMAIN'), $parameters);
    }

    public static function loadTemplate(String $name,Array $args){
      $file = $_SERVER['DOCUMENT_ROOT'].'/'.env('EMAIL_TEMPLATES_PATH').$name.'.php';
      if(file_exists($file)){
          if(is_array($args))
            extract($args);
          include $file;
          return ob_get_clean();
      }
      return "File doesn't exists";
    }
}