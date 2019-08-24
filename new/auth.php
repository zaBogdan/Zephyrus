<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/admin/classes/init.php');
$page = 'login';
if(isset($_GET['page']))
    $page = strtolower($_GET['page']);

if(!in_array($page,array('confirm-email')))
    if($session->isLogged())
        header("Location: /new");

$vars = array(
    'header' => array('title' => $page),
);

if($page==='login'){
    $vars['login'] = array(
        'values' => $_POST,
    );
}else if($page==='register'){
    $vars['register'] = array(
        'values' => $_POST,
    );
}else if($page=='forgot-password'){
    $vars['header']['title']='Forgot password';
    $vars['fp'] = array(
        'values' => $_POST,
    );
}else if($page==='confirm-email'){
    $vars['header']['title']='Confirm your email';
    $vars['ce'] = array(

    );
}else if($page==='logout'){
    $session->logout();
    header("Location: /new");
}else if($page==='reset-password'){
    $vars['header']['title']='Reset your password';
}

$template->render('pages/'.$page, $vars);
