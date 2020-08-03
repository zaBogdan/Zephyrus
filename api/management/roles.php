<?php

namespace Api\Management;

class Roles extends \Api\Database\DbModel{
    protected static $db_table = "roles";
    protected static $db_fields = array('id', 'name', 'permissions_list','decorations');

    public $id;
    public $name;
    public $permissions_list;
    public $decorations;

    public function createRole($name, $permissions_list, $decorations, $ancestor = NULL){   
        $this->name = $name;
        $this->decorations = json_encode($decorations);
        if(isset($ancestor)){
            $ancestor = self::find_by_attribute("name", $ancestor);
            $perms =  json_decode($ancestor->permissions_list);
            foreach($perms as $perm){
                if(!in_array($perm, $permissions_list)){
                  array_push($permissions_list, $perm);  
                }
            }
        }
        $this->permissions_list = json_encode($permissions_list);
        if($this->save_to_db())
            return true;
        return false;
    }

    public function hasPermission($user, $permissionNeeded){
        /**
         * Checking if the dataset is right
         */
        if(empty($user->data))
            return false;

        /**
         * Handling the data
         */
        if(self::isJson($user->data))
            $user->data = json_decode($user->data);

        /**
         * Checking for permission
         */
        $role = $user->data->role;
        $special_perms = $user->data->special_perms;

        /**
         * Getting all users permissions
         */
        $role = self::find_by_attribute("name", $role);
        if(self::isJson($role->permissions_list))
            $role->permissions_list = json_decode($role->permissions_list);
        
        //Role permissions
        $permissions = $role->permissions_list;
        
        //User permissions
        if(!empty($special_perms))
            $permissions = array_merge($permissions, $special_perms);
        
        $permissions = Permissions::getRolePermissions($permissions);
        /**
         * Final check
         */
        foreach($permissions as $perm){
            if($perm->name === $permissionNeeded)
                return true;
        }
        return false;
    }

    private static function isJson($string) {
        if(!is_string($string))
            return false;
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }
}