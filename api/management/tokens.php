<?php

namespace Api\Management;

class Tokens extends \Api\Database\DbModel{
    protected static $db_table = "tokens";
    protected static $db_fields = array(
        "id", "token", "bounder", "intialtime", "status"
    );

    public $id;
    public $token;
    public $bounder;
    public $intialtime;
    public $status;

    // public function getToken(){
    //     return $this->token;
    // }

    /**
     * 
     */
    public function validateToken(String $action, Bool $fresh_needed=false){
        $time_of_request = time();
        /**
         * In case of a databreach and a token is modified we will check both
         * timestamps saved at the moment of creation and the life of a token. 
         */
        if($time_of_request < $this->intialtime)
            return false;
        if($fresh_needed){
            
        }
        /**
         * Verify the bounder
         * 
         * THere are two checks: 
         * -> if the user that uses this token is the intended one(token uuid and user uuid)
         * -> bounder can be recrated.
         */
        if(\Api\Security\Token::bounder($action, $this->token)!==$this->bounder)
            return false;
        
        /**
         * If everything is ok we return true
         */
        return true;

    }

    public function save_token(String $uuid, String $action, Array $type, $length=16){
        global $session_user;
        $this->token = \Api\Security\Tokens::secureTokens($length);
        $this->bounder = \Api\Security\Tokens::bounder($action,$this->token,$uuid);
        $this->intialtime = time();
        $this->status = \Api\Security\Tokens::genStatus($type['fresh'],$type['longTerm']);
        try{
            $this->save_to_db();
        }catch(Exception $e){
            return "error";
        }
        return "Token saved";
    }

}