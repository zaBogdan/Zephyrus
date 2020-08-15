<?php
include(__DIR__.'/api/init.php');


/**
 * Checking if the application is installed.
 */
if(intval(GET_ENV['CORE_RUN_SCRIPT'])!==2){
    $vars['header']['title'] = 'Error';
    $msg = "Your service is not installed. Before doing anything please go and install it!";
    $vars['error'] = array(
        'name' => "Zephyrus is not installed",
        'message' => $msg,
        'url' => "/admin/install",
        'button' => 'Install'
    );
    $template = new \Api\Misc\Render('/main/templates');
    $template->render('pages/misc/error', $vars);
    die("Service is not installed!");
}

/**
 * Checking if the user is logged in
 */
if(!$session->checkLogin()){
    header("Refresh:0; url=/presentation", true, 401);
    die("You must be logged in to access this page!");
}
/**
 * Get the logged user
 */
$user = \Api\Management\Users::find_by_attribute("uuid", $_SESSION['user']);

/**
 * Check if the user has enough permission
 */

if(!$role->hasPermission($user, "readPosts")){
    header("Refresh:0; url=/", true, 401);
    die("Insufficient permissions!");
}




/**
 * This all must be reworked and set like it should be!
 */


$page='blog';
if(isset($_GET['page']) && !empty($_GET['page']))
    $page = $_GET['page'];
$path = "home";
$name = $page;

$vars = array(
    "body" =>array('name'=>strtolower($page)),
    "user" => $user,
);

if($page === 'create-new'){
    $path = "manage";
    $vars['header']['editor'] = true;
    $name = "Create new post";
    $vars['post'] = $_POST;
}

/**
 * This must be removed once done all the implementation
 */
$values = array(
    'data' => array(
        'image' => 'https://i.imgur.com/IQgzFsi.png', 
        'category' => 'Documentation',
        'title' => "How to give proof of concept when you didn't even released your app",
        'author' => 'zaBogdan',
        'serial' => '39dc947dc48da9f5',
        'tags' => array(
            'Zephyrus','HTB', 'HackTheBox', 'Blog', 'CMS', 'Documentation'
        )
    ),
    'author' => array(
        'image' => 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fd/fd4372b86edca6468c80bfa8c79361c250fbb22c_full.jpg',
    ),
    'categories' => array(
        array(
            "name" => "Documentation",
            "image" => "verified"
        ),
        array(
            "name" => "Adventure",
            "image" => "speed"
        ),
        array(
            "name" => "Popular",
            "image" => "local_fire_department"
        ),
    ),
);

$vars["header"]['title'] = $name;
$vars = array_merge($vars, $values);
$template = new \Api\Misc\Render('/main/templates');
$template->render("/pages".'/'.$path.'/'.strtolower($page), $vars);