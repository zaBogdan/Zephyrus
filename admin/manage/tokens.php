<?php
require_once(__DIR__.'/../../api/init.php');

if(!isset($_GET['action'])  || empty($_GET['action']))
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

if($action === 'revoke'){
    if(!$role->hasPermission($loggedUser, "revokeForeignToken")){
        header("Refresh:0; url=/", true, 401);
        die("Insufficient permissions!");
    }

    if(!isset($_GET['selector']) || empty($_GET['selector']))
        die("We can't select the user without UUID");
    $token = \Api\Management\Tokens::find_by_attribute("selector", $_GET['selector']);
    if(!$token)
        die("The selector is invalid!");
    if(!$token->revokeToken($token->selector)){
        die("There was an error while revoking the token!");
    }
    header("Refresh:0; url=/admin/?page=tokens", true, 200);
    die("Token revoked");
        
}

$vars['header'] = array('title'=>$action." user");
$vars['bc'] = array('root' => 'Administrator', 'directory'=> array('Manage','Tokens'), 'last'=>$action);


$template->render('pages/manage/token/'.$action, $vars);
