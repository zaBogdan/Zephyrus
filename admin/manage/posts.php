<?php
require_once(__DIR__.'/../../api/init.php');

if(!isset($_GET['action']) || empty($_GET['action']))
    die("No action set!");
$action = $_GET['action'];

/**
 * Get the logged user
 */
$loggedUser = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
/**
 * Check if the user has enough permission
 */

$template = new \Api\Misc\Render();

if($action === 'create'){
    if(!$role->hasPermission($loggedUser, "createPosts")){
        header("Refresh:0; url=/admin/?page=posts", true, 401);
        die("Insufficient permissions!");
    }
    $vars['loggedUser'] = $loggedUser;
}else if($action === 'edit'){
    if(!$role->hasPermission($loggedUser, "modifyForeignContent")){
        header("Refresh:0; url=/admin/?page=posts", true, 401);
        die("Insufficient permissions!");
    }
    if(!isset($_GET['serial']) || empty($_GET['serial']))
        die("You can't edit posts without the proper serial!");

    $post = \Api\Management\Posts::find_by_attribute("serial", $_GET['serial']);
    if(!$post)
        die("This post doesn't exist!");

    $vars['post'] = $post;
    $status = \Api\Management\Posts::getStatus();
    $arr = array();
    foreach($status as $s){
        if($s === $post->status)
            continue;
        $arr[] = $s;
    }
    $vars['statuses'] = $arr;
}else if($action === 'delete'){
    if(!$role->hasPermission($loggedUser, "deleteForeignContent")){
        header("Refresh:0; url=/admin/?page=posts", true, 401);
        die("Insufficient permissions!");
    }
    if(!isset($_GET['serial']) || empty($_GET['serial']))
        die("You can't edit posts without the proper serial!"); 
    $post = \Api\Management\Posts::find_by_attribute("serial", $_GET['serial']);
    $vars['post'] = $post;
}


$vars['header'] = array('title'=>$action." post", 'editor'=>true);
$vars['navbar'] = array('username'=> $loggedUser->username);
$vars['bc'] = array('root' => 'Administrator', 'directory'=> array('Manage','Posts'), 'last'=>$action);


$template->render('pages/manage/posts/'.$action, $vars);