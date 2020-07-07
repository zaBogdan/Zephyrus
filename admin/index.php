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
 * Work with rendering. Modify this, make it cleaner.
 */

$page = 'dashboard';
$name = $page;
$vars['dashboard'] = array(
    'files' => 15,
);
$vars['header'] = array('title'=>$name);
$vars['navbar'] = array('username'=> "zaBogdan");
$vars['bc'] = array('root' => 'Administrator', 'directory'=> $name);
$template = new \Api\Misc\Render();
$template->render('pages/home/'.$page, $vars);
