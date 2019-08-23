<?php 
//to be changed with __DIR__
require_once($_SERVER["DOCUMENT_ROOT"].'/admin/classes/init.php');

//to be changed!
if(!$session->isLogged())
    header("Location: /admin/auth/login.php");
$user = Users::find_by_attribute("uuid",$_SESSION['uuid']);

$page = 'dashboard';
if(isset($_GET['page']))
    $page = strtolower($_GET['page']);

$template->twig->addGlobal('current_page', $page);


$vars = array(
    'header' => array('title' => $page),
    'navbar' => array('username'=> $user->username),
    'bc' => array('root' => 'Administrator', 'directory'=> $page)
);

if($page=='dashboard'){
    $vars['dashboard'] = array(
        'files' => sizeof(FileHandler::getAllFiles())
    );
}else if($page=='users'){
    $vars['table'] = array(
        'icon' => 'fas fa-users',
        'name' => 'Users',
        'rows' => array('UUID','Username', 'Email','Active','Actions'),
        'data' => Users::find_all()
    );
}else if($page=='tokens'){
    $vars['table'] = array(
        'icon' => 'fas fa-users',
        'name' => 'Users',
        'rows' => array('UUID','Linked to', 'Status', 'Target', 'Actions'),
        'data' => TokenAuth::find_all(),
        'tableName' => 'dataTable2'
    );
}

$template->render('pages/'.$page, $vars);
