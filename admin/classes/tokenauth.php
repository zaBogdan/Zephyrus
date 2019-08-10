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
    public static function getUUID(){
        return sprintf( 
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
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


    public function linkToken($uuid, $timeStamp,$lenght=NULL){
        $lenght = $lenght==NULL ? 15 : $lenght;
        $token = self::generateToken($lenght);
        $this->uuid = $uuid;
        $this->token = $token;
        $this->expiry_date = $timeStamp;
        $this->save_to_db();
        return $token;
    }
}