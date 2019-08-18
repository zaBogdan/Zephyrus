<?php

class TokenAuth extends DbModel{
    protected static $db_table = "token_auth";
    protected static $db_fields = array('id','uuid','token','is_expired','expiry_date','used_for');

    public $id;
    public $uuid;
    public $token;
    public $is_expired;
    public $expiry_date;
    public $used_for;

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
    public static function validateToken($token,$usage){
        $data = self::find_by_attribute("token",$token);
        //If token is in database
        if(!empty($data)){
            //if is not used in the write place.
            if(strcmp($usage,$data->used_for))
                return false;
            //if is already expired
            if($data->is_expired)
                return false;

            //if is expired by time, we revoke the toke
            if(time()>=$data->expiry_date){
                self::revokeToken($token);
                return false;
            }
            //if everything is alright we send the data.
            if(!$data->is_expired && time()<$data->expiry_date)
                return $data;
        }
        return false;
    }

    public function linkToken($uuid, $timeStamp,$used_for,$lenght=15){
        $token = self::generateToken($lenght);
        $this->uuid = $uuid;
        $this->token = $token;
        $this->expiry_date = $timeStamp;
        $this->used_for = $used_for;
        if($this->save_to_db())
            return $token;
        return false;
    }
}