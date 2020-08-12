<?php

include(__DIR__.'/api/init.php');

$page='presentation';
if(isset($_GET['page']))
    $page = $_GET['page'];

$vars = array(
    'header'=> array('title'=> "Settings"),
    'body'=>array('name'=>'index'),
);
$template = new \Api\Misc\Render('/main/templates');
$template->render('/pages/default/'.strtolower($page), $vars);