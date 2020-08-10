<?php

include(__DIR__.'/api/init.php');
$vars = array();
$template = new \Api\Misc\Render('/main/templates');
$template->render('test', $vars);