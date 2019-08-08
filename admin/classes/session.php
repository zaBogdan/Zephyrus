<?php

/**
 * Copyright by zaBogdan August 2019
 * 
 * Token authentification, User sessions 
 */
class Session extends DbModel{

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
        if(!$this->isLogged)
            if($user){
                $_SESSION['isLogged'] = true;
                $this->user_id = $_SESSION['userID'] =  $user->id;
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
        unset($_COOKIE['loginCookie']);
        setcookie('loginCookie', "", time()-100);
    }

    public function isLogged(){
        if(isset($_SESSION['isLogged'])){
            return true;
        }
        else{
            if(isset($_COOKIE['loginCookie'])){
                $uuid = TokenAuth::validateToken($_COOKIE['loginCookie']);
                if(!empty($uuid)){
                    $this->setSession($uuid);
                    return true;
                }
            }
            return false;
        }
    }


    /**
     * Private functions
     */
    private function setSession(String $uuid){
        $user = Users::find_by_attribute("uuid",$uuid);
        $_SESSION['userID'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['isLogged'] = true;
    }
    private function loginLonger(){
        //Get the data needed
        $expiry_date = time() + (30 * 24 * 60 * 60); // 1 month
        $token = TokenAuth::generateToken(15);
        
        // Save the token to the database. 
        $tokenAuth = new TokenAuth();
        $tokenAuth->uuid = $_SESSION['uuid'];
        $tokenAuth->token = $token;
        $tokenAuth->expiry_date = $expiry_date;
        $tokenAuth->save_to_db();

        //remove the uuid
        unset($_SESSION['uuid']);
       
        //Save the cookie token on the client side
        setcookie("loginCookie", $token, $expiry_date);
    }
}
$session = new Session();
