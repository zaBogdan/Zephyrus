<?php 
/**
Review the code to find some security issues. 
Don't forget to add ROLES & hide the file path. 
-> https://www.cloudways.com/blog/php-security/#deploy
-> https://www.tonymarston.net/php-mysql/role-based-access-control.html


 */
//to be changed with __DIR__
require_once(__DIR__.'/classes/init.php');

// if(env('CORE_RUN_SCRIPT')==false && $_GET['page']!=='install')
// header("Location: /admin/install");
//to be changed! BUG: When install it crashes.
if(!$session->isLogged())
    header("Location: /admin/auth.php?page=login");
$user = Users::find_by_attribute("uuid",$_SESSION['uuid']);

$page = 'dashboard';
if(isset($_GET['page']))
    $page = strtolower($_GET['page']);

    
$template->twig->addGlobal('current_page', $page);

$vars = array();
$name = $template->escape_name($page);

if($page==='dashboard'){
    $vars['dashboard'] = array(
        'files' => sizeof(\Core\FileHandler::getAllFiles()),
    );
}else if($page==='users'){
    $vars['table'] = array(
        'icon' => 'fas fa-users',
        'name' => 'Users',
        'rows' => array('UUID','Username', 'Email','Active','Actions'),
        'data' => Users::find_all()
    );
}else if($page==='tokens'){
    $vars['table'] = array(
        'icon' => 'fas fa-key',
        'name' => 'Tokens',
        'rows' => array('UUID','Linked to', 'Status', 'Target', 'Actions'),
        'data' => \Core\TokenAuth::find_all(),
        'tableName' => 'dataTable2'
    );
}else if($page==='upload-files'){
    $vars['header']['title']='Upload files';
    $vars['bc']['directory']='Upload files';
    $vars['upload']=array(
        'files'=>sizeof(\Core\FileHandler::getAllFiles()),
        'values'=> $_POST,
    );
}else if($page==='list-files'){
    $vars['ls']['files'] = \Core\FileHandler::getAllFiles();
}else if($page==='add-post'){
    $vars['post'] = array(
        'values' => $_POST,
    );
}else if($page==='install'){
    $vars['install'] = array(
        'must' => env('CORE_RUN_SCRIPT'),
    );
    $template->render('pages/'.$page, $vars);
}

$vars['header'] = array('title'=>$name);
$vars['navbar'] = array('username'=> $user->username);
$vars['bc'] = array('root' => 'Administrator', 'directory'=> $name);


if($page!=='install')
$template->render('pages/home/'.$page, $vars);
