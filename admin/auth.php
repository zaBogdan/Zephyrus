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
if($session->checkLogin()){
    header("Refresh:0; url=/admin", true, 301);
    die("User is logged in!");
}

/**
 * Work with rendering. Modify this, make it cleaner.
 */

$page = 'login';
if(isset($_GET['page']))
    $page = $_GET['page'];
$name = $page;
if($page === 'login'){
    $vars['login'] = array(
        'values' => $_POST,
    );
}elseif($page === 'register'){
    $vars['register'] = array(
        'values' => $_POST,
    );
}
$vars['header'] = array('title'=>$name);
$template = new \Api\Misc\Render();
$template->render('pages/auth/'.$page, $vars);
