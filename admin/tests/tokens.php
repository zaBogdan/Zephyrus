<?php
require_once(__DIR__.'/../api/init.php');

/**
 * Simulate a real enviorment
 */
$logged_user = array(
    "username" => "zaBogdan",
    "uuid" => "590ef421-dd82-45ed-ad35-c0555b2aaf65",
);

$tokenDB = new \Api\Management\Tokens();

/**
 * Create a new token
 */

// $tokenDB->save_token($logged_user['uuid'], "automated_testing", array("fresh"=>true, "longTerm"=>false));
// $tokenDB->save_token($logged_user['uuid'], "automated_testing", array("specificTime"=> 1*60));
// $tokenDB->save_token($logged_user['uuid'], "automated_testing", array("fresh"=>true, "longTerm"=>true))) 

/**
 * Searching for a token in the database and verifying timestamps
 */
$tokens = array(
    "fresh"=> "098a245a708e33c6-f326ae4999fb2e95-ac504d9caeff0ca5", 
    "longTerm"=>"4857a4a6f7834f22-4ef0db90f218fc9c-07bef7f11477f66b",
    "both" => "a4db32a08f6f7941-a01f367ac4ab5d3f-af1da97d34d3ebd5",
    "nothing" => "24b653cfb639ed93-609733ac8f317f34-b5fbe56ccad2fa58",
    "specificTime" => "cf5f26337db1943c-b1fe7ef42c17ce50-fee7061778578266"
);

foreach($tokens as $token => $value){
    echo "Token generated for: ".$token."<br/>";
    $fresh = $tokenDB::find_by_attribute("token", $value);
    $fresh->status = json_decode($fresh->status);
    echo "Dates: <br>";
    echo "Actual Time: ".date("d-m-Y H:i:s");
    echo "<br> ";
    echo "Freshness: ".date("d-m-Y H:i:s", $fresh->status->freshUntil);
    echo "<br> ";
    echo "LongTerm: ".date("d-m-Y H:i:s", $fresh->status->expireTime);    
    echo "<br> ";
    echo "Status: ".$fresh->status->status;
    echo "<br>================================================<br/><br/>";
    /**
     * Uncomment the following line to revoke all tokens from the array. 
     */
    // $fresh->revokeToken($fresh->token);
}

