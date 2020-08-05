<?php
require_once(__DIR__.'/../../api/init.php');

if(!isset($_GET['action']))
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

if($action === 'edit'){
    if(!$role->hasPermission($loggedUser, "modifyForeignUser")){
        header("Refresh:0; url=/", true, 401);
        die("Insufficient permissions!");
    }
    if(!isset($_GET['uuid']))
        die("We can't select the user without UUID");
    $user = \Api\Management\Users::find_by_attribute("uuid", $_GET['uuid']);
    $vars['user'] = $user;
    $vars['loggedUser'] = $loggedUser;
    $roles = $role::find_all();
    $roling = array();
    foreach($roles as $rolee){
        if($role->requiresAdministrative($rolee->name))
            if(!$role->hasPermission($loggedUser, "assignAdministrativeRole"))
                continue;
        $roling[] = $rolee->name;
    }
    $vars['roles'] = $roling;
}else if($action === 'delete'){
    if(!$role->hasPermission($loggedUser, "deleteExistingUser")){
        header("Refresh:0; url=/", true, 401);
        die("Insufficient permissions!");
    }
}

$vars['header'] = array('title'=>$action." user");
$vars['bc'] = array('root' => 'Manage', 'directory'=> $action);


$template->render('pages/manage/edit-user', $vars);
