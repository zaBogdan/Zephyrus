<?php
require_once(__DIR__.'/../../api/init.php');

function install_application(Array $vars){
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

    //
    


    return $response;
}