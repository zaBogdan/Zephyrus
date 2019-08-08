<?php

class Session extends DbModel{

    private $is_signed = false;
    public $user_id;

    public function __construct(){
        session_start();
    }

    public function login($rememberMe){
        $cookie_expiration_time = $current_time + (30 * 24 * 60 * 60); // 1 month
        if($rememberMe){
            setcookie("member_login", $username, $cookie_expiration_time);
        }
    }

    public function logout(){
        unset($_SESSION['userID']);
        unset($_SESSION['username']);
        uset($_SESSION['token']);
        $this->is_signed = false;
    }

    public function create_token($id,$username){
        $token = array(
            "iat" => time(),
            "nbf" => time()+10,
            "exp" => time()+100,
            "data"=> array(
                "userID" => $id,
                "username"=> $username
            ) 
        );
        $secretKey = base64_decode($this->secretKey);
        $jwt = JWT::encode($token, $secretKey, 'HS512');
        $array = array("access"=>$jwt);
        return json_encode($array);
    }

    public function decode_token($token){
        $secretKey = base64_decode($this->secretKey);
        return JWT::decode($token, $secretKey, array('HS256'));
    }
}