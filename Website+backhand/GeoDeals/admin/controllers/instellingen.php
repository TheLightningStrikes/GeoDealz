<?php

require 'libs/FormHelper.php';

class instellingen extends Controller
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
		
		if(!User::isAuthenticated(1))
		{
			$function = "login";
			$args = null;
		}
            
        switch ($function)
        {
			case "index":
				$this->ShowAllSettings();
			break;				
			case "update":
				$this->updateContent();
			break;
			case "login":
				$this->view->render("Login/index");
			break;
            default:
				$this->view->render("error/index");
            break;
        }
    }
	
	function loadModel()
    {
        require 'models/'. __CLASS__ . '.php';  
        $this->model = new instellingen_model();
    }
	
	function updatecontent()
	{
		$queryList = "";
		foreach($_POST as $key => $value) 
		{
			$queryList.= "UPDATE tblinstellingen i SET i.value = '" . $value . "' WHERE i.key = '" .$key . "'; ";
		}		
		$this->model->UpdateQueries($queryList);
		
		Header("Location:" . URL . "instellingen/index");
	}
	
	function ShowAllSettings()
	{
		$settings = $this->model->GetAllSettings();
		$output = "";
		foreach($settings as $setting)
		{
			switch ($setting['type'])
			{
				case "text":
					$output .= FormHelper::DisplayTextField($setting['key'], $setting['value'], $setting['display']);
				break;
				case "checkbox":
					$output .= FormHelper::DisplayCheckboxField($setting['key'], $setting['value'], $setting['display']);
				break;
				default:
				break;
			}		
		}
		
		$this->view->output = $output;
		$this->view->render(__CLASS__ . "/index");
	}	
}