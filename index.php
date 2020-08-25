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
$pg = 1;
if(isset($_GET['pg']) && !empty($_GET['pg']))
    $pg = $_GET['pg'];

$vars = array(
    "body" =>array('name'=>strtolower($page), 'pg'=> $pg),
    "user" => $user,
    "nav" => array('categories' => \Api\Management\Categories::find_all()),
);

if($page === 'create-new'){
    $path = "manage/posts";
    $vars['header']['editor'] = true;
    $name = "Create new post";
    $vars['post'] = $_POST;
    $vars['env'] = $sensitive->env;
}else if($page === 'blog'){
    $vars['featured'] = array_shift(\Api\Management\Posts::send_query("SELECT p.id AS 'posts_id', p.* FROM `posts` p WHERE p.status='public' ORDER BY id DESC LIMIT 1"));
}else if($page === 'edit'){
    if(!(isset($_POST['s']) && !empty($_POST['s']))){
        header("Refresh:0; url=/", true, 401);
        die("Insufficient permissions!");
    }
    $path = "manage/posts";
    $vars['header']['editor'] = true;
    $name = "Edit your post";
    $vars['post'] = $_POST;
    $vars['env'] = $sensitive->env;
}

$vars["header"]['title'] = $name;
$template = new \Api\Misc\Render('/main/templates');
$template->render("/pages".'/'.$path.'/'.strtolower($page), $vars);