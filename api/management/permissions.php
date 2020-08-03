<?php

namespace Api\Management;

class Permissions extends \Api\Database\DbModel{
    protected static $db_table = "permissions";
    protected static $db_fields = array('id', 'name', 'description');

    public $id;
    public $name;
    public $description;


    public function createPermission($name, $description){
        $this->name = $name;
        $this->description = $description;
        
        if($this->save_to_db())
            return true;
        return false;
    }

    public function createMultiplePermissions(Array $perms){
        foreach($perms as $name => $description){
            $this->name = $name;
            $this->description = $description;
            if(!$this->save_to_db())
                die("There was an error while trying to add ".$name." permission to the database");     
        }
        return true;
    }

    public static function getPermissionByName($name){
        $permission = self::find_by_attribute("name", $name);
        return !empty($permission) ? $permission : false;
    }
    
    public static function getPermissionById($id){
        $permission = self::find_by_attribute("id", $id);
        return !empty($permission) ? $permission : false;
    }

    public static function getRolePermissions(Array $ids){
        $perms = array();
        foreach($ids as $id){
            $perm = self::getPermissionById($id);
            if(!$perm)
                return false;
            array_push($perms, $perm);
        }
        return $perms;
    }
}