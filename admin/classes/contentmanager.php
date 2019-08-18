<?php

class ContentManager extends DbModel{
    protected static $db_table = "content";
    protected static $db_fields = array('id','title','author','category','image','serial','content','posted_on','status','format');

    private $storage_name = "/posts";
    public $id;
    public $title;
    public $author;
    public $category;
    public $image;
    public $serial;
    public $content;
    public $posted_on;
    public $status;
    public $format;

    public function createPost(Array $values,Array $file){
        global $user;
        $this->author = $user->username;
        $this->title = $values['title'];
        $this->category = $values['category'];

        //set the image there
        // print_r($file['file_upload']);
        $this->image = !$file['file_upload']['error'] ? 
        FileHandler::upload_file($this->author.$this->storage_name,$file['file_upload']):
        false;
        $this->serial = TokenAuth::generateToken(10);
        $this->content = $values['content'];
        $this->posted_on = date('d-m-Y');
        $this->status = $values['status'];
        $this->format = $values['format'];
    }

}