<?php
require_once(__DIR__.'/../../api/init.php');

if(!isset($_GET['action']))
    die("No action set!");
$action = $_GET['action'];

/**
 * Get the logged user
 */
$loggedUser = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
$loggedUser->data = json_decode($loggedUser->data);
/**
 * Check if the user has enough permission
 */

$template = new \Api\Misc\Render();

if($action === 'edit'){
    if(!$role->hasPermission($loggedUser, "modifyForeignUser")){
        header("Refresh:0; url=/", true, 401);
        die("Insufficient permissions!");
    }
    if(!isset($_GET['uuid']))
        die("We can't select the user without UUID");
    $user = \Api\Management\Users::find_by_attribute("uuid", $_GET['uuid']);
    $user->data = json_decode($user->data);
    $vars['user'] = $user;
    $roles = $role::find_all();
    $arr = array();
    foreach($roles as $role){
        if($role->name===$user->data->role)
            continue;
        $arr[] = $role->name;
    }
    $vars['roles'] = $arr;
    if(isset($_POST['submit'])){
        /**
         * TO BE DONE
         */
        var_dump($_POST);
    }
}

$vars['header'] = array('title'=>$action." user");
$vars['bc'] = array('root' => 'Manage', 'directory'=> $action);


$template->render('pages/manage/edit-user', $vars);
