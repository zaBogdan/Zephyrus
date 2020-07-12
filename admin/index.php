<?php
require_once(__DIR__.'/../api/init.php');

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

/**
 * Checking if the user is logged in
 */


/**
 * Work with rendering. Modify this, make it cleaner.
 */
$token = new \Api\Security\Tokens();
$gtoken = $token->secureTokens(10);
$guuid =  $token->UUID();
echo "UUID: ".$guuid;
echo "<br>";
echo "Token: ".$gtoken;
echo "<br>";
$gbounder = $token->bounder("testing",$gtoken,$guuid);
echo "Bounder: ".$token->bounder("testing",$gtoken,$guuid);
echo "<br>";
if($gbounder == $token->bounder("testing",$gtoken,$guuid))
    echo "Ok!!!!";
echo "<pre>";
echo $token->genStatus(True, false);
echo "</pre>";
$tokenDB = new \Api\Management\Tokens();

$tokenDB->save_token("2a883915-3057-4772-9e9a-eb754a56b370","test",array("fresh"=>true, "longTerm"=>false));


 // $user = new \Api\Management\Users();
// $data = array(
//     "username" => "zaBogdan",
//     "password" => "thisIsJustATest0$",
//     "email" => "zaBogdan@zaengine.ro"
// );
// echo "<pre>";
// print_r($data);
// echo "</pre>";

// $data2 = $user->dataValidation($data);

// echo "<pre>";
// print_r($data2);
// echo "</pre>";




// $page = 'dashboard';
// $name = $page;
// $vars['dashboard'] = array(
//     'files' => 15,
// );
// $vars['header'] = array('title'=>$name);
// $vars['navbar'] = array('username'=> "zaBogdan");
// $vars['bc'] = array('root' => 'Administrator', 'directory'=> $name);
// $template = new \Api\Misc\Render();
// $template->render('pages/home/'.$page, $vars);
