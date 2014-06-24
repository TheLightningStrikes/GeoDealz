<?php

class deals extends Controller
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
			case "deal":
				$this->GetDeal($args);
			case "location":
				$this->GetAllLocationDeals();
				break;
			case "evenement":
				$this->GetBedrijfsDeals($args);
				break;
			case "used":
				$id = (empty($args[0]))? "-1":$args[0];
				$key = (empty($args[1]))?"nee": $args[1];
				
				$this->model->used($id, $key);
				break;
			case "rate":
				$rating  = (empty($args[0]))? "-1":$args[0];
				$deal_id = (empty($args[1]))? "-1":$args[1];
				
				
					if($rating != "-1" && $deal_id != "-1")
					{
						$this->model->rating($rating, $deal_id);
					}
					else
					{
						$this->error("Not saved");
					}	
				
				
			
				break;	
			default:
				$this->error("No Data");
				break;
		}
	}
	
	function loadModel()
	{
		require 'models/'. __CLASS__ . '.php';  
        $this->model = new deals_model();
	}
	
	function GetDeal($args)
	{
		if($args[0] == "" || $args[0] == null)
		{
			$this->error("No ID given");
			return;
		}
		
		$deals = $this->model->GetDeal($args[0]);
		
		if($deals == null)
		{
			$this->error("No Data");
			return;
		}
		print(json_encode($deals));
	}
	
	function GetBedrijfsDeals($args)
	{
		if($args[0] == "" || $args[0] == null)
		{
			$this->error("No Event ID given");
			return;
		}
		
		$deals = $this->model->GetDealsForEvenementById($args[0]);
		
		if($deals == null)
		{
			$this->error("No Data");
			return;
		}
		
		print(json_encode($deals));
	}
	
	function GetAllLocationDeals()
	{
		$deals = $this->model->GetAllDealsForLocationDeals();
		
		if($deals == null)
		{
			$this->error("No Data");
			return;
		}
		
		print(json_encode($deals));
	}
	
	function error($error)
	{
		 $var = array("error" => $error );
		 
		 print(json_encode($var));

	}
}