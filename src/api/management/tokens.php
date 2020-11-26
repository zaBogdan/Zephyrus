<?php

namespace Api\Management;

class Tokens extends \Api\Database\DbModel{
    protected static $db_table = "tokens";
    protected static $db_fields = array(
         "id", "selector", "validator", "bounder", "initialtime", "status"
    );

    public $id;
    public $selector;
    public $validator;
    public $bounder;
    public $initialtime;
    public $status;

    /**
     * @see This function checks the tokens and automaticaly revokes them if needed
     * 
     * @param uuid this is needed for generating the bounder
     * @param action this is also needed for generating the bounder
     * @param fresh if needed, this can be passed for different enviorments.  
     */
    public function validateToken(String $uuid, String $action,String $validator, $fresh=NULL){
        /**
         * Time checks
         * date("d-m-Y H:i:s");
         */
        if($this->initialtime > time())
            return false;
        if(time() > $this->status->expireTime){
            $this->revokeToken($this->selector);
            return false;
        }
        /**
         * Freshness check
         */
        if($fresh)
            if(time() > $this->status->freshUntil)
                return false;
        /**
         * Check the validator
         */
        if(!password_verify($validator, $this->validator))
            return false;
        /**
         * Check the bounder
         */
        if(\Api\Security\Tokens::bounder($action, $validator, $uuid)!==$this->bounder)
            return false;
        return true;

    }
    public function save_token(String $uuid, String $action, Array $type, $length=16){
        $this->selector = \Api\Security\Tokens::secureTokens($length);
        $validator = \Api\Security\Tokens::secureTokens($length*2);
        $this->validator = \password_hash($validator, PASSWORD_DEFAULT); 
        $this->bounder = \Api\Security\Tokens::bounder($action,$validator,$uuid);
        $this->initialtime = time();
        $this->status = \Api\Security\Tokens::genStatus($type['fresh'],$type['longTerm'],$type['specificTime']);
        if($this->save_to_db())
            return array("token"=> $this, "trueValidator"=> $validator);
        return false;
    }

    public static function revokeToken(String $selector){
        $token = self::find_by_attribute("selector",$selector);
        if($token->status->status === "revoked")
            return true;
        $token->status = \Api\Security\Tokens::revokeStatus();
        if($token->save_to_db())
            return true;
        return false;
    }

}