<?php

namespace Api\Management;


class Posts extends \Api\Database\DbModel{
    protected static $db_table = "posts";
    protected static $db_fields = array('id', 'title','author','status', 'description', 'text', 'date');

    public $id;
    public $title;
    public $author;
    public $description;
    public $text;
    public $status;
    public $date;
}