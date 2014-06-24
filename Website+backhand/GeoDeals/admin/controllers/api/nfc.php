<?php

class Nfc extends Controller
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
			default:
				$this->GetMarkers();
				break;
		}
	}
	
	function loadModel()
	{
		require 'models/nfcmap.php';  
        $this->model = new nfcmap_model();
	}
	
	function GetMarkers()
	{
		$markers = $this->model->GetAllMarkers();
		
		if($markers == null)
		{
			$this->error("No markers Found");
			return;
		}
		print(json_encode($markers));
	}
	
	function error($error)
	{
		 $var = array("error" => $error );
		 
		 print(json_encode($var));
	}
}