<?php

/**
 * Global variables
 */
define("ROOT_DIR",$_SERVER['DOCUMENT_ROOT']);

/**
 * Including the composer files
 */
require_once ROOT_DIR.'/vendor/autoload.php';

/**
 * Including all API classes
 */
// Api\Database
require_once ROOT_DIR.'/api/database/database.php';
require_once ROOT_DIR.'/api/database/dbmodel.php';

// Api\Management
require_once ROOT_DIR.'/api/management/users.php';
require_once ROOT_DIR.'/api/management/tokens.php';

// Api\Misc
require_once ROOT_DIR.'/api/misc/render.php';
require_once ROOT_DIR.'/api/misc/twigextension.php';
require_once ROOT_DIR.'/api/misc/sensitive.php';

// Api\Security
require_once ROOT_DIR.'/api/security/tokens.php';


/**
 * Working with classes
 */
$env = new \Api\Misc\Sensitive();
define("GET_ENV",$env->env);

?>