<?php

namespace Api\Security;

class Tokens{


    /**
     * @see This method generates a secure token that is composed by 8-length strings
     * 
     * @param Int $length which should be the length of the desired token
     * @return String the randomly generated token
     * 
     */
    public static function secureTokens(Int $length){
        $string = "";
        /**
         * Make the lenght divisible by 8.
         */
        if($length%8!=0) $length += $length%8;
        for($i=0;$i<=$length;$i+=8){
            $isStrong = false;
            while(!$isStrong)
                $byte = openssl_random_pseudo_bytes(8, $isStrong);
            $string = $string.bin2hex($byte)."-";

        }
        $string = substr($string, 0, -1);
        return $string;
    }

    /**
     * @see This method generated a string which is like the UUID
     * 
     * @return String The UUID generated
     * 
     */
    public static function UUID(){
        return sprintf( 
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    /**
     * 
     * @see This method generates the bounder for the specific token, signed with the application
     * secret key
     * 
     * @param String action This takes the action for which the token is created
     * @param String token The token that should be signed with the specific action
     * @param String uuid The user to which the token should be linked. 
     * 
     * @return String The hash string that is the same if called with the same params  
     * 
     */
    public static function bounder(String $action, String $token, String $uuid){
        return md5(
            strtolower($action).".".
            substr($token, 0, 4).substr($token, -4, 4).".".
            $uuid.".".
            GET_ENV['CORE_SECRET_KEY']
        );
    }


    /**
     * @see This function generates the status of a specific token, including everything that is needed.
     * 
     * @param String $fresh handles the case this token can be fresh
     * @param String $longTerm generates the expireTime based on the boolean value
     * @param String $specificTime for those tokens who need smaller time than 1day
     * 
     * @return JSON to have it worked out.
     */
    public static function genStatus(Bool $fresh=NULL, Bool $longTerm=NULL, $specificTime=NULL){
        $fresh = isset($fresh) ? $fresh : false;
        $longTerm = isset($longTerm) ? $longTerm : false;
        $status = array(
            'freshUntil'=>null, 
            'expireTime'=>null
        );
        if($fresh === true){
            $status['freshUntil'] = time() + 30*60; //a token can be fresh only for 30 mins
        }else {
            $status['freshUntil'] = time() - 30*60; //to be 100% sure it can't be fresh
        }
        if($longTerm === true)
            $status['expireTime'] = time() + 14 * 24 * 60 * 60; //the token is valid for 2 weeks
        else{
            if(!$specificTime)
                $status['expireTime'] = time() + 1 * 24 * 60 * 60; //else the token is valid for 24h
            else $status['expireTime'] = time() + $specificTime;
        }
        $status['status'] = "valid";
        return json_encode($status);
    }

    public static function revokeStatus(){
        $status['status'] = "revoked";
        $status['freshUntil'] = time() - 30*60;
        $status['expireTime'] = time() - 14 * 24 * 60 * 60;
        return \json_encode($status);
    }

}