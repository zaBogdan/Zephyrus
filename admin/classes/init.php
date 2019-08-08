<?php
require_once '../vendor/autoload.php';
require_once 'dbmodel.php';
require_once 'database.php';
require_once 'users.php';
require_once 'session.php';
require_once 'tokenauth.php';


$secretKey = "d29sdmVzWm9uZTRFdmVy";

$db = new Database();