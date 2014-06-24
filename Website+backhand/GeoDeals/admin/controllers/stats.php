<?php

class stats extends Controller
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
			$this->view->render("Login/index");
			return;
		}
		else
		{
			$user_type = Session::get("User")->GetType();
		}
		
		if($user_type == "bedrijf"){
			switch($function)
			{
				default:
					$this->GetRatings();
				    break;
			}
		}
		else
		{
			Header("Location:" . URL . "index");		
		}
	}
	
	function loadModel()
    {
        require 'models/'. __CLASS__ . '.php';  
        $this->model = new stats_model();
    }
	
	function GetRatings()
	{
		$this->view->global_rating  = $this->model->GetTotalRating()[0]['global_avg'];
		$this->view->ratings = $this->model->GetRatings();
		$this->view->render(__class__ . '/index'); 
	}
}