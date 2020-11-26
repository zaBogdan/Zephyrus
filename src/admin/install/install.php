<?php
require_once(__DIR__.'/../../api/init.php');

function create_env_file(Array $vars){
    $response = array();
    $msg = "<i>Core:</i> Setup process started.";
    array_push($response, $msg);

    // Creating the env file.
    $msg = "<i>Files:</i> Creating the enviorment file.";
    array_push($response, $msg);
    $vars['CORE_RUN_SCRIPT']=1;
    $string = \Api\Misc\Sensitive::create_env($vars);
    try{
        file_put_contents(ROOT_DIR."/.env", $string);
    }catch (Exception $e){
        die("<i>Core:</i> I can't write in the specific directory");
    }
    $msg = "<i>Files:</i> Enviorment file created successfully.";
    array_push($response, $msg);
    $msg = "<i>Core:</i> Please wait. I will redirect you to next stage in 3 seconds.";
    array_push($response, $msg);
    header("Refresh:3");
    return $response;
}


function install_application(){
    header_remove("Refresh");
    $response = array();
    //Checking connection to the database.
    $msg = "<i>Database:</i> Checking connection and verifying credentials.";
    array_push($response, $msg);
    try{
        $db = new \Api\Database\Database();
    }catch (Exception $e){
        die("<i>Database:</i> Failed to connect to the Database or credentials are wrong!");
    }

    //Creating tables.
    $msg = "<i>Database:</i> Tests passed! Populating the database.";
    array_push($response, $msg);
    try{
        if($db->create_tables()==true)
            $msg = "<i>Database:</i> Database populated.";
        else $msg = "<i>Database:</i> Invalid sql file!";
        array_push($response, $msg);
        
    }catch(Exception $e){
        die("<i>Database:</i> Invalid sql file!");
    }
    
    //Creating the storage folder
    $msg = "<i>FileSystem:</i> Checking the permissions.";
    array_push($response, $msg);
    try{
        $string = "Please don't let me down :(";
        file_put_contents(ROOT_DIR."/doodle.me", $string);
        if(strcmp(file_get_contents(ROOT_DIR."/doodle.me"),$string)==0)
            $msg = "<i>FileSystem:</i> You have the right permissions! Going forward.";
        else $msg = "<i>FileSystem:</i> Please set the permissions for '".ROOT_DIR."' directory to 755."; 
        unlink(ROOT_DIR."/doodle.me");
    }catch(Exception $e){
        $msg = "<i>FileSystem:</i> Please set the permissions for '".ROOT_DIR."' directory to 755.";
    }
    array_push($response, $msg);

    try{
        $path = ROOT_DIR."/storage";
        if(file_exists($path)){
            if(is_dir($path))
                rmdir($path);
            else if(is_file($path))
                unlink($path);
        }
        
        mkdir($path, 0755);
        mkdir($path."/posts", 0755);
        $msg = "<i>FileSystem:</i> Storage folder has been created!";
    }catch(Exception $e){
        $msg = "<i>FileSystem:</i> You don't have the right permissions!";
    }
    array_push($response, $msg);

    /**
     * If there are other steps needed please add them below.
    */

    //some code here...

    /**
     * Changing the stage to 2. The last one. 
     */
    
    $vars = \Api\Misc\Sensitive::read_env();
    $vars['CORE_RUN_SCRIPT']=2;
    $string = \Api\Misc\Sensitive::create_env($vars);
    try{
        file_put_contents(ROOT_DIR."/.env", $string);
    }catch (Exception $e){
        die("<i>Core:</i> I can't write in the specific directory");
    }
    header("Refresh:2");
    return $response;
}