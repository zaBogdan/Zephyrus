<?php

namespace Api\Misc;

class Sensitive{

    public $env=array();

    public function __construct(){
        $this->env = self::read_env();
    }

    public static function read_env(){
        $file_location = ROOT_DIR."/.env";
        if(file_exists($file_location)){
            $file = file_get_contents($file_location);
            $env = self::parse_env($file);
        }else{
            $env = array("CORE_RUN_SCRIPT"=>0);
        }
        return $env;
    }

    public static function parse_env(String $variables){
        $env_vars = array();
        $array = explode("\n",$variables);
        foreach($array as $string){
            $terms = explode("=", $string);
            $env_vars[$terms[0]] = $terms[1];
        }
        return $env_vars;
    }
    public static function create_env(Array $array){
        $vals = array();
        foreach($array as $key => $value){
            array_push($vals, "{$key}={$value}");
        }
        $string = implode("\n", $vals);
        return $string;
    }

}