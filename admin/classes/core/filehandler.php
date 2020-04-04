<?php

namespace Core;

class FileHandler{

    private static $location = 'storage/';
    private static $banned = array(".", "..", ".htaccess");
    protected static $allowed_files = array('image/png', 'image/jpeg','image/gif');
    protected static $allowed_size = 1024*1024*10; #10mb

    #print all files from storage directory. No user input allowed.
    public static function getAllFiles($dir=NULL,&$results=NULL){
        if(empty($dir))
            $dir=ROOT_DIR.self::$location;
        $files = scandir($dir);
        foreach($files as $key => $value){
            $path = realpath($dir.'/'.$value);
            if(!in_array($value, self::$banned)){
                if(!is_dir($path))
                    $results[]=$path;
                else
                    self::getAllFiles($path, $results);
            }
        }
        if(!empty($results))
            $results = self::removeFullPath($results);
        return $results;
    }

    #upload a file
    public static function upload_file(String $user,Array $file){
        #THIS CHECK IS CRITICAL!.
        $security = self::secure($file);
        if($security)
            return $security;
        $path = ROOT_DIR.self::$location.$user;
        if(!file_exists($path))
            mkdir($path,0777, true);
        $name = self::create_name($file['name']);
        $path .='/'.$name;
        if(move_uploaded_file($file['tmp_name'],$path))
            return $path;
        return false;
    }

    public static function delete_directory($user){
        $dir = ROOT_DIR.self::$location.$user;
        if(is_dir($dir)){
            $files = array_diff(scandir($dir), array('.','..'));
            foreach ($files as $file) {
              (is_dir("$dir/$file")) ? delete_directory("$dir/$file") : unlink("$dir/$file");
            }
            if(rmdir($dir))
                return true;
            return "Couldn't remove the directory";
        }
        return "This directory doesn't exists";
    }

    public static function delete_file(String $user,String $name){
        if(unlink(ROOT_DIR.self::$location.$user.'/'.$name))
            return "File deleted!";
        return "Couldn't delete the file!";
    }




    public static function removeFullPath(Array $results){
        $resp = array();
        foreach($results as $result)
        $resp[] = str_replace(ROOT_DIR,'../',$result);

        return $resp;
    }

    #need to know a token to get the file name, another layer of security
    private static function create_name(String $name){
        $file = explode('.',$name);
        $name2 = TokenAuth::generateToken(4);
        for($i=0;$i<count($file)-1;$i++)
            $name2 .= $file[$i];
        return md5($name2).'.'.$file[count($file)-1];
    }

    #just another layer of security to file uploads.
    private static function secure(Array $file){
        if(empty($file) || !$file || !is_array($file))
            return "You haven't uploaded any files.";
        if($file['error']!=0)
            return "There is an error with the file upload.";
        if($file['size']> self::$allowed_size)
            return "Your file exceed the upload limit. It's only 10 MB (megabytes).";
        if(!in_array($file['type'], self::$allowed_files))
            return "Your file can be only: JPEG, PNG, GIF";
        return false;
    }
}