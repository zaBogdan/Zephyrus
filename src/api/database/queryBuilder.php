<?php 
/**
 * To do:
 * -> add one to many support
 */
/*
SELECT
    'posts', posts.*,
    'categories', categories.*,
    'author', author.*
FROM
    `posts` posts 
    JOIN `users` author ON posts.author = author.id
    JOIN `posts_categories` pc ON pc.postID = posts.id 
    JOIN `categories` categories ON categories.id=pc.categoryID
*/
/*
SELECT 
    'fakepost', fakepost.*,
    'author', author.*,
    'category', category.*
FROM 
    'fakepost' fakepost
    JOIN 'fakeUsers' author ON fakepost.id=author.id 
    JOIN 'category_fakepost' cf ON cf.fakepostID=fakepost.id 
    JOIN 'fakeCategory' category ON cf.categoryID=category.id
*/
 //SELECT 'posts', posts.*, 'categories', categories.* FROM `posts` posts, `posts_categories` pc , `categories` categories WHERE pc.postID = posts.id AND pc.categoryID = categories.id
namespace Api\Database;

class QueryBuilder{
    private $sql = array();
    private $syntax = array("SELECT"=>"FROM", "WHERE"=>"AND", "JOIN"=>"ON");

    public function search(){
        $currentDB = $this->getDatabase();
        $this->sql['select']['database'] = $currentDB;
        return $this;
    }
    public function first(){
        $this->sql['limit'] = 1;
        // $this->sql .= "LIMIT 1 ";
        return $this;
    }

    public function filter($name, $value, $op="="){
        $name= strtolower($name);
        if(!in_array($name, $this->getVariables()))
            die("The field doesn't exist in the database");
        global $db;
        $value = $db->escape_string($value);
        if(!is_array($this->sql['where']))
            $this->sql['where']=array(); 
        array_push($this->sql['where'], "{$name} {$op} {$value}");
        return $this;
    }
    //make it somehow redundant
    public function submit(){
        $value = $this->buildQuery();
        // $sql = $this->buildSQL
        // var_dump($this->sql);
        // $value = $this->sendQuery($this->sql);
        return $this->sql;

        //make sure it's an array;
        // return is_array($value) ? $value : array("error"=>$value);
    }

    private function getForeignKeyUser(){
        if($this->foreignKey!=NULL)
            $this->sql['select']['join']['foreignKey']=$this->foreignKey;
    }
    private function getManyToMany(){
        if($this->manyTomany!=NULL)
            $this->sql['select']['join']['manyTomany']=$this->manyTomany;
    }
    private function getOneToMany(){
        if($this->oneTomany!=NULL)
            $this->sql['select']['join']['oneTomany']=$this->oneTomany;
    }
    private function getVariables(){
        return array_keys(get_object_vars($this));
    }
    private function getDatabase() {
        $path = explode('\\', strtolower(get_class($this)));
        return array_pop($path);
    }
    private function select($arr){
        $str = "SELECT ";
        $str.= "'{$arr['database']}', ";
        $str.= "{$arr['database']}.*, ";
        if(!empty($arr['join']))
            foreach($arr['join'] as $key)
                foreach($key as $k => $value){
                    $str.= "'{$k}', ";
                    $str.= "{$k}.*, ";
                }
        $str = substr($str, 0, -2)." ";
        $str.= $this->syntax['SELECT']." ";
        $str.= "'{$arr['database']}' ";
        $str.= "{$arr['database']} ";
        if(!empty($arr['join'])){
            $join = $arr['join'];
            if(!empty($join['foreignKey'])){
                $prop=key($join['foreignKey']);
                $dbName = strtolower($join['foreignKey'][$prop]);
                $str.="JOIN '{$dbName}' ".$prop;
                $str.=" ".$this->syntax['JOIN']." {$arr['database']}.id={$prop}.id ";
            }
            if(!empty($join['manyTomany'])){
                $prop=key($join['manyTomany']);
                $dbName = strtolower($join['manyTomany'][$prop]);

                $first = $dbName;
                $second = $arr['database'];
                if(strcmp($first, $second)>0){$aux = $first;$first = $second;$second = $aux;}
                
                $shortName=$first[0].$second[0];
                $str.="JOIN '{$first}_{$second}' ".$shortName;
                $str.=" ".$this->syntax['JOIN']." {$shortName}.{$arr['database']}ID={$arr['database']}.id ";
                $str.="JOIN '{$dbName}' ".$prop;
                $str.=" ".$this->syntax['JOIN']." {$shortName}.{$prop}ID={$prop}.id ";
            }
            if(!empty($join['oneTomany'])){
                
            }
        }
        $str.=" ";
        return $str;
    }
    private function buildQuery(){
        $this->getForeignKeyUser();
        // $this->getOneToMany();
        $this->getManyToMany();
        $query = "";
        print($this->select($this->sql['select']));
        // foreach($this->sql as $key=>$value){
        //     // $query.=$this->key($value); 
        // }
        return $query;
    }
}

