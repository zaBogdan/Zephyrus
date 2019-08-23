<?php require_once(__DIR__.'/classes/init.php');

$render = new RenderEngine();
$values = array(
    'header' => array(
        'title' => 'Twig'
    ),
    'navbar' => array(
        'username' => 'zaBogdan'
    ),
    'dashboard' => array(
        'files' => sizeof(FileHandler::getAllFiles())
    )
);
$render->render('dashboard',$values);




?>