<?php

class createDeal extends Controller
{
	function __construct($args=array())
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
		if(!User::isAuthenticated(1))
		{
			$function = "login";
			$args = null;
		}
		switch($function)
		{
			case "save":
				$this->save();
				break;
			case "login":
				$this->view->render("Login/index");
			break;
			default:
			$this->loadCreateDeal();
		}
	}
	
	function loadModel()
    {
        /*require 'models/'. __CLASS__ . '.php';  
        $this->model = new index_model();*/
    }
	
	function loadCreateDeal()
	{
		$this->view->dealnaam = "-";
		$this->view->actie = "-";
		$this->view->opmerkingen = "-";
		$this->view->logo = "";
		$this->view->render(__class__ . '/index'); 
	}
	
	function save()
	{
		/*opslaan van het profiel via database*/
		Header("Location:" . URL . "createDeal");
	}
}	
	