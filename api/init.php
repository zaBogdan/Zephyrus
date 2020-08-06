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
require_once ROOT_DIR.'/api/management/permissions.php';
require_once ROOT_DIR.'/api/management/posts.php';
require_once ROOT_DIR.'/api/management/roles.php';

// Api\Misc
require_once ROOT_DIR.'/api/misc/render.php';
require_once ROOT_DIR.'/api/misc/twigextension.php';
require_once ROOT_DIR.'/api/misc/sensitive.php';
require_once ROOT_DIR.'/api/misc/emails.php';

// Api\Security
require_once ROOT_DIR.'/api/security/tokens.php';
require_once ROOT_DIR.'/api/security/sessions.php';


/**
 * Working with classes
 */
$sensitive = new \Api\Misc\Sensitive();
$db = new \Api\Database\Database();
$session = new \Api\Security\Sessions();
$role = new \Api\Management\Roles();
define("GET_ENV",$sensitive->env);

?>