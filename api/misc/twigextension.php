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
        new TwigFunction('getPostBySerial', array($this, 'getPostBySerial')),
        new TwigFunction('getUserInformation', array($this, 'getUserInformation')),
        new TwigFunction('getAllPosts', array($this, 'getAllPosts')),
        new TwigFunction('getUsernameByID', array($this, 'getUsernameByID')),
        new TwigFunction('loginProcess', array($this, 'loginProcess')),
        new TwigFunction('registerProcess', array($this, 'registerProcess')),
        new TwigFunction('activateUser', array($this, 'activateUser')),
        new TwigFunction('sendResetPassword', array($this, 'sendResetPassword')),
        new TwigFunction('resetPassword', array($this, 'resetPassword')),
        new TwigFunction('generateConfirmation', array($this, 'generateConfirmation')),
        new TwigFunction('jsonDecode', array($this, 'jsonDecode')),
        new TwigFunction('updateUserInfo', array($this, 'updateUserInfo')),
        new TwigFunction('deleteUserInfo', array($this, 'deleteUserInfo')),
        new TwigFunction('checkPermission', array($this, 'checkPermission')),
        new TwigFunction('updateTokens', array($this, 'updateTokens')),
        new TwigFunction('createPost', array(new \Api\Management\Posts(), 'createPost')),
        new TwigFunction('updatePost', array($this, 'updatePost')),
        new TwigFunction('deletePost', array($this, 'deletePost')),
        new TwigFunction('isJson', array($this, 'isJson')),
        new TwigFunction('redirect', array($this, 'redirect')),
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
    public function redirect($url){
      header("Refresh:0; url=".$url."", true, 400);
    }
    public function getUsername(String $uuid){
      return \Api\Management\Users::find_by_attribute("uuid",$uuid)->username;
    }
    public static function getUsernameByID($id){
      return \Api\Management\Users::find_by_attribute("id",$id)->username;
    }
    public static function getPostBySerial(){
      if(!isset($_GET['s']) || empty($_GET['s']))
          $_GET['s'] = "1cdf585abd705727"; //this is the fallback post!
      $post = \Api\Management\Posts::find_by_attribute("serial", $_GET['s']);
      if(!$post)
        return false;
      $user = \Api\Management\Users::find_by_attribute("id",$post->author);
      $response = array("post"=> $post, "user"=> $user);
      return $response;   
    }
    public static function getAllPosts(){
      $post = \Api\Management\Posts::find_all_by_attribute("status", "public");
      $response = array("posts"=>array_reverse($post), "number"=> count($post));
      return $response;   
    }
    public static function getUserInformation(){
      if(!isset($_GET['username']) || empty($_GET['username']))
        return null;
      $user = \Api\Management\Users::find_by_attribute("username", $_GET['username']);
      if(!$user)
        return "This username doesn't exists in our database";
        var_dump($user);
      $posts = \Api\Management\Posts::find_all_by_attribute("author", $user->id);
      $public_posts = array();
      foreach($posts as $post){
        if($post->status==="public")
          $public_posts[] = $post;
      }
      return array("user"=>$user, "posts"=> array_reverse($public_posts));
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
              header("Refresh:0; url=/", true, 200);
          }else return "Username and password doesn't match!";
      }else return "Please fill in your username and password.";
    }
    
    /**
     * This function handles the registration process (UI to API)
     */
    public function registerProcess(){
      if(isset($_POST['submit'])){
        $user = new \Api\Management\Users();
        $msg = $user->create_user($_POST);
        if($msg===true){
          header("Refresh:5; url=/auth?page=login", true, 303);
          return "We've send you a confirmation email. Please confirm it to start using our application! You will shortly be redirected to the login screen!";
        }else return $msg;
      }else return "Complete this form to get a new account";
    } 

    /**
     * This is called when you need to confirm your email.
     */
    public function activateUser(){
      $response = array("email"=>NULL, "error_level"=> NULL, "error"=> null, "success"=>null);
      if(!(isset($_GET['selector']) && isset($_GET['validator']) && isset($_GET['email']))){
        $response['error'] = "The requested variables are not set!";
        if(isset($_GET['email']))
        $response['email'] = $_GET['email'];
        else {
          $response['error'] = "We can't regenerate a new request because your email is missing!";
          $response['error_level'] = 1;
        }
        if(!$response['error_level']) $response['error_level']=2;
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
        $response['error'] = "This account is already confirmed!";
        $response['error_level']=3;
        return $response;
      }
      if($token->validateToken($user->uuid, "confirmEmail", $validator)){
        $user->data->status = "confirmed";
        $user->save_to_db();
        $token->revokeToken($selector);
        header("Refresh:5; url=/", true, 303);
        $response['success'] = true;
        return $response;
      }
      $response['error'] = "This token is revoked or didn't pass the validation.";
      $response['error_level']=2;
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
      $response = array("email"=>NULL, "error"=> NULL, "error_level"=>null, "success"=>null);
      if(!(isset($_GET['selector']) && isset($_GET['validator']) && isset($_GET['email']))){
        $response['error'] = "The requested variables are not set!";
        if(isset($_GET['email']))
        $response['email'] = $_GET['email'];
        else {$response['error'] = "We can't regenerate a new request because your email is missing!";
        $response['error_level'] = 1;}
        if(!$response['error_level']) $response['error_level']=2;
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
        $response['error'] = "Tokens are not valid! Click the button to get a reset password email!";
        $response['error_level'] = 2;
        return $response;
      }
      if(isset($_POST['submit'])){
        if($_POST['newpassword'] !== $_POST['confirm_password']){
          $response['error'] = "Passwords doesn't match!";
          $response['error_level'] = 3;
          return "Passwords doesn't match!";
        }
        $user->password = $user->hashPassword($_POST['newpassword']);
        $token->revokeToken($selector);
        $user->save_to_db();
        header("Refresh:3; url=/auth?page=login", true, 303);
        $response['success'] = true;
        return $response;
      }
      return $response;
    }
    /**
     * In case something went wrong
     */
    public function generateConfirmation(){
      if(!isset($_GET['email']) || empty($_GET['email']))
        return "You must set the email before accessing this link!";
      if(!isset($_POST['submit']))
        return "Please verify if this is your email. If not change it.";
      $email = $_GET['email'];
      $user = \Api\Management\Users::find_by_attribute("email",$email);
      if(!$user)
        return "User doesn't exist in our database!";
      if($user->data->status==="confirmed")
        return "This user is already confirmed!";
      if($user->email !== $email){
        $user->email = $email;
        if(!$user->save_to_db())
          return "We couldn't update the email... Please try again!";
      }
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
    public function updatePost($post){
      if(!isset($_POST['submit']))
          return null;
      if(isset($_POST['title']) && !empty($_POST['title'])) $post->title = $_POST['title'];
      if(isset($_POST['description']) && !empty($_POST['description'])) $post->description = $_POST['description'];
      if(isset($_POST['text']) && !empty($_POST['text'])) $post->text = $_POST['text'];
      if(isset($_POST['status']) && !empty($_POST['status']) && $_POST['status']!==$post->status){
          $status = strtolower($_POST['status']);
          if(!in_array($status, $post->getStatus()))
              return "This is not a valid status!";
          $post->status = $status;
          if($status === 'public')
              $post->date->published = time();
          $post->date->lastEdited = time();
      }

      if(!$post->save_to_db())
          return "Couldn't update the post with the serial ".$post->serial;
      return "Post updated succesfully";
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
    public function deletePost($post){
      if(!isset($_POST['submit']))
        return null;
      $post->delete();
      header("Refresh:3; url=/admin/?page=posts", true, 401);
      return "The post was deleted!";
    }
    public function deleteUserInfo($user){
      if(isset($_POST['submit'])){
        // $user->data->status = "queued-delete-1";
        $user->delete();
      }
    }
    

    public function checkPermission($perm){
      global $role;
      $user = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
      return $role->hasPermission($user, $perm);
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