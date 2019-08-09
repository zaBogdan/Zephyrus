<?php
use Mailgun\Mailgun;

class EmailHandler{

    protected static $api_key = "7356e208ef2ffe367ae09f624096f652-73ae490d-b6222af7";
    protected static $domain = "sandbox911c9f10c6d14ae0baf579b68d2cb243.mailgun.org";
    protected static $path = "admin/templates/";

    public static function send($to, $subject, $template_name, $values){
          $mg = Mailgun::create(self::$api_key);
          $value = EmailHandler::loadTemplate($template_name,$values);
          $parameters = array(
            'from'    => "no-replay@zaengine.ro",
            'to'      => $to,
            'subject' => $subject,
            'text'    => $value,
            'html'    => $value
          );
          $response = $mg->messages()->send(self::$domain, $parameters);
    }

    public static function loadTemplate(String $name,Array $args){
      $file = $_SERVER['DOCUMENT_ROOT'].'/'.self::$path.$name.'.php';
      if(file_exists($file)){
          if(is_array($args))
            extract($args);
          include $file;
          return ob_get_clean();
      }
      return "File doesn't exists";
    }
}