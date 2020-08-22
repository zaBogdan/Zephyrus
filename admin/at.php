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

/**
 * Some new features to the database.
 */
// $user =\Api\Management\Users::find_by_attribute("uuid",  $_SESSION['user']);
// $posts = \Api\Management\Posts::send_query("SELECT p.id AS 'posts_id', p.*, c.id AS 'categories_id', c.* FROM `posts` p INNER JOIN `posts_categories` b ON b.postID = p.id INNER JOIN `categories` c ON c.id = b.categoryID WHERE p.author='{$user->id}' AND p.status='public'");
// echo "<pre>";
// $posts = \Api\Management\Posts::find_by_attribute('serial','014759186e62b8f4');
// var_dump($posts);
// echo "</pre>";
// $category = \Api\Management\Categories::find_by_attribute('name', 'Horror');
// $category->data->icon = "bedtime";
// $category->save_to_db();


// $category->name = "Horror";
// $category->data = array("color"=> "#ec4242");
// $category->save_to_db();
// $post = \Api\Management\Posts::find_by_attribute("serial", "8994c7d8317e2c50");
// $post->id=null;
// $post->foreignKey = 1;
// $post->save_to_db();
 /**
  * End of section
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
// die("Nothing for now");

?>
