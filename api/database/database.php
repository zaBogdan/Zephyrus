<?php
namespace Api\Database;

class Database{
    public $connection;

    public function __construct(){
        $this->connect_to_db();
    }

    private function connect_to_db(){
        global $sensitive;
        if(!$sensitive->env['DATABASE_HOST'])
            return "The app isn't yet installed!";
        $this->connection = new \mysqli(
            $sensitive->env['DATABASE_HOST'],
            $sensitive->env['DATABASE_USERNAME'],
            $sensitive->env['DATABASE_PASSWORD'],
            $sensitive->env['DATABASE_NAME'],
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

    // run in the installation process
    public function create_tables(){
        $lines = file_get_contents(ROOT_DIR."/admin/install/database.sql");
        $lines = explode("\n", $lines);
        $comand = '';
        foreach($lines as $line){
            $line = trim($line);
            if($line && !$this->startsWith($line,'--'))
                $comand .= $line."\n";
        }
        $commands = explode(";",$comand);
        $total = $success = 0;
        foreach($commands as $com){
            if(trim($com)){
                $success +=($this->query($com)==false? 0:1);
                $total++;
            }
        }
        return ($success === $total);
    }

    private function startsWith($string, $file){
        $len = strlen($file);
        return (substr($string, 0, $len)===$file);
    }

}