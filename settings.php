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
 * This all must be reworked and set like it should be!
 */
$values = array(
    'author' => array(
        'image' => 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fd/fd4372b86edca6468c80bfa8c79361c250fbb22c_full.jpg',
    ),
);

$page='edit-profile';
if(isset($_GET['page']) && !empty($_GET['page']))
    $page = $_GET['page'];
$path = "settings";
$name = $page;

if($page === 'edit-profile'){
    $name = 'Edit profile settings';
    $values['data'] = $_POST;
}else if($page === 'change-password'){
    $name = 'Change your password';
}
else if($page === 'change-email'){
    $name = 'Change your email';
    if(!$session->hasFreshToken()){
        $path = "misc";
        $page = "confirm-password";
        $name = "Confirm password";
    }
}
else if($page === 'email-preferences'){
    $name = 'Email preferences';
}

/**
 * This must be removed once done all the implementation
 */
$vars = array(
    "header" => array('title'=>$name),
    "body" =>array('name'=>strtolower($page)),
    "user" => $user,
);

$vars = array_merge($vars, $values);
$template = new \Api\Misc\Render('/main/templates');
$template->render("/pages".'/'.$path.'/'.strtolower($page), $vars);