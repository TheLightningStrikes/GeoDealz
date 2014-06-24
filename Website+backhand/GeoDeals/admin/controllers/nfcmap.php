<?php

class nfcmap extends Controller
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
			case "login":
				$this->view->render("Login/index");
				break;
			case "update":
				$this->update();
				break;
            default:
                 $this->loadMarkers();
            break;
        }
    }
	
	function loadModel()
    {
        require 'models/'. __CLASS__ . '.php';  
        $this->model = new nfcmap_model();
    }
	
	function update()
	{
		$markers = json_decode($_POST['markers'], true);
		
		
		
		$this->model->DeleteMarkersUser();
		foreach ($markers as $marker)
		{
			$data = array('x' => $marker['k'], 
						  'y' => $marker['A']);
						  
			$this->model->UpdateMarker($data);
		}
		
		Header("Location:" . URL . "nfcmap");
	}
	
	function loadMarkers()
	{
		$this->view->markers = $this->model->GetMarkers();	
		$this->view->render(__CLASS__  . '/index');
	}
}