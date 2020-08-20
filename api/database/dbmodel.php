<?php 

namespace Api\Database;

class DbModel{
    /**
     * Retrieve all the content from a specific table
     * @return array
     */
    public static function find_all(){
        return static::send_query("SELECT a.id AS '".static::$db_table."_id', a.* FROM ".static::$db_table." a");
    }

    /**
     * Retrieve the content from a specifiec table by an identifier.
     * @param String $name The identifier tag you want to search
     * @param $data The value which should be filtered by
     * @param $items=1 The amount of data you want
     * 
     * @return Array or Object depending on the limit.
     */
    public static function find_by_attribute(String $name, $data, $items = 1){
        global $db;
        /**
         * Building the querry
         */
        $sql = "SELECT a.id AS '".static::$db_table."_id', a.* FROM ".static::$db_table." a WHERE ".$name."='{$db->escape_string($data)}'";
        $items = $items == 0 ? null : $sql.="  LIMIT {$items}";
        $result = static::send_query($sql);
        /**
         * Handle the case if $result is not array
         */
        $result = is_array($result) && sizeof($result) >= 2 ? $result : array_shift($result); 

        return !empty($result) ? $result : false;
    }

    /**
     * Keeping this function until full deprecation
     * Will be deprecated in version 0.5
     */
    public static function find_all_by_attribute(string $name, $data){
        return self::find_by_attribute($name, $data, 0);
    }

    /**
     * Send a specific querry to the database. 
     * 
     * @param String $query the sql sequence that you want to send
     * @return Array
     */
    public static function send_query($query){
        global $db;
        $result = $db->query($query);
        if(empty($result)) return false;


        $data = array();
        while($row = mysqli_fetch_assoc($result))
            $data[] = static::parser($row);
        
        return $data;
    }
    
    /**
     * Handles the Create/Update functions 
     * @return Boolean either the querry succeded or not
     */
    public function save_to_db(){
        return isset($this->id) ? $this->update() : $this->create();
    }

    /**
     * Handles the Delete function
     * @return Boolean either the querry succeded or not
     */
    public function delete(){
        global $db;
        $sql = "DELETE FROM ".static::$db_table." WHERE id = ".$db->escape_string($this->id)." ";
        if(!$db->query($sql))
            return false;
    }

    /**
     * Checks if a string is JSON or not.
     * @return Boolean either the string is JSON format or not.
     */
    public static function isJson($string) {
        if(!is_string($string))
            return false;
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    /**
     * Private functions 
     */
    public static function parser($row){
        /**
         * Building the array
         */
        $array = array();
        $pos = 0;
        foreach($row as $key => $value){
            if (\strpos($key, '_id')) { 
                $name = "\Api\Management\\".\ucfirst(explode("_", $key)[0]);
                $array[$name]['id'] = $value;
                continue;
            }
            if(!array_key_exists($key, $array))
            $array[$name][$key] = $value;
        }
        return static::construct($array);
    }
    private static function construct(Array $array){
        $objects = array();
        foreach($array as $class => $data){
            $obj = new $class;
            foreach($data as $key => $value)
                if($obj->has_prop($key)){
                    if(static::isJson($value))
                        $value = json_decode($value);
                    $obj->$key = $value;
                }
            $objects[] = $obj;
        }
        return count($objects)>=2? $objects : array_shift($objects);
    }

    /**
     * Function is deprecated. 
     * No longer in use. I keep it just in case (until next commit)
     */
    private static function build($row){
        $class = get_called_class();
        $obj = new $class;
        foreach($row as $key => $value)
            if($obj->has_prop($key)){
                if(static::isJson($value))
                    $value = json_decode($value);
                $obj->$key = $value;
            }
        return $obj;
    }

    protected function has_prop($key){
        return array_key_exists($key,get_object_vars($this));
    }
    protected function properties(){
        $props = array();
        foreach(static::$db_fields as $field)
            if(property_exists($this, $field)){
                if(!empty($this->$field))
                    $props[$field] = $this->$field;
            }
        return $props;

    }
    protected function clear_props(){
        global $db;
        $props = array();
        $mprops = $this->properties();
        foreach($mprops as $key => $value){
            if(is_array($value) || is_object($value))
                $value = json_encode($value);
            $props[$key] = $db->escape_string($value);
        }
        return $props;
    }
    private function createLink($firstID, $secondID){
        global $db;
        $sql = "INSERT INTO ".static::$mtm_table." (";
        $sql.= implode(",", array_values(static::$mtm_fields)).") VALUES (NULL, '{$firstID}', '{$secondID}');";
        if(!$db->query($sql))
            return false;
        return true;
    }

    /**
     * This function must be implemented
     */
    private function updateLink($id, $firstID, $secondID){
        return null;
    }
    private function create(){
        global $db;
        $props = $this->clear_props();
        $sql = "INSERT INTO ".static::$db_table."(".implode(",",array_keys($props)).") ";
        $sql.= "VALUES ('".implode("','", array_values($props))."') ";
        if(!$db->query($sql))
            return false;
        if(isset(static::$mtm_table))
            if(!self::createLink($db->connection->insert_id, $this->foreignKey))
                return false;
        return true;
    }
    private function update(){
        global $db;
        $props = $this->clear_props();
        $ar = array();
        foreach($props as $key => $value)
            $ar[] = "$key='$value'";
        $sql = "UPDATE ".static::$db_table." SET ".implode(",", $ar)." WHERE id=".$db->escape_string($this->id);
        if(!$db->query($sql))
            return false;
        return true;
    }
}