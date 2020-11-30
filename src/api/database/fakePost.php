<?php
namespace Api\Testing;

class FakePost extends \Api\Database\DatabaseModel{
    protected $foreignKey = array("author"=>"Users");
    protected $manyTomany = array("category"=>"Categories");
    public $id;
    public $title;
    public $author;
    public $description;
    public $text;
    public $status;
    public $date;
    public $serial;
    public $category;
}