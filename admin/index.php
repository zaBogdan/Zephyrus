<?php
require_once(__DIR__.'/../api/init.php');

//ToDo: Create the installation script!
if(intval(GET_ENV['CORE_RUN_SCRIPT'])!==1){
    $msg = "Your service is not installed. Please go to ";
    $msg .= '<a href="install" target="_blank">instalation page</a>.';
    die($msg);
}

$page = 'dashboard';

$vars['dashboard'] = array(
    'files' => 15,
);
$template = new \Api\Misc\Render();
$template->render('pages/home/'.$page, $vars);
