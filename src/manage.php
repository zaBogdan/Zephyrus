<?php
include(__DIR__.'/api/init.php');


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
    die("Service is not installed!");
}

/**
 * Checking if the user is logged in
 */
if(!$session->checkLogin()){
    header("Refresh:0; url=/presentation", true, 401);
    die("You must be logged in to access this page!");
}
/**
 * Get the logged user
 */
$user = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);

/**
 * Check if the user has enough permission
 */

if(!$role->hasPermission($user, "readPosts")){
    header("Refresh:0; url=/", true, 401);
    die("Insufficient permissions!");
}




/**
 * This all must be reworked and set like it should be!
 */
$page='all';
if(isset($_GET['page']) && !empty($_GET['page']))
    $page = $_GET['page'];