<?php


class Users extends DbModel{
    protected static $db_table = "users";
    protected static $db_fields = array('id', 'uuid', 'username', 'email', 'password', 'firstname', 'lastname', 'registration_date', 'notifications');

    public $id;
    public $uuid;
    public $username;
    public $email;
    public $password;
    public $firstname;
    public $lastname;
    public $registration_date;
    public $notifications;


}