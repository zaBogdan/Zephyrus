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
 * Getting the page setup
 */
$page='login';
if(isset($_GET['page']) && !empty($_GET['page']))
    $page = $_GET['page'];
$name= $page;
/**
 * Checking if user is logged in
 */
$allowed_pages = array('logout', 'confirm-email', 'confirm-account');
if($session->checkLogin() && !in_array($page, $allowed_pages)){
    header("Refresh:0; url=/", true, 301);
    die("User is logged in!");
}


/**
 * Handle pages
 */
if($page === 'login'){
    $vars['user'] = $_POST;
}elseif($page === 'register'){
    $vars['user'] = $_POST;
}else if($page === 'logout'){
    $session->destroySession();
    header("Refresh:0; url=/presentation", true, 200);
    die("You are redirected to main page!");
}else if($page === 'confirm-email'){
    $name = "Confirm email";
}else if($page === 'forgot-password'){
    $name = "Reset Password";
    if(isset($_GET['email']) && !empty($_GET['email']))
        $vars['user']['email'] = $_GET['email'];
}else if($page === 'reset-password'){
    $name ='Reset your password';
}else if($page === 'confirm-account'){
    $name ='Confirm your account';
    if(isset($_GET['email']) && !empty($_GET['email']))
        $vars['user']['email'] = $_GET['email'];
}
else{
    $vars['header']['title'] = 'Error';
    $msg = "Page you requested doesn't exist! Please head back to the main page!";
    $vars['error'] = array(
        'name' => "Error 404. Page doesn't exist!",
        'message' => $msg,
        'url' => "/presentation",
        'button' => 'Go home'
    );
    $template = new \Api\Misc\Render('/main/templates');
    $template->render('pages/misc/error', $vars);
    die("Page you requested doesn't exist!");
}

/**
 * Working with rendering
 */

$vars['header'] = array('title'=> $name);
$template = new \Api\Misc\Render('/main/templates');
$template->render('/pages/auth/'.strtolower($page), $vars);