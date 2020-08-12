<?php

namespace Api\Management;

class Roles extends \Api\Database\DbModel{
    protected static $db_table = "roles";
    protected static $db_fields = array('id', 'name', 'permissions_list','decorations');
    protected static $hierarchy = array('Founder','Administrator','Moderator','TrustedUser','User','Guest');

    public $id;
    public $name;
    public $permissions_list;
    public $decorations;

    public function createRole($name, $permissions_list, $decorations, $ancestor = NULL){   
        $this->name = $name;
        if(isset($ancestor)){
            $ancestor = self::find_by_attribute("name", $ancestor);
            foreach($perms as $perm){
                if(!in_array($perm, $permissions_list)){
                  array_push($permissions_list, $perm);  
                }
            }
        }
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
         * Checking for permission
         */
        $role = $user->data->role;
        $special_perms = $user->data->special_perms;

        /**
         * Getting all users permissions
         */
        $role = self::find_by_attribute("name", $role);
        
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
    
    public static function addPermission(String $name,Array $permissions){
        $role = self::find_by_attribute("name", $name);
        $perms = array();
        foreach($permissions as $perm){
            $work = \Api\Management\Permissions::getPermissionByName($perm);
            if(!$work){
                $work = \Api\Management\Permissions::getPermissionById($perm);
                if(!$work)
                    return $perm." this permission doesn't exist in our database!";
            }
            array_push($perms, (int)$work->id);
        }
        foreach($perms as $perm){
            if(!in_array($perm, $role->permissions_list)){
              array_push($role->permissions_list, $perm);  
            }
        }
        if(!$role->save_to_db())
            return false;
        return true;
    }
    public static function canEditUserRole(String $firstRole,String $secondRole){
        /**
         * User logged vs foreign User
         */
        
        return (array_keys(self::$hierarchy, $firstRole, true) <= array_keys(self::$hierarchy, $secondRole, true));
    }
    public static function inheritPermissions(String $firstRole, String $secondRole){
        $secondRole = self::find_by_attribute("name", $secondRole);
        /**
         * First role get the second role permissions!
         */
        return self::addPermission($firstRole, $secondRole->permissions_list);
    }
    public static function requiresAdministrative($roleName){
        $role = self::find_by_attribute("name", $roleName);
        return $role->decorations->administrative;
    }

    public static function getRolePermissions(String $name){
        $role = self::find_by_attribute("name", $name);
        return Permissions::getRolePermissions($role->permissions_list);
    }
}