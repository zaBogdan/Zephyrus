<?php

class TokenAuth extends DbModel{
    protected static $db_table = "token_auth";
    protected static $db_fields = array('id','uuid','token','is_expired','expiry_date');

    public $id;
    public $uuid;
    public $token;
    public $is_expired;
    public $expiry_date;

    public static function generateToken($length){
        return bin2hex(random_bytes($length));
    }

    public static function revokeToken($token){
        global $db;
        $time = time()-3600;
        $data = self::find_by_attribute("token",$token);
        $sql = "UPDATE ".self::$db_table." SET ";
        $sql.= "is_expired=".true.", ";
        $sql.= "expiry_date=".$time." ";
        $sql.= "WHERE token='{$data->token}'";
        $db->query($sql);
    }
    public static function validateToken($token){
        $data = self::find_by_attribute("token",$token);
        //If token is in database
        if(!empty($data)){
            //if is not expired
            if(!$data->is_expired && time()<$data->expiry_date)
                return $data;
            //daca e expirat deja
            if($data->is_expired)
                return false;
            //daca data de expirare a trecut il revocam
            if(time()>=$data->expiry_date){
                self::revokeToken($token);
                return false;
            }
        }
        return false;
    }
}