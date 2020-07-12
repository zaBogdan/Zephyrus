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
        for($i=0;$i<=$length;$i+=8)
            $string = $string.bin2hex(openssl_random_pseudo_bytes(8))."-";
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
     * 
     * @return JSON to have it worked out.
     */
    public static function genStatus(Bool $fresh, Bool $longTerm){
        $status = array(
            'usable'=>null, 
            'fresh'=>null, 
            'freshUntil'=>null, 
            'longTerm'=>null,
            'expireTime'=>null
        );
        if($fresh === true){
            $status['freshUntil'] = time() + 30*60; //a token can be fresh only for 30 mins
        }else {
            $fresh=false;
            $status['freshUntil'] = time() - 30*60; //to be 100% sure it can't be fresh
        }
        $status['fresh'] = $fresh;
        if($longTerm === true)
            $status['expireTime'] = time() + 14 * 24 * 60 * 60; //the token is valid for 2 weeks
        else{
            $longTerm = false;
            $status['expireTime'] = time() + 1 * 24 * 60 * 60; //else the token is valid for 24h
        }
        $status['longTerm'] = $longTerm;
        $status['usable'] = true;
        return json_encode($status);
    }

    public static function revokeToken(Array $status){
        $status['usable'] = false;
        $status['fresh'] = false;
        $status['freshUntil'] = time() - 30*60;
        $status['expireTime'] = time() - 14 * 24 * 60 * 60;
        return \json_encode($status);
    }
    /**
     * Database handling for tokens
     */
    /**
     * There are two types of tokens: 
     * - fresh
     * - long-term
     * 
     * Fresh
     * The fresh tokens will expire after the session ends/after a limited period of time. 
     * This only depends on it's usage.
     * 
     * Long-term
     * You can login, do basic stuff with them, but you can't change important stuff (password,
     * administrative stuff or do ireversible stuff)
     * 
     *  Table structure: ID, UUID, Actual Token, Timestamp from generation, Timestamp of expiration, Bound, Status
     * 
     */

}