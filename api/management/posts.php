<?php

namespace Api\Management;


class Posts extends \Api\Database\DbModel{
    protected static $db_table = "posts";
    protected static $db_fields = array('id', 'title','author','status', 'description', 'text', 'date','serial');
    protected static $mtm_table = "posts_categories";
    protected static $mtm_fields = array('id','postID', 'categoryID');
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
        $category = \Api\Management\Categories::find_by_attribute("name", $_POST['category']);
        if(!$category)
            return $_POST['category']." doesn't exists!";
        $this->foreignKey = $category->id;

        if(!in_array($this->status, self::$allowedStatus))
            return "You can only have ".strtoupper(implode(', ', self::$allowedStatus))." as status to your posts!";
        $status = time();
        if($this->status !== 'public')
            $status = null;
        /**
         * Adding tags and categories.
         */
        $tags = self::handle_tags($_POST['tags']);
        if($tags === false)
            return "You can add up to 5 tags that are under 10 characters each!";
        

        /**
         * Must add categories and handelers for this!
         */
        $category = $_POST['category'];
        
        /**
         * Save everything into data.
         */
        $this->date = array(
            "created" => time(),
            "lastEdited" => null,
            "published" => $status,
            "category" => $category,
            "tags" => $tags
        );
        /**
         * Adding an unique serial. 
         */
        $this->serial = \Api\Security\Tokens::secureTokens(1);
        while(self::find_by_attribute("serial", $this->serial))
            $this->serial = \Api\Security\Tokens::secureTokens(1);

 
        if(!$this->save_to_db())
            return "There was an error while trying to save the post to the database!";
        return "Success";
    }

    public static function handle_tags($tags){
        if(empty($tags) || !isset($tags))
            return null;
        $array = explode(',', $tags);
        if(count($array)>5)
            return false;
        foreach($array as $tag){
            if(strlen($tag)>10)
                return false;
        }
        foreach($array as $tag){

        }
        return $array;
    }
    
}