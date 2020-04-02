<?php
//use Gettext\Translator;
//use Gettext\Translations;
define("ROOT_DIR",$_SERVER['DOCUMENT_ROOT']);

// spl_autoload_register(function($class){
//     echo "class: ".$class.'<br>';
//     require_once ROOT_DIR.'/admin/classes/'.strtolower($class).'.php';
// });


require_once ROOT_DIR.'/vendor/autoload.php';
require_once ROOT_DIR.'/admin/classes/core/dbmodel.php';
require_once ROOT_DIR.'/admin/classes/core/database.php';
require_once ROOT_DIR.'/admin/classes/users.php';
require_once ROOT_DIR.'/admin/classes/core/session.php';
require_once ROOT_DIR.'/admin/classes/core/emailhandler.php';
require_once ROOT_DIR.'/admin/classes/core/tokenauth.php';
require_once ROOT_DIR.'/admin/classes/contentmanager.php';
require_once ROOT_DIR.'/admin/classes/core/filehandler.php';
require_once ROOT_DIR.'/admin/classes/core/errorhandler.php';
require_once ROOT_DIR.'/admin/classes/core/renderengine.php';
require_once ROOT_DIR.'/admin/classes/core/eventhandler.php';
require_once ROOT_DIR.'/admin/classes/twigextension.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if(!function_exists('errorhandler')){
function errorhandler($errno, $errstr, $errfile, $errline){
    $error = new ErrorHandler($errno, $errstr, $errfile, $errline);
}
}
// set_error_handler("errorhandler", E_ALL);

$env = __DIR__.'/env.php';
if(file_exists($env))
require_once $env;

if(!function_exists('env')){
    function env($key, $default = null){
        $value = getenv($key);
        if($value==false)
            return $default;
        return $value;
    }
}

//$translations = Translations::fromJsonDictionaryFile(ROOT_DIR.'/admin/lang/en_en.json');
//$translations->toPhpArrayFile(ROOT_DIR.'/admin/lang/en_en.php');


//$t = new Translator();
//$t->loadTranslations(ROOT_DIR.'/admin/lang/en_en.php');
//$t->register();



$db = new \Core\Database();
$post = new ContentManager();
$template = new \Core\RenderEngine();
