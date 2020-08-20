<?php
require_once(__DIR__.'/../api/init.php');

/**
 * Checking if the user is logged in
 */
if(!$session->checkLogin()){
    header("Refresh:0; url=/auth?page=login", true, 401);
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
// echo "<pre>";
// var_dump($session->hasFreshToken());
// echo "</pre>";

// echo "<pre>";
// var_dump($session->generateNewFresh());
// echo "</pre>";
/**
 * Update user role
 */
$posts = \Api\Management\Posts::find_by_attribute("status", "public");

htmlspecialchars(var_dump($posts));
// foreach($users as $user){
//     //this is just until the file upload is finished!
//     $user->data->image = "https://via.placeholder.com/150/008000/FFFFFF/64x64.png?text=".strtoupper($user->data->firstname[0].$user->data->lastname[0]);
//     $user->save_to_db();
// }
// $user = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
// if($user->username === 'zaBogdan' && $user->uuid === '8ad069c8-09a7-49e8-b04a-c87a04b528a1')
// $user->data->role = "Founder";
// $user->save_to_db();
// echo "<pre>";
// var_dump($user);
// echo "</pre>";
// var_dump($role->canEditUserRole("Moderator", "Administrator"));

// $post = new \Api\Management\Posts();
// $string = "<script>,alert(1),</script>";
// var_dump($post->handle_tags($string));
/**
 * Add a new permission
 */
// $perm = new \Api\Management\Permissions();
// var_dump($perm->createPermission("readTokens", "Get access to the tokens page."));
// var_dump($perm->createPermission("deleteForeignContent", "Delete foreign content."));

/**
 * Inherit permissions
 */
// var_dump($role->inheritPermissions("Administrator", "Moderator"));

/**
 * Assign permissions to a role
 */
// var_dump($role->addPermission("Administrator", array(
//     "deleteForeignContent"
// )));
// var_dump($role->inheritPermissions("Founder", "Administrator"));
// var_dump(\Api\Management\Roles::getRolePermissions("Founder"));



die("Nothing for now");
