<?php


class Database{
    protected $file = '/admin/database.sql';
    public $connection;

    public function __construct(){
        $this->connect_to_db();

        $tempLine = '';
        $lines = file(ROOT_DIR.$this->file);
        foreach($lines as $line){
            //Skip if line is  a comment
            if(substr($line, 0,2)=='--' || $line='')
                continue;

            $tempLine .= $line;
            if(substr(trim($line),-1,1)==';'){
                $this->query($tempLine) or print(
                    "Error performing query <strong>".$tempLine.
                    " Mysql error:".$this->connection->error."</strong> <br /><br />"
                    );
                $tempLine='';
            }
        }
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