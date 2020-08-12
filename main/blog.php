<?php

include(__DIR__.'/api/init.php');

$page='blog';
if(isset($_GET['page']))
    $page = $_GET['page'];
$vars = array(
    'header'=> array('title'=> "Settings"),
    'body'=>array('name'=>strtolower($page)),
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
        'name' => "Bogdan Zavadovschi",
        'date' => '1596709673',
        'description' => 'Cyber Security Enthusiast & Project developer',
        'username' => 'zaBogdan'
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
$template = new \Api\Misc\Render('/main/templates');
$template->render('/pages/home/'.strtolower($page), $vars);