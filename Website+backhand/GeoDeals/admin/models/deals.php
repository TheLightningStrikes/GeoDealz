<?php

class deals_model extends Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function GetDealsForUser()
	{
		$user_id = Session::get("User")->GetId();
		
		
		$query = $this->database->prepare("SELECT id, naam, deal, omschrijving, type FROM tbldeal WHERE user_id = :user_id;");
        $query->execute(array(':user_id' => $user_id));
							  
		return $query->fetchAll();
	}
	
	function GetDealByID($id)
	{
		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("SELECT id, naam, deal, omschrijving, type FROM tbldeal WHERE user_id = :user_id AND id = :id;");
        $query->execute(array(':user_id' => $user_id, 
								':id' => $id));
							  
		return $query->fetchAll();
	}

	function GetDateDealByID($id)
	{
		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("SELECT d.id as deal_id, d.naam as deal_naam, d.omschrijving as omschrijving, d.deal as deal_image, d.type as deal_type, dd.startdatum as startdatum, dd.einddatum as einddatum FROM tbldeal d
											INNER JOIN tbldealdatum dd ON d.id = dd.deal_id 
											WHERE user_id = :user_id AND d.id = :id;");
        $query->execute(array(':user_id' => $user_id, 
								':id' => $id));
							  
		return $query->fetchAll();
	}
	
	
	function GetLimitedDealByID($id)
	{
		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("SELECT d.id as deal_id, d.naam as deal_naam, d.omschrijving as omschrijving, d.deal as deal_image, d.type as deal_type, dd.amount as amount FROM tbldeal d
											INNER JOIN tbldeallimited dd ON d.id = dd.deal_id 
											WHERE user_id = :user_id AND d.id = :id;");
        $query->execute(array(':user_id' => $user_id, 
								':id' => $id));
							  
		return $query->fetchAll();
	}
	
	
	function save_normal($data)
	{
		$user_id = Session::get("User")->GetId();
		
		$deal = $data['image'];
		$naam = $data['naam'];
		$type = $data['dealtype'];
		$omschrijving = $data['omschrijving'];
		
		$query = $this->database->prepare("INSERT INTO tbldeal (naam, deal, omschrijving, user_id, type) VALUES (:naam, :deal, :omschrijving, :user_id, :type);");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':user_id' => $user_id,
							  ':type' => $type));
	}
	
	function save_date($data)
	{
		$user_id = Session::get("User")->GetId();
		
		$deal = $data['image'];
		$naam = $data['naam'];
		$type = $data['dealtype'];
		$omschrijving = $data['omschrijving'];
		
		$startdate = date("Y-m-d",strtotime($data['startdatum']));
		$einddate = date("Y-m-d",strtotime($data['einddatum'])); 
				
		$query = $this->database->prepare("INSERT INTO tbldeal (naam, deal, omschrijving, user_id, type) VALUES (:naam, :deal, :omschrijving, :user_id, :type);");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':user_id' => $user_id,
							  ':type' => $type));
				
		$id = $this->database->lastInsertId(); 
				
		$datedeal = $this->database->prepare("INSERT INTO tbldealdatum (startdatum, einddatum, deal_id) VALUES (:startdatum, :einddatum, :id);");
		$datedeal->execute(array(':startdatum' => $startdate,
								 ':einddatum' => $einddate,
								 ':id' => $id));
	}
	
	function save_limited($data)
	{
		$user_id = Session::get("User")->GetId();
		
		$deal = $data['image'];
		$naam = $data['naam'];
		$type = $data['dealtype'];
		$omschrijving = $data['omschrijving'];
		
		$limit = $data['limit'];
						
		$query = $this->database->prepare("INSERT INTO tbldeal (naam, deal, omschrijving, user_id, type) VALUES (:naam, :deal, :omschrijving, :user_id, :type);");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':user_id' => $user_id,
							  ':type' => $type));
				
		$id = $this->database->lastInsertId(); 
				
		$limitdeal = $this->database->prepare("INSERT INTO tbldeallimited (amount, deal_id) VALUES (:limit, :deal_id);");
				
		$limitdeal->execute(array(':limit' => $limit,
								  ':deal_id' => $id));
	}
	
	function update_normal($data)
	{	
		$deal = $data['image'];
		$naam = $data['naam'];
		$omschrijving = $data['omschrijving'];
		
		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("UPDATE tbldeal SET naam = :naam, deal = :deal, omschrijving = :omschrijving
											WHERE id = :id AND user_id = :user_id");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':user_id' => $user_id,
							  ':id' => $data['id']));
	}
	
	function update_date($data)
	{	
		$id = $data['id'];
		$deal = $data['image'];
		$naam = $data['naam'];
		$omschrijving = $data['omschrijving'];
		
		$startdate = date("Y-m-d",strtotime($data['startdatum']));
		$einddate = date("Y-m-d",strtotime($data['einddatum'])); 
		
		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("UPDATE tbldeal SET naam = :naam, deal = :deal, omschrijving = :omschrijving
											WHERE id = :id AND user_id = :user_id");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':user_id' => $user_id,
							  ':id' => $id));

		$dateQuery = $this->database->prepare("UPDATE tbldealdatum SET startdatum = :startdatum, einddatum = :einddatum 
											   WHERE deal_id = :deal_id");
		$dateQuery->execute(array(':startdatum' => $startdate,
								  ':einddatum' => $einddate,
								  ':deal_id' => $id));
	}
	
	function update_limited($data)
	{	
		$id = $data['id'];
		$deal = $data['image'];
		$naam = $data['naam'];
		$omschrijving = $data['omschrijving'];
		
		$limit = $data['limit'];

		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("UPDATE tbldeal SET naam = :naam, deal = :deal, omschrijving = :omschrijving
											WHERE id = :id AND user_id = :user_id");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':user_id' => $user_id,
							  ':id' => $id));
						
		$limitQuery = $this->database->prepare("UPDATE tbldeallimited SET amount = :amount
											   WHERE deal_id = :deal_id");
											   
		$limitQuery->execute(array(':amount' => $limit,
								   ':deal_id' => $id));
	}
	
	function delete($id)
	{
		$query = $this->database->prepare("DELETE FROM tbldeal WHERE id = :id");
		$query->execute(array(':id' => $id));
	}
}