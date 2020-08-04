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
        new TwigFunction('generateReset', array($this, 'generateReset')),
        new TwigFunction('generateConfirmation', array($this, 'generateConfirmation')),
        new TwigFunction('jsonDecode', array($this, 'jsonDecode')),
      );
    }

    /**
     * Some getters for the UI part
     */
    public function activeClass(array $context, $page)
    {
      if (isset($context['current_page']) && $context['current_page'] === $page)
        return 'active';
    }
    public function getUsername(String $uuid){
      return \Api\Management\Users::find_by_attribute("uuid",$uuid)->username;
    }

    /**
     * This function handles the login process (UI to API)
     */
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
    
    /**
     * This function handles the registration process (UI to API)
     */
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

    /**
     * This is called when you need to confirm your email.
     */
    public function activateUser(){
      $response = array("email"=>NULL, "msg"=> NULL);
      if(!(isset($_GET['selector']) && isset($_GET['validator']) && isset($_GET['email']))){
        $response['msg'] = "The requested variables are not set!";
        if(isset($_GET['email']))
        $response['email'] = $_GET['email'];
        else $response['msg'] = "We can't regenerate a new request because your email is missing!";
        return $response;
      }
        $selector = $_GET['selector'];
        $validator = $_GET['validator'];
        $email = $_GET['email'];
      $response = array("email"=>$email, "msg"=> NULL);
      $token = \Api\Management\Tokens::find_by_attribute("selector", $selector);
      $user = \Api\Management\Users::find_by_attribute("email", $email);
      $user->data = json_decode($user->data);
      if($user->data->status=== "confirmed"){
        $token->revokeToken($selector);
        $response['msg'] = "This account is already confirmed!";
        return $response;
      }
      if($token->validateToken($user->uuid, "confirmEmail", $validator)){
        $user->data->status = "confirmed";
        $user->data = json_encode($user->data);
        $user->save_to_db();
        $token->revokeToken($selector);
        header("Refresh:5; url=/admin", true, 303);
        $response['msg'] = 'Account is now confirmed!';
        return $response;
      }
      $response['msg'] = "This token is revoked or didn't pass the validation.";
      return $response;
    }

    /**
     * This handles the process of sending an email!
     */
    public function sendResetPassword(){
      if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $user = \Api\Management\Users::find_by_attribute("email", $email);
        if(!$user)
          return "Email doesn't exists in the database.";
        if($user->send_resetPassword());
          return "Please check your email! We've sent you rest link there!";
        return "There was an error with our servers! Please try again!";
      }
      return "Enter your email address and we will send you instructions on how to reset your password.";
    }

    /**
     * This function is the actual reset 
     */
    public function resetPassword(){
      $response = array("email"=>NULL, "msg"=> NULL);
      if(!(isset($_GET['selector']) && isset($_GET['validator']) && isset($_GET['email']))){
        $response['msg'] = "The requested variables are not set!";
        if(isset($_GET['email']))
        $response['email'] = $_GET['email'];
        else $response['msg'] = "We can't regenerate a new request because your email is missing!";
        return $response;
      }
      $selector = $_GET['selector'];
      $validator = $_GET['validator'];
      $email = $_GET['email'];
      $response['email'] = $email;
      $token = \Api\Management\Tokens::find_by_attribute("selector", $selector);
      $user = \Api\Management\Users::find_by_attribute("email",$email);
      if(!$token->validateToken($user->uuid,"resetPassword",$validator)){
        $token->revokeToken($selector);
        $response['msg'] = "Tokens are not valid! Click the button to get a reset password email!";
        return $response;
      }
      if(isset($_POST['submit'])){
        if($_POST['newpassword'] !== $_POST['confirm_password'])
          return "Passwords doesn't match!";
        $user->password = $user->hashPassword($_POST['newpassword']);
        $token->revokeToken($selector);
        $user->save_to_db();
        header("Refresh:3; url=/admin", true, 303);
        $response['msg'] = "Password was reseted successfully. You are redirected to the login screen now";
        return $response;
      }
      $response['msg'] = "Enter your new password!";
      return $response;
    }
    /**
     * In case something went wrong
     */
    public function generateReset(){
      if(!isset($_GET['email'])){
        return "The email is not set!";
      }
      $email = $_GET['email'];
      $user = \Api\Management\Users::find_by_attribute("email",$email);
      if(!$user)
        return "User doesn't exist in our database!";
      if(!$user->send_resetPassword())
        return "There was an internal error! Please try again!";
      return "Success";
    }

    public function generateConfirmation(){
      if(!isset($_GET['email'])){
        return "The email is not set!";
      }
      $email = $_GET['email'];
      $user = \Api\Management\Users::find_by_attribute("email",$email);
      if(!$user)
        return "User doesn't exist in our database!";
      if(!$user->send_confirmation())
        return "There was an internal error! Please try again!";
      return "Success";
    }


    public function jsonDecode(String $val){
        return json_decode($val);
    }

}