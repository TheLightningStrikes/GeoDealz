<?php

class profiel extends Controller
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
		switch($function)
		{
			case "list":
				$this->ProfielList();
				break;
			case "profiel":
				$this->GetProfiel($args);
				break;
			default:
				$this->error("No Data");
				break;
		}
	}
	
	function loadModel()
	{
		require 'models/'. __CLASS__ . '.php';  
        $this->model = new profiel_model();
	}
	
	function ProfielList()
	{
		$profielen = $this->model->GetAllProfielen();
		
		if($profielen == null)
		{
			$this->error("No Profiels Found");
			return;
		}
		print(json_encode($profielen));
	}
	
	function GetProfiel($args)
	{	
		if($args[0] == "" || $args[0] == null)
		{
			$this->error("No Profiel ID given");
			return;
		}
		
		$profiel = $this->model->GetProfielByUserID($args[0]);
		
		if($profiel == null)
		{
			$this->error("No Profiel Found");
			return;
		}
		print(json_encode($profiel));
	}
	
	function error($error)
	{
		 $var = array("error" => $error );
		 
		 print(json_encode($var));
	}
}