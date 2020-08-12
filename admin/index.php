<?php
require_once(__DIR__.'/../api/init.php');

/**
 * Checking if the application is installed.
 */
if(intval(GET_ENV['CORE_RUN_SCRIPT'])!==2){
    $vars['header']['title'] = 'Error';
    $msg = "Your service is not installed. Before doing anything please go and install it!";
    $vars['error'] = array(
        'name' => "Zephyrus is not installed",
        'message' => $msg,
        'url' => "/admin/install",
        'button' => 'Install'
    );
    $template = new \Api\Misc\Render('/main/templates');
    $template->render('pages/misc/error', $vars);
    die();
}

/**
 * Checking if the user is logged in
 */
if(!$session->checkLogin()){
    header("Refresh:0; url=/auth?page=login", true, 401);
    die("User is not logged in!");
}

/**
 * Get the logged user
 */
$user = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
/**
 * Check if the user has enough permission
 */

if(!$role->hasPermission($user, "accessAdmin")){
    header("Refresh:0; url=/?page=blog", true, 401);
    die("Insufficient permissions!");
}
/**
 * Work with rendering. Modify this, make it cleaner.
 */
if(!isset($_GET['page']) || empty($_GET['page']))
    $page = 'dashboard';
else
    $page = $_GET['page'];
$name = $page;

if($page === 'dashboard'){
    $vars['dashboard'] = array(
        'files' => 15,
        'role' => $user->data->role,
        'permissions' => \Api\Management\Permissions::find_all(),
        'rolePerms' => $role->getRolePermissions($user->data->role),
    );
}else if($page === 'users'){
    $vars['table'] = array(
        'icon' => 'fas fa-users',
        'name' => 'Users',
        'rows' => array('UUID','Username', 'Email','Confirmed','Role','Actions'),
        'data' => \Api\Management\Users::find_all()
    );
}else if($page === 'tokens'){
    if(!$role->hasPermission($user, "readTokens")){
        header("Refresh:0; url=/admin/", true, 401);
        die("Insufficient permissions!");
    }
    $vars['table'] = array(
        'icon' => 'fas fa-shield-alt',
        'name' => 'Tokens',
        'rows' => array('Selector','Created at', 'Expiring at','Status', 'Fresh', 'Action'),
        'data' => \Api\Management\Tokens::find_all(),
        'tableName' => 'dataTable2',
    );
    $vars['time'] = time();
}else if($page === 'posts'){
    if(!$role->hasPermission($user, "readPosts")){
        header("Refresh:0; url=/admin/", true, 401);
        die("Insufficient permissions!");
    }
    $vars['table'] = array(
        'icon' => 'fas fa-paste',
        'name' => 'Posts',
        'rows' => array('Serial','Title','Author','Created','Status','Last Edit','Actions'),
        'data' => \Api\Management\Posts::find_all(),
        'tableName' => 'dataTable3',
    );
    $vars['time'] = time();
}



$vars['header']['title'] = $name;
$vars['navbar'] = array('username'=> $user->username);
$vars['bc'] = array('root' => 'Administrator', 'last'=> $name);
$template = new \Api\Misc\Render();
$template->render('pages/home/'.$page, $vars);
