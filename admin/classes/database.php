<?php


class Database{

    public $connection;

    public function __construct(){
        $this->connect_to_db();
    }

    private function connect_to_db(){
        $this->connection = new mysqli(
            env('DATABASE_HOST'), 
            env('DATABASE_USERNAME'), 
            env('DATABASE_PASSWORD',''), 
            env('DATABASE_NAME')
        );

        if($this->connection->connect_errno)
            die("Failed to connect to the Database! Error message: ".$this->connection->connect_errno);
        
    }
    
    public function query(string $query){
        
        $result = $this->connection->query($query);

        return $result;
    }

    public function confirm_query($result){
        if(!$result)
            die("Querry failed! Error message: ".$this->connection->error);
    }
    public function escape_string($string){
        return $this->connection->real_escape_string($string);
    }

}