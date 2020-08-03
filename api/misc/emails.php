<?php

namespace Api\Misc;
use Mailgun\Mailgun;

class Email{

    private $mailGun;
    private $domain;

    public function __construct(){
        global $sensitive;
        $this->mailGun = Mailgun::create($sensitive->env['MAILGUN_API_KEY']);
        $this->domain = $sensitive->env['MAILGUN_DOMAIN'];
    }

    public function sendMessage($to, $subject, $values){
        global $sensitive;
        $template = $this->getTemplate($values); 
        $result = $this->mailGun->messages()->send($this->domain, array(
            'from'	=> 'zaEngine <'.$sensitive->env['MAILGUN_EMAIL_SENDER'].'>',
            'to'	=> $to,
            'subject' => $subject,
            'text'	=> $template,
            'html'  => $template
        ));
        if(!empty($result))
            return true;
        return false;
    }

    public static function getTemplate($vars){
        $template = new \Api\Misc\Render();
        $vars['email'] = $vars;
        return $template->load('emails/default', $vars);
    }
}