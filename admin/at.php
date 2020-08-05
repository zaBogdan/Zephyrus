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
// $user = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
// if($user->username === 'zaBogdan' && $user->uuid === '20e6ebcd-b122-4bdf-b902-c56a24c40389')
// $user->data->role = "Founder";
// $user->save_to_db();
// echo "<pre>";
// var_dump($user);
// echo "</pre>";
// var_dump($role->canEditUserRole("Moderator", "Administrator"));

// $perm = new \Api\Management\Permissions();
// var_dump($perm->createPermission("deleteExistingUser", "Delete an user from the database."));
// $new_role = $role->find_by_attribute("name", "Founder");
// $new_role->decorations->administrative = true;
// $new_role->save_to_db();
// var_dump($role->inheritPermissions("Administrator", "Moderator"));
var_dump($role->addPermission("Administrator", array(
    "uploadSize",
//     "accessAdmin",
//     "assignRole",
//     "revokeForeignToken",
)));
var_dump($role->inheritPermissions("Founder", "Administrator"));
// var_dump($role->addPermission("Founder", array(
//     "assignAdministrativeRole",
// )));
// $email = new \Api\Misc\Email();
// $val = array(
//     'username' => "zaBogdan", 
//     'p_one' => "This is jusst a test", 
//     'p_two' => "Wtf is this?",
//     'link' => "http://localhost:8000", 
//     'button'  => "Click me?"
// );
// $email->sendMessage("bogdanzavadovschi17@gmail.com", "Just a testing email",$val);
// var_dump($user->send_confirmation());
die("Nothing for now");
