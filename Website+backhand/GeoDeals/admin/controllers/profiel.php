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
			case 'image_error':
                $this->view->msg = "Het plaatje wat u probeerd te uploaden is te groot.\n Probeer een kleiner plaatje";
                $this->loadProfiel();
			break;
			case "login":
				$this->view->render("Login/index");
			break;
			default:
			$this->loadProfiel();
		}
	}
	
	function loadModel()
    {
        require 'models/'. __CLASS__ . '.php';  
        $this->model = new profiel_model();
    }
	
	function loadProfiel()
	{
		$this->view->id = null;
		$this->view->logo = null;
		$this->view->naam = null;
		$this->view->beschrijving = null;
		$this->view->opmerking = null;
		
		$profiel = $this->model->GetProfiel();
	
		if(isset($profiel))
		{
			$this->view->id = $profiel[0]['id'];
			$this->view->logo = $profiel[0]['logo'];
			$this->view->naam = $profiel[0]['naam'];;
			$this->view->beschrijving = $profiel[0]['beschrijving'];
			$this->view->opmerking = $profiel[0]['opmerkingen'];
		}
		$this->view->render(__class__ . '/index'); 
	}
	
	function save()
	{
		$data = $_POST;
		$data['image'] = ImageHelper::uploadToFolder($_FILES['logo']);
	
		if(substr($data['image'], 0, 5) == "Oops!")
		{
			Header("Location:" . URL . "profiel\image_error");
			return;
		}
		if($data['image']== "Never Used")
		{
			$data['image'] = $_POST['image_url'];
		}
		
		if(!empty($data['profiel_id']))
		{
			$this->model->Update($data);		
		}
		else
		{
			$this->model->save($data);		
		}
		
		Header("Location:" . URL . "profiel");
	}
}	
	