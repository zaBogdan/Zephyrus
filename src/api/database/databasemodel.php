<?php 

namespace Api\Database;

class DatabaseModel extends \Api\Database\QueryBuilder{

    public function sendQuery($sql){
        echo "Submitting... ".$sql;
    }
}