<?php

namespace Api\Management;


class Posts extends \Api\Database\DbModel{
    protected static $db_table = "posts";
    protected static $db_fields = array('id', 'title','author','status', 'description', 'text', 'date','serial');
    protected static $allowedStatus = array('public', 'private', 'unlisted', 'draft');

    public $id;
    public $title;
    public $author;
    public $description;
    public $text;
    public $status;
    public $date;
    public $serial;

    public static function getStatus(){
        return self::$allowedStatus;
    }
    public function createPost($user){
        global $role;
        if(!isset($_POST['submit']))
            return null;
        $this->title = $_POST['title'];
        $this->author = $user->id;
        $this->description = $_POST['description'];
        $this->text = $_POST['text'];
        $this->status = $_POST['status'];
        if(!in_array($this->status, self::$allowedStatus))
            return "You can only have ".strtoupper(implode(', ', self::$allowedStatus))." as status to your posts!";
        $status = time();
        if($this->status !== 'public')
            $status = null;
        $this->date = array(
            "created" => time(),
            "lastEdited" => null,
            "published" => $status,
        );
        /**
         * Adding an unique serial. 
         */
        $this->serial = \Api\Security\Tokens::secureTokens(1);
        while(self::find_by_attribute("serial", $this->serial))
            $this->serial = \Api\Security\Tokens::secureTokens(1);
        var_dump($this);
        if(!$this->save_to_db())
            return "There was an error while trying to save the post to the database!";
        return "Post saved succesfully";
    }

    
}