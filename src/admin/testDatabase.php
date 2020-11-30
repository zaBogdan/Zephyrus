<?php

use Api\Testing\FakeUser;

require_once(__DIR__.'/../api/init.php');

/**
 * Checking if the user is logged in
 */
if(!$session->checkLogin()){
    header("Refresh:0; url=/auth?page=login", true, 401);
    die("User is not logged in!");
}

/**
 * Get the logged user
 */
$sessionUser = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);
/**
 * Check if the user has enough permission
 */
if(!$role->hasPermission($sessionUser, "databaseFeatureTesting")){
    header("Refresh:0; url=/?page=blog", true, 401);
    die("Insufficient permissions!");
}

// $user = new \Api\Testing\FakeUser;
// $data = $user->search()->filter("username","zaBogdan")->filter("id",1)->first()->submit();
$post = new \Api\Testing\FakePost;
$data = $post->search()->filter("author","zaBogdan")->filter("id",1)->first()->submit();

echo "<br />";
echo "--------- Submited data ---------";
echo "<br />";
echo "<pre>";
var_dump($data);
echo "</pre>";