<?php

include(__DIR__.'/../api/init.php');

$page='login';
if(isset($_GET['page']))
    $page = $_GET['page'];

$vars = array(
    'header'=> array('title'=> $page),
    'body'=>array('name'=>strtolower($page)),
);
$template = new \Api\Misc\Render('/main/templates');
$template->render('/pages/auth/'.strtolower($page), $vars);