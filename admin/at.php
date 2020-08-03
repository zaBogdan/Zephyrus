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
// $user->data = json_decode($user->data);
// $user->data->role = "Founder";
// $user->data->special_perms = array();
// $user->data = json_encode($user->data);
// $user->save_to_db();
// var_dump($user);

// $email = new \Api\Misc\Email();
// $val = array(
//     'username' => "zaBogdan", 
//     'p_one' => "This is jusst a test", 
//     'p_two' => "Wtf is this?",
//     'link' => "http://localhost:8000", 
//     'button'  => "Click me?"
// );
// $email->sendMessage("bogdanzavadovschi17@gmail.com", "Just a testing email",$val);
var_dump($user->send_confirmation());
die("Nothing for now");
