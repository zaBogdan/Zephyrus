<?php
require_once(__DIR__.'/../api/init.php');

/**
 * Checking if the user is logged in
 */
if(!$session->checkLogin()){
    header("Refresh:0; url=/admin/auth.php", true, 401);
    die("User is not logged in!");
}

/**
 * Simulate a real enviorment
 */
$uuid = $_SESSION['uuid'];
$token = $_SESSION['token'];
/**
 * Go check what you've done
 * ----------------------------------------------------
 */


/**
 * Update user role
 */
$user = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
$user->data = json_decode($user->data);
$user->data->role = "Founder";
$user->data->special_perms = array();
$user->data = json_encode($user->data);
$user->save_to_db();
var_dump($user);


die("Nothing for now");
