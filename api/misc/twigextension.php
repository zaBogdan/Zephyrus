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
        new TwigFunction('updateUserInfo', array($this, 'updateUserInfo')),
        new TwigFunction('deleteUserInfo', array($this, 'deleteUserInfo')),
        new TwigFunction('updateTokens', array($this, 'updateTokens')),
        new TwigFunction('isJson', array($this, 'isJson')),
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
      if($user->data->status=== "confirmed"){
        $token->revokeToken($selector);
        $response['msg'] = "This account is already confirmed!";
        return $response;
      }
      if($token->validateToken($user->uuid, "confirmEmail", $validator)){
        $user->data->status = "confirmed";
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

    /**
     * 
     */
    public function updateUserInfo($user, $loggedUser){
      if(isset($_POST['submit'])){
        $emailChanged = false;
        $requestPasswordChange = false;
        if(isset($_POST['email']) && !empty($_POST['email']) && $_POST['email']!==$user->email){
            /**
             * Handle the new email.
             */
            $email = $_POST['email'];
            if($user->find_by_attribute("email", $email))
              return $email." is already in our database.";
            $user->email = $email;
            $user->data->status = "notConfirmed";
            $emailChanged=true;
        }
        if(isset($_POST['username']) && !empty($_POST['username']) && $_POST['username']!==$user->username){ 
          $username = $_POST['username'];  
          if($user->find_by_attribute("username", $username))
            return $username." is already in our database!";          
          $user->username = $username;
        }
        if(isset($_POST['firstname']) && !empty($_POST['firstname'])) $user->data->firstname = $_POST['firstname'];
        if(isset($_POST['lastname']) && !empty($_POST['lastname'])) $user->data->lastname = $_POST['lastname'];
        if(isset($_POST['role']) && !empty($_POST['role'])&& $_POST['role']!==$user->data->role){
          $aRole = $_POST['role'];
          global $role;
          if(!$role->canEditUserRole($loggedUser->data->role, $user->data->role))
            return "You can't modify this user role because it's higher than yours!";
          if(!$role->hasPermission($loggedUser, "assignRole"))
            return "You don't have permission to change the user role!";
          if($role->requiresAdministrative($aRole))
            if(!$role->hasPermission($loggedUser, "assignAdministrativeRole"))
              return "You don't have permission to assign ADMINISTRATIVE roles!";
            /**
             * If is the same user
             */
          if($user->uuid === $loggedUser->uuid)
            return "You can't change your own role!";
          $user->data->role = $aRole;
        }
        if(isset($_POST['confirmEmail']) && !empty($_POST['confirmEmail'])){
          $emailChanged = true;
        }
        if(isset($_POST['requestNewPassword']) && !empty($_POST['requestNewPassword'])){
          $requestPasswordChange = true;
        }
        if($requestPasswordChange === true){
          if(!$user->send_resetPassword())
            return "There was an error while trying to send the request password email!";
        }
        if(!$user->save_to_db())
          return "We can't save this to the database! Try again the request.";

        if($emailChanged === true){
          if(!$user->send_confirmation())
              return "There was an error while trying to send the confirmation email!";
        }
        return "User ".$user->username." has been updated!";
      }
    }
    public function updateTokens(){
      if(!isset($_POST['updateTokens']))
        return null;
      $tokens = \Api\Management\Tokens::find_all();
      foreach($tokens as $token){
        if($token->status->expireTime<time())
          if(!$token->revokeToken($token->selector))
            return "There was an error while trying to revoke the token identified by ".$token->selector;
      }
      return "Token status updated!";
    }

    public function deleteUserInfo($user){
      if(isset($_POST['submit'])){
        // $user->data->status = "queued-delete-1";
        $user->delete();
      }
    }
    public function jsonDecode($val){
        if($this->isJson($val)){
          return json_decode($val);
        }
        return $val;
    }
    public static function isJson($string) {
      if(!is_string($string))
          return false;
      json_decode($string);
      return (json_last_error() == JSON_ERROR_NONE) ? true : false;
  }

}