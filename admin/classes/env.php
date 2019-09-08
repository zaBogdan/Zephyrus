<?php

$variables = array(
    'DATABASE_NAME' => 'zaEngine',
    'DATABASE_USERNAME' => 'root',
    'DATABASE_PASSWORD' => '',
    'DATABASE_HOST' => 'localhost',
    'MAILGUN_API_KEY' => '7356e208ef2ffe367ae09f624096f652-73ae490d-b6222af7',
    'MAILGUN_DOMAIN' => 'sandbox911c9f10c6d14ae0baf579b68d2cb243.mailgun.org',
    'MAILGUN_EMAIL_SENDER' => 'no-replay@zaengine.ro',
    'CORE_SECRET_KEY' => 'wolvezZoneSecret',
    'CORE_RUN_SCRIPT' => FALSE,
);

foreach($variables as $key => $value)
    putenv("$key=$value");