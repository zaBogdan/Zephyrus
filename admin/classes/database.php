<?php


class Database{

    protected $db_name = "zaEngine"; //Database Name
    protected $db_username = "root"; //Database Username
    protected $db_password = ""; //Database password
    protected $db_host = "localhost"; //Database host

    public $connection;

    public function __construct(){
        $this->connect_to_db();
    }

    private function connect_to_db(){
        $this->connection = new mysqli($this->db_host, $this->db_username, $this->db_password, $this->db_name);

        if($this->connection->connect_errno)
            die("Failed to connecto to the Database! Error message: ".$this->connection->connect_errno);
        
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