<?php

namespace Core;

class EventHandler{

    public function testFunction(){
        echo __("FIRST_MESSAGE");
    }

    public static function loginUser(){
        if(isset($_POST['submit'])){
            $user = Users::check_user($_POST['username'],$_POST['password']);
            if(!empty($user)){
              if(isset($_POST['remember-me']))
                $_SESSION['rememberMe']=true;
              global $session;
              $session->login($user);
              self::redirect($admin);
            }else return "Username and password doesn't match!";
        }else return "Please login to continue";
    }

    private function redirect($location, $refresh){
        header("Refresh:".$refresh."; url=/".$location."");
    }
}