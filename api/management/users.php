<?php

namespace Api\Management;

/**
 * FINISH THIS FILE±
 * 
 * User status docs:
 * -> 0 everything is alright
 * -> 1 user is not confirmed
 * -> 2 user is restricted (notifications is populated at "restrictions")
 * -> 3 user is banned
 */

class Users extends \Api\Database\DbModel{
    protected static $db_table = "users";
    protected static $db_fields = array('id', 'uuid', 'username', 'email', 'password', 'data');

    public $id;
    public $uuid;
    public $username;
    public $email;
    public $password;
    public $data;

    /**
     * This function validates the username, password and email.
     * @param
     * -> $data which must be an array and it will only modify
     * username, password and email values. 
     * 
     * @return
     * -> 0 if everything is alright
     * -> 1 if the username doesn't meet the criteria.
     * -> 2 if email doesn't meet the criteria.
     * -> 3 if the password doesn't meet the criteria.
     */
    public function dataValidation(Array $data){
        /**
         * Checking the username
         * Criteria: only allowed
         * -> a-z
         * -> A-Z
         * -> 0-9
         */
        $pattern = "/[^0-9a-zA-Z]/";
        if(\preg_match($pattern, $data['username']))
            return 1;
        /**
         * Checking the email
         * Criteria: Same as user
         */
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            return 2;

        /**
         * Checking the password
         * Criteria: at least one 
         * -> a-z
         * -> A-Z
         * -> 0-9
         * -> special char.
         */
        $pattern = "#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#";
        if(!\preg_match($pattern, $data['password']))
            return 3;
        return 0;
    }


    /**
     * This function checks if the user exists already
     * 
     * @param
     *  It can either take the email or username. They are not required both
     * 
     * @return
     *  boolean, true if the user exists, false otherwise
     */
    public function confirm_user_exists(String $email, String $username=NULL){
        if(!empty($email) && self::find_by_attribute("email", $email))
            return true;
        if(!empty($username) && self::find_by_attribute("username", $username))
            return true;
        return false; 
    }



    public function create_user(Array $data){
        /**
         * Checking user authenticity
         */
        $data['email']=strtolower($data['email']);
        if(self::find_by_attribute("email",$data['email']))
            return "Email already exists!";
        if(self::find_by_attribute("username",$data['username']))
            return "Username already exists";

        /**
         * Creating the user
         */
        $this->username = $data['username'];
        $this->email = $data['email'];

        /**
         * Adding the security layers
         */
        $this->password = $this->hashPassword($data['password']);
        $this->uuid = \Api\Security\Tokens::UUID();
        
        /**
         * Adding personal information about the user
         */
        $user_data = array(
            "firstname" => $data['firstname'],
            "lastname" => $data['lastname'],
            "registrationDate" => time(),
            "role" => "User",
            "status" => "notConfirmed",
            "special_perms" => array(),
        );

        if($this->save_to_db()){
            /**
             * Send a confirmation email
             */
            if($this->send_confirmation())
                return true;
        }
        return false;
    }
    public function send_confirmation(){
        $token =  new \Api\Management\Tokens();
        $tokens= $token->save_token($this->uuid, "confirmEmail", array("fresh"=>false, "longTerm"=>false, "specificTime"=> 15*60));
        $email = new \Api\Misc\Email();
        $val = array(
            'username' => $this->username, 
            'p_one' => "Thank you for joining our community and we want
            to wish you a warm Welcome!", 
            'p_two' => "In order to increase the security you need to confirm your 
            email, by clicking the link down below (which is valid for only 15 minutes). If you don't recognize this email please
            contact us at `support@zaengine.ro`",
            'link' => "http://localhost:8000/admin/auth.php?page=confirm-email&selector=".$tokens['token']->selector."&validator=".$tokens['trueValidator']."&email=".$this->email, 
            'button'  => "Confirm Email!"
        );
        $response = $email->sendMessage($this->email, "Confirm your email",$val);
        if(!$response)
            return false;
        return true;
    }
    public function send_resetPassword(){
        $token =  new \Api\Management\Tokens();
        $tokens= $token->save_token($this->uuid, "resetPassword", array("fresh"=>false, "longTerm"=>false, "specificTime"=> 15*60));
        $email = new \Api\Misc\Email();
        $val = array(
            'username' => $this->username, 
            'p_one' => "This is a request for reseting you password on Zephyrus CMS.", 
            'p_two' => "The link down below is available for only 15 minutes.",
            'link' => "http://localhost:8000/admin/auth.php?page=reset-password&selector=".$tokens['token']->selector."&validator=".$tokens['trueValidator']."&email=".$this->email, 
            'button'  => "Reset..."
        );
        $response = $email->sendMessage($this->email, "Reset your password",$val);
        if(!$response)
            return false;
        return true;
    }
    public static function check_user(String $username, String $password){
        $user = self::find_by_attribute("username",$username);
        if(!empty($user)){
            if(password_verify($password,$user->password)){
                return $user;
            }
        }
        return false;
    }

    public function hashPassword($password){
        return password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]);
    }
}