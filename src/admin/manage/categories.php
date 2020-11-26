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

if($action === 'edit'){
    if(!isset($_GET['name']) || empty($_GET['name']))
        die("We can't select the user without name");
    $cat = \Api\Management\Categories::find_by_attribute("name", $_GET['name']);
    $vars['c'] = $cat;
}

$vars['header'] = array('title'=>$action." category");
$vars['bc'] = array('root' => 'Administrator', 'directory'=> array('Manage','Categories'), 'last'=>$action);


$template->render('pages/manage/categories/'.$action, $vars);
