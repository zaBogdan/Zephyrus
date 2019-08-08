<?php 


class DbModel{

    /**
     * Public functions:
     * -> find_all @return all data from the db
     * -> find_by_attribute @return the first user with that attribute ( username, id or uuid )
     * -> send_query @return an array of the class object with the required data
     * -> save_to_db 
     * -> delete
     */
    public static function find_all(){
        return static::send_query("SELECT * FROM ".static::$db_table);
    }

    public static function find_by_attribute(string $name, $data){
        global $db;
        $result = static::send_query("SELECT * FROM ".static::$db_table." WHERE ".$name."='{$db->escape_string($data)}' LIMIT 1");
        return !empty($result) ? array_shift($result) : false;
    }

    public static function send_query($query){
        global $db;
        $result = $db->query($query);
        if(empty($result)) return false;
        
        $obj = array();
        while($row = mysqli_fetch_assoc($result))
                //create an array of Class Inherited Objects
                $obj[] = static::build($row);
        return $obj;
    }
    
    public function save_to_db(){
        return isset($this->id) ? $this->update() : $this->create();
    }
    public function delete(){
        global $db;
        $sql = "DELETE FROM ".static::$db_table." WHERE id = ".$db->escape_string($this->id)." ";
        if(!$db->query($sql))
            return false;
    }


    /**
     * Private functions 
     */
    private static function build($row){
        $class = get_called_class();
        $obj = new $class;
        foreach($row as $key => $value)
            if($obj->has_prop($key)) $obj->$key = $value;
        return $obj;
    }

    protected function has_prop($key){
        return array_key_exists($key,get_object_vars($this));
    }
    protected function properties(){
        $props = array();
        foreach(static::$db_fields as $field)
            if(property_exists($this, $field))
                $props[$field] = $this->$field;
        return $props;

    }
    protected function clear_props(){
        global $db;
        $props = array();
        $mprops = $this->properties();
        foreach($mprops as $key => $value)
            $props[$key] = $db->escape_string($value);
        return $props;
    }
    private function create(){
        global $db;
        $props = $this->clear_props();
        $sql = "INSERT INTO ".static::$db_table."(".implode(",",array_keys($props)).") ";
        $sql.= "VALUES ('".implode(" ',' ", array_values($props))." ') ";
        if(!$db->query($sql))
            return false;
    }
    private function update(){
        global $db;
        $props = $this->clear_props();
        $ar = array();
        foreach($props as $key => $value)
            $ar[] = "$key = '$value'";
        $sql = "UPDATE ".static::$db_table." SET ".implode(",", $ar)." WHERE id=".$db->escape_string($this->id);
        if(!$db->query($sql))
            return false;
    }
}