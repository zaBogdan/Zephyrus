<?php

namespace Core;

class FileHandler{

    private static $location = '/storage/';

    public static function getAllFiles($dir=NULL,&$results=NULL){
        if(empty($dir))
            $dir=ROOT_DIR.self::$location;
        $files = scandir($dir);
        foreach($files as $key => $value){
            $path = realpath($dir.'/'.$value);
            if(!is_dir($path)) {
                $results[] = $path;
            } else if($value != "." && $value != "..") {
                self::getAllFiles($path,$results);
                // $results[] = $path;
            }
        }
        if(!empty($results))
        $results = self::removeFullPath($results);
        else $results = array();
    
        return $results;
    }
    public static function upload_file(String $user,Array $file){
        if(empty($file) || !$file || !is_array($file))
            return "You haven't uploaded any files.";
        elseif($file['error']!=0)
            return "There is an error with the file upload.";
        else{
            $path = ROOT_DIR.self::$location.$user;
            if(!file_exists($path))
                mkdir($path,0777, true);
            $name = self::create_name($file['name']);
            $path .='/'.$name;

            if(file_exists($path))
                return $path;
            if(move_uploaded_file($file['tmp_name'],$path))
                return $path;
            return false;
        }
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
    private static function create_name(String $name){
        $sep = ' -/|~()';
        $name = strtolower($name);
        for($i=0;$i<strlen($name);$i++)
            if(strchr($sep,$name[$i])) $name[$i]='_';
        return $name;
    }

    public static function removeFullPath(Array $results){
        $resp = array();
        foreach($results as $result)
            $resp[] = str_replace(ROOT_DIR,'',$result);
        
        return $resp;
    }
}