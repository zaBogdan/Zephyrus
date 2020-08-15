<?php

namespace Api\Security;

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
        $array = $token->save_token($user->uuid, "login", array("fresh"=>true, "longTerm"=>$longTerm));
        $actualToken = $array['token'];
        $validator = $array['trueValidator'];

        /**
         * Encoding the token
         */
        $data = base64_encode($actualToken->selector.":".$validator);
        /**
         * Setting up the cookie
         */
        $validUntil = json_decode($actualToken->status)->expireTime;
        setcookie("loginCookie", $data, $validUntil);
        setcookie("userUUID", $user->uuid, $validUntil);

        // /**
        //  * Setup the Session
        //  */
        $_SESSION['token'] = $actualToken->selector.":".$validator;
        $_SESSION['user'] = $user->uuid;
    }

    /**
     * hasFreshToken checks if a user has fresh tokens
     * 
     * @return bool 
     */
    public static function hasFreshToken(){
        if(!self::checkLogin())
            return false;
        $goodToken = \explode(":", $_SESSION['token']);
        $token = \Api\Management\Tokens::find_by_attribute("selector",$goodToken[0]);
        if($token->validateToken($_SESSION['user'], "login", $goodToken[1],true))
            return true;
        return false;
    }
    /**
     * generateNewFresh revoke existing tokens and generate new one!
     */
    public static function generateNewFresh(){
        $user = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
        self::destroySession();
        self::handleSession($user, false);
    }

    public static function checkLogin(){
        /**
         * If user just logged in
         */
        if(isset($_SESSION['token']) && isset($_SESSION['user'])){
            $goodToken = \explode(":", $_SESSION['token']);
            $token = \Api\Management\Tokens::find_by_attribute("selector", $goodToken[0]);
            if($token->validateToken($_SESSION['user'], "login", $goodToken[1])){
                return true;
            }
        }
        /**
         * If user has a cookie set.
         */
        else if(isset($_COOKIE['loginCookie']) && isset($_COOKIE['userUUID'])){
                $data = explode(":",base64_decode($_COOKIE['loginCookie']));
                $token = \Api\Management\Tokens::find_by_attribute("selector", $data[0]);
                if($token->validateToken($_COOKIE['userUUID'], "login", $data[1])){
                    /**
                     * Reconstruct the session
                     */
                    $_SESSION['token'] = $data[0].":".$data[1];
                    $_SESSION['user'] = $_COOKIE['userUUID'];
                    return true;
                }
            }
        return false;
    }

    public static function destroySession(){
        /**
         * Remove the session
         */
        if(isset($_SESSION['token']))
            \Api\Management\Tokens::revokeToken(\explode(":", $_SESSION['token'])[0]);
        session_destroy();
        /**
         * Remove the long term tokens 
         */
        if(isset($_COOKIE['loginCookie']))
            \Api\Management\Tokens::revokeToken(explode(":",base64_decode($_COOKIE['loginCookie']))[0]);
        unset($_COOKIE['loginCookie']);
        unset($_COOKIE['userUUID']);
        setcookie('loginCookie', "", time()-1*60*60);
        setcookie('userUUID', "", time()-1*60*60);
    }

}