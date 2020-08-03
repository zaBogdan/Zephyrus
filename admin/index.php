<?php
require_once(__DIR__.'/../api/init.php');

/**
 * Checking if the application is installed.
 */
if(intval(GET_ENV['CORE_RUN_SCRIPT'])!==2){
    $msg = "Your service is not installed. Please go to ";
    $msg .= '<a href="install" target="_blank">instalation page</a>.';
    $vars['error'] = array(
        'title' => "zaEngine is not installed",
        'message' => $msg,
    );
    $template = new \Api\Misc\Render();
    $template->render('pages/home/error', $vars);
    die();
}

/**
 * Checking if the user is logged in
 */
if(!$session->checkLogin()){
    header("Refresh:0; url=/admin/auth.php", true, 401);
    die("User is not logged in!");
}

/**
 * Get the logged user
 */
$user = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
$user->data = json_decode($user->data);
/**
 * Check if the user has enough permission
 */

if(!$role->hasPermission($user, "accessAdmin")){
    header("Refresh:0; url=/", true, 401);
    die("Insufficient permissions!");
}

/**
 * Work with rendering. Modify this, make it cleaner.
 */

$page = 'dashboard';
$name = $page;
$vars['dashboard'] = array(
    'files' => 15,
    'role' => $user->data->role,
);
$vars['header'] = array('title'=>$name);
$vars['navbar'] = array('username'=> "zaBogdan");
$vars['bc'] = array('root' => 'Administrator', 'directory'=> $name);
$template = new \Api\Misc\Render();
$template->render('pages/home/'.$page, $vars);
