<?php

namespace Api\Management;


class Categories extends \Api\Database\DbModel{
    protected static $db_table = "categories";
    protected static $db_fields = array('id', 'name', 'data');

    public $id;
    public $name;
    public $data;
    

    
    
}