<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/classes/dbmodel.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/classes/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/classes/users.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/classes/session.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/classes/emailhandler.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/classes/tokenauth.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/classes/filehandler.php';


$env = $_SERVER['DOCUMENT_ROOT'].'/vendor/env.php';
if(file_exists($env)){
    require_once $env;
}
if(!function_exists('env')){
    function env($key, $default = null){
        $value = getenv($key);
        if($value==false)
            return $default;
        return $value;
    }
}


$db = new Database();
$email = new EmailHandler();