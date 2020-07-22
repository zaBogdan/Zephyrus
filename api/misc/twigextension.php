<?php

namespace Api\Misc;
// RESTRUCTURE THIS!!! NOT OK!  
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
        // new TwigFunction('testFunction', array($this, 'testFunction')),
        new TwigFunction('uploadFile', array($this, 'uploadFile')),
        new TwigFunction('addPostEvent', array($this, 'addPostEvent')),
        new TwigFunction('installDefaults', array($this, 'installDefaults')),
        new TwigFunction('testFunction', array($events, 'testFunction')),
      );
    }

    public function activeClass(array $context, $page)
    {
      if (isset($context['current_page']) && $context['current_page'] === $page)
        return 'active';
    }
    public function getUsername(String $uuid){
      return Users::find_by_attribute("uuid",$uuid)->username;
    }


    public function loginProcess(){
      if(isset($_POST['submit'])){
        $user = \Api\Management\Users::check_user($_POST['username'],$_POST['password']);
          if(!empty($user)){
            $longTerm = false;
            if(isset($_POST['remember-me']))
              $longTerm = true;
              global $session;
              $session->handleSession($user, $longTerm);
              header("Refresh:0; url=/admin", true, 200);
          }else return "Username and password doesn't match!";
      }else return "Please login to continue";
    }

    public function registerProcess(){
      if(isset($_POST['submit'])){
        $user = new \Api\Management\Users();
        $msg = $user->create_user($_POST);
        if($msg===true){
          header("Refresh:5; url=/admin", true, 303);
          return "We've send you a confirmation email. Please confirm it to start using our application! You will shortly be redirected to the login screen!";
        }else return $msg;
      }else return "Complete this form to start using our application";
    } 
    public function activateUser(){
      $token = $_GET['id'];
      $user = $this->check_token("confirm_email");
      $user->confirmedStatus = true;
      $user->save_to_db();
      \Core\TokenAuth::revokeToken($token);
      header("Refresh:5; url=/admin", true, 303);
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
          \Core\TokenAuth::revokeToken($token);
          $user->save_to_db();
          header("Refresh:3; url=/admin", true, 303);
          return "Password was reseted successfully. You are redirected to the login screen now";
      }
      return "Enter your new password!";
    }

    public function revokeToken(){
      if(isset($_GET['task'])){
        \Core\TokenAuth::revokeToken($_GET['id']);
        header("Location: /admin/tokens");
      }
    }

    public function testFunction(){

    }

    public function uploadFile(){
      if(isset($_POST['submit'])){
        if(!Users::check_user($_POST['username'],$_POST['password']))
          return "Username and password doesn't match!";
        $msg = \Core\FileHandler::upload_file($_POST['username'],$_FILES['file_upload']);
        if($msg[0] == "/")
          return "File has been successfully uploaded";
        return $msg;
      }
    }

    public function addPostEvent(){
      if(isset($_POST['submit'])){
        $post = new ContentManager();
        $post->createPost($_POST,$_FILES);
        $post->save_to_db();
        header("Refresh:3; url=add-post", true, 303);
        return "Post was created without any errors!";
      }
    }

    private function check_token(String $scope){
      if(isset($_GET['id'])){
        $token = $_GET['id'];
        $user = \Core\TokenAuth::validateToken($token,$scope);
        // Error handeling soon
        if(empty($user))
          header("Location: /admin");
        return $user;
      }else header("Location: /admin");     
    }
}