<?php
/**
* 
*/
class login_model extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function checkLogin()
    {
        $data = $_POST;
        $username = $_POST['username'];
        $password = $_POST['password'];
        		
        $query = $this->database->prepare("SELECT * FROM tbluser WHERE name = :username AND password = MD5(:password)");
        $query->execute(array(':username' => $username,
                              ':password' => $password));
              
        $count =  $query->rowCount();
		
        if($count > 0)
        {
            return $query->fetchAll();
        }
        else
        {
            return false;
        }
    }
}