<?php
define("ROOT_DIR",$_SERVER['DOCUMENT_ROOT']);

require_once ROOT_DIR.'/vendor/autoload.php';
require_once ROOT_DIR.'/admin/classes/dbmodel.php';
require_once ROOT_DIR.'/admin/classes/database.php';
require_once ROOT_DIR.'/admin/classes/users.php';
require_once ROOT_DIR.'/admin/classes/session.php';
require_once ROOT_DIR.'/admin/classes/emailhandler.php';
require_once ROOT_DIR.'/admin/classes/tokenauth.php';
require_once ROOT_DIR.'/admin/classes/filehandler.php';


$env = ROOT_DIR.'/vendor/env.php';
if(file_exists($env)){
    require_once $env;
}else die("Please setup the env.php file!");
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
$files = new FileHandler();