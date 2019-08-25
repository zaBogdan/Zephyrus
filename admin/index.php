<?php 
//to be changed with __DIR__
require_once($_SERVER["DOCUMENT_ROOT"].'/admin/classes/init.php');

if(env('CORE_RUN_SCRIPT')==false && $_GET['page']!=='install')
header("Location: /admin/install");

//to be changed! BUG: When install it crashes.
if(!$session->isLogged())
    header("Location: /admin/auth/login");
$user = Users::find_by_attribute("uuid",$_SESSION['uuid']);

// $expiry_date = time() + (2 * 60 * 60); // 2 hours

// $tokenAuth = new TokenAuth();
// $token = $tokenAuth->linkToken($user->uuid, $expiry_date,'testing',20);


$page = 'dashboard';
if(isset($_GET['page']))
    $page = strtolower($_GET['page']);

$template->twig->addGlobal('current_page', $page);


$vars = array(
    'header' => array('title' => $page),
    'navbar' => array('username'=> $user->username),
    'bc' => array('root' => 'Administrator', 'directory'=> $page)
);

if($page==='dashboard'){
    $vars['dashboard'] = array(
        'files' => sizeof(FileHandler::getAllFiles()),
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
        'data' => TokenAuth::find_all(),
        'tableName' => 'dataTable2'
    );
}else if($page==='upload-files'){
    $vars['header']['title']='Upload files';
    $vars['bc']['directory']='Upload files';
    $vars['upload']=array(
        'files'=>sizeof(FileHandler::getAllFiles()),
        'values'=> $_POST,
    );
}else if($page==='list-files'){
    $vars['header']['title']='Show server files';
    $vars['bc']['directory']='Show server files';
    $vars['ls']['files'] = FileHandler::getAllFiles();
}else if($page==='add-post'){
    $vars['header']['title']='Add a post';
    $vars['bc']['directory']='Add a post';
    $vars['post'] = array(
        'values' => $_POST,
    );
}else if($page==='install'){
    $vars['install'] = array(
        'must' => env('CORE_RUN_SCRIPT'),
    );
    $template->render('pages/'.$page, $vars);
}

if($page!=='install')
$template->render('pages/home/'.$page, $vars);
