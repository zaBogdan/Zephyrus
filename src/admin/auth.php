<?php
/**
 * Out of service! Keeping the code just in case!
 */

require_once(__DIR__.'/../api/init.php');


header("Refresh:5; url=/auth?page=login", true, 303);
die("This path is out of service! Please use /auth from now on. You will be redirected in 5 seconds.");

/**
 * Checking if the application is installed.
 */
if(intval(GET_ENV['CORE_RUN_SCRIPT'])!==2){
    $msg = "Your service is not installed. Please go to ";
    $msg .= '<a href="install" target="_blank">instalation page</a>.';
    $vars['error'] = array(
        'title' => "zaEngine is not installed",
        'message' => $msg,
    );
    $template = new \Api\Misc\Render();
    $template->render('pages/home/error', $vars);
    die();
}
$page = 'login';
if(isset($_GET['page']))
    $page = $_GET['page'];
/**
 * Checking if the user is logged in
 */
if($session->checkLogin() && $page !=='logout' && $page!=='confirm-email'){
    header("Refresh:0; url=/admin", true, 301);
    die("User is logged in!");
}

/**
 * Work with rendering. Modify this, make it cleaner.
 */


$name = $page;
if($page === 'login'){
    $vars['login'] = array(
        'values' => $_POST,
    );
}elseif($page === 'register'){
    $vars['register'] = array(
        'values' => $_POST,
    );
}else if($page === 'logout'){
    $session->destroySession();
    header("Refresh:0; url=/admin", true, 200);
    die("You must have been redirected to /admin/auth");
}else if($page === 'confirm-email'){
    $name = "Confirm email";
}else if($page === 'forgot-password'){
    $name = "Reset Password";
}else if($page === 'reset-password'){
    $name ='Reset your password';
}else if($page === 'generate-reset'){
    $name = 'Regenerate confirmation email';
}else if($page === 'generate-confirmation'){
    $name = 'Regenerate confirmation email';
}
$vars['header'] = array('title'=>$name);
$template = new \Api\Misc\Render();
$template->render('pages/auth/'.$page, $vars);


