<?php

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension{
    // public function getFilters()
    // {
    //   return array(
    //     new Twig_SimpleFilter('markdown', array($this, 'markdownParse'), array('is_safe' => array('html')))
    //   );
    // }
  
    public function getFunctions()
    {
      return array(
        new TwigFunction('activeClass', array($this, 'activeClass'), array('needs_context' => TRUE)),
        new TwigFunction('getUsername', array($this, 'getUsername')),
        new TwigFunction('loginProcess', array($this, 'loginProcess')),
        new TwigFunction('registerProcess', array($this, 'registerProcess')),
        new TwigFunction('activateUser', array($this, 'activateUser')),
        new TwigFunction('sendResetPassword', array($this, 'sendResetPassword')),
        new TwigFunction('resetPassword', array($this, 'resetPassword')),
        new TwigFunction('revokeToken', array($this, 'revokeToken')),
        new TwigFunction('testFunction', array($this, 'testFunction')),
      );
    }

    public function activeClass(array $context, $page)
    {
      if (isset($context['current_page']) && $context['current_page'] === $page) {
        return 'active';
      }
    }
    public function getUsername(String $uuid){
      return Users::find_by_attribute("uuid",$uuid)->username;
    }
    public function loginProcess(){
      if(isset($_POST['submit'])){
          $user = Users::check_user($_POST['username'],$_POST['password']);
          if(!empty($user)){
            if(isset($_POST['remember-me']))
              $_SESSION['rememberMe']=true;
            global $session;
            $session->login($user);
            header('Location: /new');
          }else return "Username and password doesn't match!";

      }else return "Please login to continue";
    }

    public function registerProcess(){
      if(isset($_POST['submit'])){
        $user = new Users();
        $msg = $user->create_user($_POST);
        if($msg===true){
          $user->send_confirmation();
          $user->save_to_db();
          header("Refresh:5; url=/new", true, 303);
          return "We've send you a confirmation email. Please confirm it to start using our application! You will shortly be redirected to the login screen!";
        }else return $msg;
      }else return "Complete this form to start using our application";
    } 
    public function activateUser(){
      $token = $_GET['id'];
      $user = $this->check_token("confirm_email");
      $user->confirmedStatus = true;
      $user->save_to_db();
      TokenAuth::revokeToken($token);
      header("Refresh:5; url=/new", true, 303);
    }
    public function sendResetPassword(){
      if(isset($_POST['submit'])){
        if(!Users::send_forgot_password($_POST['email']))
          return "Email doesn't exists in the database.";
        return "Please check your email! We've sent you rest link there!";
      }
      return "Enter your email address and we will send you instructions on how to reset your password.";
    }

    public function resetPassword(){
      $token = $_GET['id'];
      $user = $this->check_token("reset_password");

      if(isset($_POST['submit'])){
        if($_POST['newpassword']!==$_POST['confirm_password'])
          return "Passwords doesn't match!";
          $user = Users::find_by_attribute("uuid",$user->uuid);
          $user->password = $user->hashPassword($_POST['newpassword']);
          TokenAuth::revokeToken($token);
          $user->save_to_db();
          header("Refresh:3; url=/new", true, 303);
          return "Password was reseted successfully. You are redirected to the login screen now";
      }
      return "Enter your new password!";
    }

    public function revokeToken(){
      if(isset($_GET['task'])){
        TokenAuth::revokeToken($_GET['id']);
        header("Location: /new/tokens");
      }
    }
    public function testFunction(){
    }

    private function check_token(String $scope){
      if(isset($_GET['id'])){
        $token = $_GET['id'];
        $user = TokenAuth::validateToken($token,$scope);
        // Error handeling soon
        if(empty($user))
          header("Location: /new");
        return $user;
      }else header("Location: /new");     
    }
}