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
        new TwigFunction('getRecomandedPosts', array($this, 'getRecomandedPosts')),
        new TwigFunction('getUserInformation', array($this, 'getUserInformation')),
        new TwigFunction('getAllPosts', array($this, 'getAllPosts')),
        new TwigFunction('getUsernameByID', array($this, 'getUsernameByID')),
        new TwigFunction('loginProcess', array($this, 'loginProcess')),
        new TwigFunction('registerProcess', array($this, 'registerProcess')),
        new TwigFunction('activateUser', array($this, 'activateUser')),
        new TwigFunction('generateFreshTokens', array($this, 'generateFreshTokens')),
        new TwigFunction('sendResetPassword', array($this, 'sendResetPassword')),
        new TwigFunction('resetPassword', array($this, 'resetPassword')),
        new TwigFunction('generateConfirmation', array($this, 'generateConfirmation')),
        new TwigFunction('jsonDecode', array($this, 'jsonDecode')),
        new TwigFunction('updateUserInfo', array($this, 'updateUserInfo')),
        new TwigFunction('deleteUserInfo', array($this, 'deleteUserInfo')),
        new TwigFunction('checkPermission', array($this, 'checkPermission')),
        new TwigFunction('updatePasswords', array($this, 'updatePasswords')),
        new TwigFunction('updateEmail', array($this, 'updateEmail')),
        new TwigFunction('updateUserProfile', array($this, 'updateUserProfile')),
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
      $response = array("post"=> $post, "user"=> $user, "recomanded"=> self::getRecomandedPosts());
      return $response;   
    }
    public static function getRecomandedPosts(){
      $posts = \Api\Management\Posts::send_query("SELECT p.id AS 'posts_id', p.*, c.id AS 'categories_id', c.*, u.id AS 'users_id', u.* FROM `posts` p INNER JOIN `posts_categories` b ON b.postID = p.id INNER JOIN `categories` c ON c.id = b.categoryID INNER JOIN `users` u ON u.id=p.author WHERE p.status='public' ORDER BY p.id DESC LIMIT 6");
      return array_reverse($posts);  
    }
    public static function getAllPosts(){
      $sql = "SELECT p.id AS 'posts_id', p.*, c.id AS 'categories_id', c.* FROM `posts` p INNER JOIN `posts_categories` b ON b.postID = p.id INNER JOIN `categories` c ON c.id = b.categoryID ";
      $sql.= "WHERE p.status='public' ";
      if(isset($_GET['c']) && !empty($_GET['c'])){
        if(\Api\Management\Categories::find_by_attribute("name", $_GET['c']))
          $sql .= " AND c.name='".$_GET['c']."' ";
      }
      $sql.= " LIMIT 9";
      var_dump($sql);
      $posts = \Api\Management\Posts::send_query($sql);
      return array_reverse($posts);   
    }
    public static function getUserInformation(){
      if(!isset($_GET['username']) || empty($_GET['username']))
        return null;
      $user = \Api\Management\Users::find_by_attribute("username", $_GET['username']);
      if(!$user)
        return "This username doesn't exists in our database";
      $posts = \Api\Management\Posts::send_query("SELECT p.id AS 'posts_id', p.*, c.id AS 'categories_id', c.* FROM `posts` p INNER JOIN `posts_categories` b ON b.postID = p.id INNER JOIN `categories` c ON c.id = b.categoryID WHERE p.author='{$user->id}' AND p.status='public'");
      $categories = array();
      foreach($posts as $post){
        if(!in_array($post[1], $categories))
          $categories[] = $post[1];
      }
      return array("user"=>$user, "posts"=> array_reverse($posts), "categories"=>$categories);
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
    public function generateFreshTokens($user){
      if(!isset($_POST['submit']))
        return "In order to make changes you need to confirm your password!";
      global $session;
      if(!$user->check_user($user->username, $_POST['password']))
        return "Password is invalid! Please try again!";
      $session->generateNewFresh();
      header("Refresh:0;", true, 303);
      return "You've renewed your session! Wait to get redirected!";
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
        $user->data->image = "https://via.placeholder.com/150/008000/FFFFFF/64x64.png?text=".strtoupper($user->data->firstname[0].$user->data->lastname[0]);
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
    public function updateUserProfile(){
      if(!isset($_POST['submit']))
        return null;
      $response = array("error"=> null, "success"=>null);
      $user = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
      if(isset($_POST['username']) && !empty($_POST['username']) && $_POST['username']!==$user->username){ 
        $username = $_POST['username'];  
        if($user->find_by_attribute("username", $username))
          $response['error'] = $username." is already in our database!"; 
        if($response['error']) return $response;         
        $user->username = $username;
      }
      if(isset($_POST['firstname']) && !empty($_POST['firstname'])) $user->data->firstname = $_POST['firstname'];
      if(isset($_POST['lastname']) && !empty($_POST['lastname'])) $user->data->lastname = $_POST['lastname'];
      if(isset($_POST['biography']) && !empty($_POST['biography'])) $user->data->biography = $_POST['biography'];
      
      $user->data->image = "https://via.placeholder.com/150/008000/FFFFFF/64x64.png?text=".strtoupper($user->data->firstname[0].$user->data->lastname[0]);
      /**
       * Check for urls
       */
      $url_regex = '/^((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/';
      if(isset($_POST['github']) && !empty($_POST['github'])){
        // if(!preg_match_all($url_regex, $_POST['github'], $test,PREG_PATTERN_ORDER))
        //   $response['error'] = "You must insert an URL for the GITHUB profile!";
        // if($response['error']) return $response;   
        $user->data->github = $_POST['github'];
      }
      if(isset($_POST['twitter']) && !empty($_POST['twitter'])){
        // if(!preg_match($url_regex, $_POST['twitter']))
        //   $response['error'] = "You must insert an URL for the TWITTER profile!";
        // if($response['error']) return $response;         
        $user->data->twitter = $_POST['twitter'];
      }
      if(isset($_POST['website']) && !empty($_POST['website'])){
        // if(!preg_match($url_regex, $_POST['website']))
        //   $response['error'] = "You must insert an URL for your WEBSITE!";
        // if($response['error']) return $response;         
        $user->data->website = $_POST['website'];
      }
      /**
       * Finally update the database.
       */
      if(!$user->save_to_db())
        $response['error'] = "There was an error while trying to update your profile!";
      if(!$response['error']) $response['success'] = true;
      return $response;
    }

    public function updatePasswords(){
      if(!isset($_POST['submit']))
        return null;
      $response = array("error"=> null, "success"=>null);
      $user = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
      /**
       * Check the old password
       */
      if(!$user->check_user($user->username, $_POST['old_password']))
        $response['error'] = "Your old password is invalid! Please try again!";
      if($response['error']) return $response; 
      
      /**
       * Check if passwords match
       */
      if($_POST['new_password'] !== $_POST['confirm_password'])
        $response['error'] = "New password doesn't match! Please try again!";
      if($response['error']) return $response; 

      /**
       * Check if old_password!=new_password
       */
      if($_POST['new_password'] === $_POST['old_password'])
        $response['error'] = "There was an error while trying to update your password!";
      if($response['error']) return $response; 

      /**
       * Updating the password
       */
      $user->password = $user->hashPassword($_POST['new_password']);
      if(!$user->save_to_db())
        $response['error'] = "There was an error while trying to update your password!";
      if(!$response['error']) $response['success'] = true; 
      return $response;
    }

    public function updateEmail(){
      if(!isset($_POST['submit']))
        return null;
      $response = array("error"=> null, "success"=>null);
      $email = $_POST['email'];

      if($email !== $_POST['confirm_email'])
        $response['error'] = "New email doesn't match! Please try again!";
      if($response['error']) return $response; 
      
      if(\Api\Management\Users::find_by_attribute("email", $email))
        $response['error'] = "This email is already in use!";
      if($response['error']) return $response; 
      $user = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
      $user->email = $email;
      $user->data->status = "notConfirmed";
      if(!$user->save_to_db())
        $response['error'] = "There was an error while trying to update your email!";
      if($response['error']) return $response;
      if(!$user->send_confirmation())
        $response['error'] = "There was an error while trying to send the confirmation email!";
      if(!$response['error']) $response['success']=true; 
      return $response;
    }
    public function checkPermission($perm){
      global $role;
      $user = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
      if(!$user)
        return false;
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