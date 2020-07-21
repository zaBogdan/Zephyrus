<?php

namespace Api\Management;

class Tokens extends \Api\Database\DbModel{
    protected static $db_table = "tokens";
    protected static $db_fields = array(
         "id", "token", "bounder", "initialtime", "status"
    );

    public $id;
    public $token;
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
    public function validateToken(String $uuid, String $action, $fresh=NULL){
        
        $this->status = json_decode($this->status);
        // var_dump($this->status);

        /**
         * Time checks
         * date("d-m-Y H:i:s");
         */
        if($this->initialtime > time())
            return false;
        if(time() > $this->status->expireTime){
            $this->revokeToken($this->token);
            return false;
        }
        /**
         * Freshness check
         */
        if($fresh)
            if(time() > $this->status->freshUntil)
                return false;
        /**
         * Check the bounder
         */
        if(\Api\Security\Tokens::bounder($action, $this->token, $uuid)!==$this->bounder)
            return false;
        return true;

    }
    public function save_token(String $uuid, String $action, Array $type, $length=16){
        $this->token = \Api\Security\Tokens::secureTokens($length); 
        $this->bounder = \Api\Security\Tokens::bounder($action,$this->token,$uuid);
        $this->initialtime = time();
        $this->status = \Api\Security\Tokens::genStatus($type['fresh'],$type['longTerm'],$type['specificTime']);
        if($this->save_to_db())
            return $this;
        return false;
    }

    public static function revokeToken(String $token){
        $token = self::find_by_attribute("token",$token);
        $token->status = \Api\Security\Tokens::revokeStatus();
        if($token->save_to_db())
            return true;
        return false;
    }

}