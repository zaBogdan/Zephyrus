<?php

$variables = array(
    'DATABASE_NAME' => '',
    'DATABASE_USERNAME' => '',
    'DATABASE_PASSWORD' => '',
    'DATABASE_HOST' => '',
    'MAILGUN_API_KEY' => '',
    'MAILGUN_DOMAIN' => '',
    'MAILGUN_EMAIL_SENDER' => '',
    'EMAIL_TEMPLATES_PATH' => '',
    'CORE_SECRET_KEY' => '',
    'CORE_RUN_SCRIPT' => false,
);

foreach($variables as $key => $value)
    putenv("$key=$value");