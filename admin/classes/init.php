<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/classes/dbmodel.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/classes/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/classes/users.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/classes/session.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/classes/emailhandler.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/classes/tokenauth.php';

$db = new Database();
$email = new EmailHandler();