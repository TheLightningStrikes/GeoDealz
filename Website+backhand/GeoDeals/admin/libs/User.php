<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class User{
    private $_id;
    private $_username;
    private $_password;
    
    public function GetId(){ return $this->_id; }
    public function GetUsername(){ return $this->_username; }
    
    function __construct($id, $name, $password)
    {
        $this->_id = $id;
        $this->_username = $name;
        $this->_password = $password;
    }
    
    public static function GetUsernameByID($id)
    {
        $database = new Database();
        $query = $database->prepare("SELECT usr_name FROM user WHERE usr_id = :id");
        $query->execute(array(':id' => $id));
        $result = $query->fetchAll();
        
        return $result[0]['usr_name'];
    }
    
    public static function isAuthenticated($rol_id = -1)
    {
        if(Session::get("isLoggedIn"))
        {
            if($rol_id == -1)
            {
                return true;
            }
			if($rol_id == 1)
            {
                return true;
            }
        }
        return false;        
    }
}
?>
