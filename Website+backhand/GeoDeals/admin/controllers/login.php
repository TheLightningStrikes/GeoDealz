<?php
/**
* 
*/
class Login extends Controller
{	
    function __construct($args = array())
    {
        parent::__construct();
        $this->loadModel();

        $function = "";
        if(count($args) > 0)
        {
            $function = $args[0];
            if(count($args) > 1)
            {
                $args = array_splice($args, 1);
            }
        }
        switch ($function) {
            case 'checklogin':
                $this->checkLogin($args);
                break;
            case 'wronglogin':
                $this->view->msg = "U heeft verkeerde gegevens ingevuld";
                $this->view->render(__CLASS__ . "/index");
                break;
            case 'logout':
                Session::init();
                Session::set("isLoggedIn", false);
                Session::set("User", null);
                header("Location:" . URL);
                break;
            case 'registered':
                $this->view->msg = "Bedankt voor het registreren!\nU kan nu inloggen!";
                $this->view->render(__CLASS__ . "/index");
                break;
            default:
                $this->view->render(__CLASS__ . "/index");
                break;
        }
    }

    function loadModel()
    {
        require 'models/login.php';  
        $this->model = new login_model();
    }

    function checkLogin($args)
    {
		$user = $this->model->checkLogin();
        $oUser = null;      
        
		
		
        if(isset($user))
            $oUSer = new User($user[0]['id'], $user[0]['name'], $user[0]['password']);
        
        if($user){			
            Session::set("isLoggedIn", true); 
            Session::set("User", $oUSer);
            Header("Location:" . URL);
        }
        else
            Header("Location:" . URL . "login/wronglogin");
    }
}