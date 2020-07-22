<?php
require_once(__DIR__.'/../api/init.php');

/**
 * Simulate a real enviorment
 */
$logged_user = array(
    "username" => "zaBogdan",
    "uuid" => "590ef421-dd82-45ed-ad35-c0555b2aaf65",
);

/**
 * Go check what you've done
 */

echo "<pre>";
var_dump(openssl_get_cipher_methods());
echo "</pre>";
//aes-256-gcm

die("Nothing for now");