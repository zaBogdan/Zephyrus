<?php

namespace Api\Security;

/**
 * NOT FULLY IMPLEMENTED. 
 */

class Sessions{
    
    public function __construct(){
        session_start();
        ob_start();
    }
    /**
     * Starting the actual login process
     */
    public static function handleSession($user, $longTerm){
        /**
         * Generating the login token
         */
        $token =  new \Api\Management\Tokens();
        $actualToken = $token->save_token($user->uuid, "freshLogin", array("fresh"=>true, "longTerm"=>$longTerm));
        $actualToken->status = json_decode($actualToken->status);
        
        /**
         * NEED TO BE WORKED ON!!!
         * Must encrypt the token
         */
        $data = $token;
        /**
         * Setting up the cookie
         */
        $validUntil = $actualToken->status->expireTime;
        setcookie("loginCookie", json_encode($data), $validUntil);

        /**
         * Setup the Session
         */
        $actualToken->status = json_encode($actualToken->status);
        $_SESSION['token'] = $actualToken;
        $_SESSION['user'] = $user;
    }

    public static function checkLogin(){
        if(isset($_SESSION['token']) && $_SESSION['user']){
            var_dump($_SESSION['token']);
            var_dump($_SESSION['user']);
            echo $_SESSION['token']->validateToken($_SESSION['user']->uuid, "login");
            if($_SESSION['token']->validateToken($_SESSION['user']->uuid, "login"))
                return true;
        }

        return false;
    }
}