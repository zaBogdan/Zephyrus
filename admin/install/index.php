<?php
require_once(__DIR__.'/../../api/init.php');
require_once(__DIR__.'/install.php');

$installation_stage = intval(GET_ENV['CORE_RUN_SCRIPT']);
$text = null;
$fillin = null;
$responses = null;

/** 
 * Handling all 3 cases. 
*/
if($installation_stage == 0){
    $text = "Please fill in the form to create the <b>.env</b> file. Than we can proceed to webapp installation.";
    $fillin = isset($_POST['submit']);
    if($fillin){
        unset($_POST['submit']);
        $responses = $fillin ? create_env_file($_POST) : null;
    }
}else if($installation_stage == 1){
    $text = "You have setup your enviorment. Now please run this script to configure the Database and Folders needed.";
    $fillin = isset($_GET['install']);
    if($fillin)
        $responses = install_application();

}else if($installation_stage == 2){
    $text = "You have already installed the application! Please head back to the administrator dashboard";
}

$vars['install'] = array(
    "text" => $text,
    "fillin" => $fillin,
    "responses" => $responses,
    "must" => $installation_stage
);
$vars['header'] = array('title'=>"Installation");
$template = new \Api\Misc\Render();
$template->render('pages/install', $vars);
