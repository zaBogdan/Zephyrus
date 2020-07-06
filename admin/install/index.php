<?php
require_once(__DIR__.'/../../api/init.php');
require_once(__DIR__.'/install.php');
if(intval(GET_ENV['CORE_RUN_SCRIPT'])===1){
    $msg = "Your service is already installed. Go back to ";
    $msg .= '<a href="../" target="_blank">admin page</a>.';
    die($msg);
}

/**
 * To do:
 * - Create the form
 * - First you need to input the variables
 * - Than write the file
 * - Create the database, file system and so on. ( new request. )
 */
$_GET['variables']=array(
    'DATABASE_NAME' => 'zaEngine',
    'DATABASE_USERNAME' => 'docker',
    'DATABASE_PASSWORD' => 'jYhbup^F3d6*%',
    'DATABASE_HOST' => 'database',
    'MAILGUN_API_KEY' => '',
    'MAILGUN_DOMAIN' => '',
    'MAILGUN_EMAIL_SENDER' => '',
    'CORE_SECRET_KEY' => 'DHSJFBHJDSHFEWJB38e3br9',
    'CORE_RUN_SCRIPT' => false,
);
$fillin = isset($_GET['run']);
$responses = $fillin ? install_application($_GET['variables']) : null;
$vars['install'] = array(
    "fillin" => $fillin,
    "responses" => $responses,
    "must" => intval(GET_ENV['CORE_RUN_SCRIPT'])
);

$template = new \Api\Misc\Render();
$template->render('pages/install', $vars);