<?php
include(__DIR__.'/../api/init.php');

$vars['header']['title'] = 'Under construction';
$msg = "There is nothing setup for the 'Legal' section right now! Please go back to the main page";
$vars['error'] = array(
    'name' => "Page under construction",
    'message' => $msg,
    'url' => "/presentation",
    'button' => 'Home'
);
$template = new \Api\Misc\Render('/main/templates');
$template->render('pages/misc/error', $vars);
die("Nothing for now! Please head back to main page!");