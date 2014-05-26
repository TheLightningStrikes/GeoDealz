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
		
		
		
		if(!User::isAuthenticated(1))
		{
			$function = "login";
			$args = null;
		}
		switch($function)
		{
			
			case "edit":
				$this->edit($args);
				break;
			case "edit_date":
				$this->edit_date($args);
				break;
			case "edit_limited":
				$this->edit_limited($args);
				break;
			case "edit_location":
				$this->edit_location($args);
				break;
			case "save_normal":
				$this->save_normal();
				break;
			case "save_date":
				$this->save_date();
				break;
			case "save_limited":
				$this->save_limited();
				break;
			case "save_location":
				$this->save_location();
				break;
			case "login":
				$this->view->render("Login/index");
				break;
			case "new_normal":
				$this->new_normal_deal();
				break;
			case "normal_image_error":
				$this->view->msg = "Het plaatje wat u probeerd te uploaden is te groot.\n Probeer een kleiner plaatje";
				$this->new_normal_deal();
				break;
			case "update_normal":
				$this->update_normal();
				break;
			case "update_date":
				$this->update_date();
				break;
			case "update_limited":
				$this->update_limited();
				break;
			case "update_location":
				$this->update_location();
				break;
			case "delete":
				$this->delete($args);
				break;
			case "new_date":
				$this->new_date_deal();
				break;
			case "new_limited":
				$this->new_limited_deal();
				break;
			case "new_location":
				$this->new_location_deal();
				break;
			default:
				$this->loadDeals();
				break;
		}
	}
	
	function loadModel()
    {
        require 'models/'. __CLASS__ . '.php';  
        $this->model = new deals_model();
    }
	
	function loadDeals()
	{
		$this->view->data = $this->model->GetDealsForUser();
		$this->view->render(__class__ . '/index'); 
	}
	
	function new_normal_deal()
	{
		$this->view->render(__CLASS__ .'/normal/new');
	}
	
	function new_date_deal()
	{
		$this->view->render(__CLASS__ .'/date/new');
	}
	
	function new_location_deal()
	{
		$this->view->render(__CLASS__ .'/location/new');
	}
	
	function new_limited_deal()
	{
		$this->view->render(__CLASS__ .'/limited/new');
	}
	
	function prepareSaveData()
	{
		$data = $_POST;
		$data['image'] = ImageHelper::uploadToFolder($_FILES['deal']);
	
		if(substr($data['image'], 0, 5) == "Oops!")
		{
			Header("Location:" . URL . "deals/normal_image_error");
			return;
		}
		if($data['image']== "Never Used")
		{
			$data['image'] = $_POST['image_url'];
		}
		return $data;
	}
	
	function save_normal()
	{
		$data = $this->prepareSaveData();
		$this->model->save_normal($data);
		Header("Location:" . URL . "deals");
	}
	
	function save_date()
	{
		$data = $this->prepareSaveData();
		$this->model->save_date($data);
		Header("Location:" . URL . "deals");
	}
		
	function save_limited()
	{
		$data = $this->prepareSaveData();
		$this->model->save_limited($data);
		Header("Location:" . URL . "deals");
	}
		
	function save_location()
	{
		$data = $this->prepareSaveData();
		$this->model->save_location($data);
		Header("Location:" . URL . "deals");
	}	
		
	function update_normal()
	{
		$data = $this->prepareSaveData();
		$this->model->update_normal($data);
		Header("Location:" . URL . "deals");
	}	
	
	function update_date()
	{
		$data = $this->prepareSaveData();
		$this->model->update_date($data);
		Header("Location:" . URL . "deals");
	}
	
	function update_limited()
	{
		$data = $this->prepareSaveData();
		$this->model->update_limited($data);
		Header("Location:" . URL . "deals");
	}
	
	function update_location()
	{
		$data = $this->prepareSaveData();
		$this->model->update_location($data);
		Header("Location:" . URL . "deals");
	}
	function edit($args)
	{
		$data = $this->model->GetDealByID($args[0]);
		
		$this->view->id = $data[0]['id'];
		$this->view->naam = $data[0]['naam'];
		$this->view->deal= $data[0]['deal'];	
		$this->view->omschrijving = $data[0]['omschrijving'];
	
		$this->view->render(__CLASS__ .'/normal/edit');
	}
	
	function edit_date($args)
	{
		$data = $this->model->GetDateDealByID($args[0]);
		
		$this->view->id = $data[0]['deal_id'];
		$this->view->naam = $data[0]['deal_naam'];
		$this->view->deal = $data[0]['deal_image'];
		$this->view->omschrijving = $data[0]['omschrijving'];
		$this->view->startdatum = $data[0]['startdatum'];
		$this->view->einddatum = $data[0]['einddatum'];
		
		$this->view->render(__CLASS__ .'/date/edit');
	}
	
	function edit_limited($args)
	{
		$data = $this->model->GetLimitedDealByID($args[0]);
		
		$this->view->id = $data[0]['deal_id'];
		$this->view->naam = $data[0]['deal_naam'];
		$this->view->deal = $data[0]['deal_image'];
		$this->view->omschrijving = $data[0]['omschrijving'];
		$this->view->limit = $data[0]['amount'];
		
		$this->view->render(__CLASS__ .'/limited/edit');
	}
	
	function edit_location($args)
	{
		$data = $this->model->GetLocationDealByID($args[0]);
		
		$this->view->id = $data[0]['deal_id'];
		$this->view->naam = $data[0]['deal_naam'];
		$this->view->deal = $data[0]['deal_image'];
		$this->view->omschrijving = $data[0]['omschrijving'];
		$this->view->x = $data[0]['x'];
		$this->view->y = $data[0]['y'];
		
		$this->view->render(__CLASS__ .'/location/edit');
	}
	
	function delete($args)
	{
		
		if(isset($args) && !empty($args))
		{
			$id = $args[0];
			$this->model->delete($id);
			
		}
		Header("Location:" . URL . "deals");
	}
}	
	