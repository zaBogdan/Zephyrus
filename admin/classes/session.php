<?php

/**
 * Copyright by zaBogdan August 2019
 * 
 * Token authentification, User sessions 
 */
class Session{

    public $user_id;

    public function __construct(){
        session_start();
        ob_start();
    }

    /**
     * Public functions
     * -> login()
     * -> logout()
     * -> isLogged()
     */
    public function login(Users $user){
        //functia aceasta nu poate fii apelata cand isLogged=true ( nu ar avea sens )
        if($user){
            $_SESSION['isLogged'] = true;
            $_SESSION['userID'] = $user->id;
            $_SESSION['username'] = $user->username;
            if(isset($_SESSION['uuid']))
                $this->loginLonger();
        }
    }

    public function logout(){
        if(isset($_COOKIE['loginCookie']))
            TokenAuth::revokeToken($_COOKIE['loginCookie']);
        unset($_SESSION['userID']);
        unset($_SESSION['username']);
        unset($_SESSION['isLogged']);
        unset($_SESSION['token']);
        unset($_COOKIE['loginCookie']);
        setcookie('loginCookie', "", time()-100);
    }

    public function isActivated(int $userID){
        $user = Users::find_by_attribute("id",$userID);
        return $user->confirmedStatus;
    } 

    public function isLogged(){
        //current session credentials check
        if(isset($_SESSION['isLogged'])){
            //check the token to be valid while the current session is active. 
            if(isset($_SESSION['token'])){
                $data = TokenAuth::validateToken($_SESSION['token']);
                if(!empty($data))
                    return true;
                return false;
            }
            //login without remember me. 
            return true;
        }
        else{
            //login from previous session
            if(isset($_COOKIE['loginCookie'])){
                //if token is valid we setup the credentials for the current session
                $data = TokenAuth::validateToken($_COOKIE['loginCookie']);
                if(!empty($data)){
                    $this->setSession($data->uuid,$data->token);
                    return true;
                }
            }
        }
        $this->logout();
        return false;
    }


    /**
     * Private functions
     */
    private function setSession(String $uuid, String $token){
        $user = Users::find_by_attribute("uuid",$uuid);
        $_SESSION['userID'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['isLogged'] = true;
        $_SESSION['token'] = $token;
    }
    
    private function loginLonger(){
        //Get the data needed
        $expiry_date = time() + (30 * 24 * 60 * 60); // 1 month
        
        // Save the token to the database. 
        $tokenAuth = new TokenAuth();
        $tokenAuth->linkToken($_SESSION['uuid'], $expiry_date);

        //remove the uuid
        unset($_SESSION['uuid']);
        $_SESSION['token']=$token;
       
        //Save the cookie token on the client side
        setcookie("loginCookie", $token, $expiry_date);
    }
}
$session = new Session();
