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
							  
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function GetDeal($id)
	{
		$query = $this->database->prepare("SELECT d.id as uid, p.naam as bedrijf, d.*, dl.*, dg.*, dd.* FROM geodealsadmin.tbldeal d
							LEFT JOIN tbldeallimited dl on d.id = dl.deal_id
							LEFT JOIN tbldeallocation dg on d.id = dg.deal_id
							LEFT JOIN tbldealdatum dd on d.id = dd.deal_id
							INNER JOIN tblprofiel p ON p.user_id = d.user_id
											WHERE d.id = :id");
											
		$query->execute(array(':id' => $id));
		
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
		
	function GetDealsForEvenement()
	{
		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("SELECT d.* FROM geodealsadmin.tbldeal d
										  INNER JOIN tblprofiel p on p.id = d.profiel_id
										  INNER JOIN tbluser u on u.id = p.user_id
										  WHERE d.status = :status
										  AND u.id =  :user_id;");
        $query->execute(array(':user_id' => $user_id,
							  ':status' => "submitted"));
							  
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}	
	
	function GetDealsForEvenementById($id)
	{
		$normals = $this->GetDealsForNormalDeals($id);
		$dates = $this->GetDealsForDatumDeals($id);
		$limited = $this->GetDealsForLimitedDeals($id);
		$locations = $this->GetDealsForLocationDeals($id);
			
		$output = array_merge($normals, $dates, $limited, $locations);
		
		return $output;
	}	
		
	function GetDealsForNormalDeals($id)
	{
		$query = $this->database->prepare("SELECT d.*, pb.naam as bedrijf FROM geodealsadmin.tbldeal d
										  INNER JOIN tblprofiel p on p.id = d.profiel_id
										  INNER JOIN tblprofiel pb on pb.user_id = d.user_id
										  INNER JOIN tbluser u on u.id = p.user_id
										  WHERE d.status = :status
										  AND d.type = 'normal'
										  AND u.id = :user_id");
        $query->execute(array(':status' => "approved",
							  ':user_id' => $id));
							  
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}		
	function GetDealsForDatumDeals($id)
	{
		$query = $this->database->prepare("SELECT d.*, dd.*, pb.naam as bedrijf FROM geodealsadmin.tbldeal d
										  INNER JOIN tbldealdatum dd on d.id = dd.deal_id
										  INNER JOIN tblprofiel p on p.id = d.profiel_id
										  INNER JOIN tblprofiel pb on pb.user_id = d.user_id
										  INNER JOIN tbluser u on u.id = p.user_id
										  WHERE d.status = :status
										  AND d.type = 'date'
										  AND u.id = :user_id
										  AND dd.startdatum <= CURDATE() AND dd.einddatum >= CURDATE();");
        $query->execute(array(':status' => "approved",
							  ':user_id' => $id));
							  
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}	
	function GetDealsForLimitedDeals($id)
	{
		$query = $this->database->prepare("SELECT d.*, dd.*, pb.naam as bedrijf FROM geodealsadmin.tbldeal d
									       INNER JOIN tbldeallimited dd on d.id = dd.deal_id
										   INNER JOIN tblprofiel p on p.id = d.profiel_id
										   INNER JOIN tblprofiel pb on pb.user_id = d.user_id
										   INNER JOIN tbluser u on u.id = p.user_id
										   WHERE d.status = :status
										   AND d.type = 'limited'
										   AND u.id = :user_id
										   AND dd.amountleft != 0;");
        $query->execute(array(':status' => "approved",
							  ':user_id' => $id));
							  
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function GetDealsForLocationDeals($id)
	{
		$query = $this->database->prepare("SELECT d.*, dd.*, pb.naam as bedrijf FROM geodealsadmin.tbldeal d
										   INNER JOIN tbldeallocation dd on d.id = dd.deal_id
										   INNER JOIN tblprofiel p on p.id = d.profiel_id
										   INNER JOIN tblprofiel pb on pb.user_id = d.user_id
										   INNER JOIN tbluser u on u.id = p.user_id
										   WHERE d.status = :status
										   AND d.type = 'location'
										   AND u.id = :user_id");
        $query->execute(array(':status' => "approved",
							  ':user_id' => $id));
							  
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}	
	
	function GetAllDealsForLocationDeals()
	{
		$query = $this->database->prepare("SELECT d.*, dd.*, pb.naam as bedrijf FROM geodealsadmin.tbldeal d
										   INNER JOIN tbldeallocation dd on d.id = dd.deal_id
										   INNER JOIN tblprofiel p on p.id = d.profiel_id
										   INNER JOIN tblprofiel pb on pb.user_id = d.user_id
										   INNER JOIN tbluser u on u.id = p.user_id
										   WHERE d.status = :status
										   AND d.type = 'location'");
        $query->execute(array(':status' => "approved"));
							  
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}	
	
		
	function GetDealsByUserID($id)
	{
		$user_id = $id;
		
		$query = $this->database->prepare("SELECT id, naam, deal, omschrijving, type FROM tbldeal WHERE user_id = :user_id;");
        $query->execute(array(':user_id' => $user_id));
							  
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function GetDealByID($id)
	{
		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("SELECT id, naam, deal, omschrijving, type, profiel_id FROM tbldeal WHERE user_id = :user_id AND id = :id;");
        $query->execute(array(':user_id' => $user_id, 
							  ':id' => $id));
							  
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	function GetDateDealByID($id)
	{
		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("SELECT d.id as deal_id, d.naam as deal_naam, d.omschrijving as omschrijving, d.deal as deal_image, d.type as deal_type, d.profiel_id as profiel_id, dd.startdatum as startdatum, dd.einddatum as einddatum FROM tbldeal d
											INNER JOIN tbldealdatum dd ON d.id = dd.deal_id 
											WHERE user_id = :user_id AND d.id = :id;");
        $query->execute(array(':user_id' => $user_id, 
							  ':id' => $id));
							  
		return $query->fetchAll();
	}
	
	function GetLimitedDealByID($id)
	{
		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("SELECT d.id as deal_id, d.naam as deal_naam, d.omschrijving as omschrijving, d.deal as deal_image, d.type as deal_type, d.profiel_id as profiel_id, dd.amountleft as amount FROM tbldeal d
											INNER JOIN tbldeallimited dd ON d.id = dd.deal_id 
											WHERE user_id = :user_id AND d.id = :id;");
        $query->execute(array(':user_id' => $user_id, 
							  ':id' => $id));
							  
		return $query->fetchAll();
	}
	
	function GetLocationDealByID($id)
	{
		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("SELECT d.id as deal_id, d.naam as deal_naam, d.omschrijving as omschrijving, d.deal as deal_image, d.type as deal_type, d.profiel_id as profiel_id, dd.x as x, dd.y as y FROM tbldeal d
											INNER JOIN tbldeallocation dd ON d.id = dd.deal_id 
											WHERE user_id = :user_id AND d.id = :id;");
        $query->execute(array(':user_id' => $user_id, 
							  ':id' => $id));
							  
		return $query->fetchAll();
	}
	
	function GetEvenementen()
	{
		$query = $this->database->prepare("SELECT p.id as id, p.naam as naam FROM tblprofiel p INNER JOIN tbluser u ON p.user_id = u.id WHERE u.type = 'evenement';");
        $query->execute();
		
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function save_normal($data)
	{
		$user_id = Session::get("User")->GetId();
		
		$deal = $data['image'];
		$naam = $data['naam'];
		$type = $data['dealtype'];
		$omschrijving = $data['omschrijving'];
		$profiel_id = $data['evenement'];
		
		$query = $this->database->prepare("INSERT INTO tbldeal (naam, deal, omschrijving, user_id, type, profiel_id) VALUES (:naam, :deal, :omschrijving, :user_id, :type, :profiel_id);");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':profiel_id' => $profiel_id,
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
		$profiel_id = $data['evenement'];
		
		$startdate = date("Y-m-d",strtotime($data['startdatum']));
		$einddate = date("Y-m-d",strtotime($data['einddatum'])); 
				
		$query = $this->database->prepare("INSERT INTO tbldeal (naam, deal, omschrijving, user_id, type, profiel_id) VALUES (:naam, :deal, :omschrijving, :user_id, :type, :profiel_id);");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':profiel_id' => $profiel_id,
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
		$profiel_id = $data['evenement'];
		
		$limit = $data['limit'];
						
		$query = $this->database->prepare("INSERT INTO tbldeal (naam, deal, omschrijving, user_id, type, profiel_id) VALUES (:naam, :deal, :omschrijving, :user_id, :type, :profiel_id);");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':profiel_id' => $profiel_id,
							  ':user_id' => $user_id,
							  ':type' => $type));
				
		$id = $this->database->lastInsertId(); 
				
		$limitdeal = $this->database->prepare("INSERT INTO tbldeallimited (amount, deal_id, amountleft) VALUES (:limit, :deal_id, :amountleft);");
				
		$limitdeal->execute(array(':limit' => $limit,
								  ':deal_id' => $id,
								  ':amountleft' => $limit));
	}
	
	function save_location($data)
	{
		$user_id = Session::get("User")->GetId();
		
		$deal = $data['image'];
		$naam = $data['naam'];
		$type = $data['dealtype'];
		$omschrijving = $data['omschrijving'];
		$profiel_id = $data['evenement'];
		
		$coords = substr($data['location'], 1, strlen($data['location']) - 2);
		$coords = explode(',', $coords);
		
		$x = $coords[0];
		$y = $coords[1];
		
		$query = $this->database->prepare("INSERT INTO tbldeal (naam, deal, omschrijving, user_id, type, profiel_id) VALUES (:naam, :deal, :omschrijving, :user_id, :type, :profiel_id);");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':profiel_id' => $profiel_id,
							  ':user_id' => $user_id,
							  ':type' => $type));
				
		$id = $this->database->lastInsertId(); 
				
		$limitdeal = $this->database->prepare("INSERT INTO tbldeallocation (x, y, deal_id) VALUES (:x, :y, :deal_id);");
				
		$limitdeal->execute(array(':x' => $x,
								  ':y' => $y,
								  ':deal_id' => $id));
	}
	
	function update_normal($data)
	{	
		$deal = $data['image'];
		$naam = $data['naam'];
		$omschrijving = $data['omschrijving'];
		$profiel_id = $data['evenement'];
		
		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("UPDATE tbldeal SET naam = :naam, deal = :deal, omschrijving = :omschrijving, profiel_id = :profiel_id
											WHERE id = :id AND user_id = :user_id");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':profiel_id' => $profiel_id,
							  ':user_id' => $user_id,
							  ':id' => $data['id']));
	}
	
	function update_date($data)
	{	
		$id = $data['id'];
		$deal = $data['image'];
		$naam = $data['naam'];
		$omschrijving = $data['omschrijving'];
		$profiel_id = $data['evenement'];
		
		$startdate = date("Y-m-d",strtotime($data['startdatum']));
		$einddate = date("Y-m-d",strtotime($data['einddatum'])); 
		
		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("UPDATE tbldeal SET naam = :naam, deal = :deal, omschrijving = :omschrijving, profiel_id = :profiel_id
											WHERE id = :id AND user_id = :user_id");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':profiel_id' => $profiel_id,
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
		$profiel_id = $data['evenement'];
		
		$limit = $data['limit'];

		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("UPDATE tbldeal SET naam = :naam, deal = :deal, omschrijving = :omschrijving, profiel_id = :profiel_id
											WHERE id = :id AND user_id = :user_id");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':profiel_id' => $profiel_id,
							  ':user_id' => $user_id,
							  ':id' => $id));
						
		$limitQuery = $this->database->prepare("UPDATE tbldeallimited SET amount = :amount, amountleft = :amountleft
											   WHERE deal_id = :deal_id");
											   
		$limitQuery->execute(array(':amount' => $limit,
								   ':deal_id' => $id,
								   ':amountleft' => $limit));
	}
	
	function update_location($data)
	{	
		$id = $data['id'];
		$deal = $data['image'];
		$naam = $data['naam'];
		$omschrijving = $data['omschrijving'];
		$profiel_id = $data['evenement'];
		
		$coords = substr($data['location'], 1, strlen($data['location']) - 2);
		$coords = explode(',', $coords);
		
		$x = $coords[0];
		$y = $coords[1];
			

		$user_id = Session::get("User")->GetId();
		
		$query = $this->database->prepare("UPDATE tbldeal SET naam = :naam, deal = :deal, omschrijving = :omschrijving, profiel_id = :profiel_id
											WHERE id = :id AND user_id = :user_id");
        $query->execute(array(':deal' => $deal,
							  ':naam' => $naam,
							  ':omschrijving' => $omschrijving,
							  ':profiel_id' => $profiel_id,
							  ':user_id' => $user_id,
							  ':id' => $id));
						
		$limitQuery = $this->database->prepare("UPDATE tbldeallocation SET x = :x, y = :y
											   WHERE deal_id = :deal_id");
											   
		$limitQuery->execute(array(':x' => $x,
								   ':y' => $y,
 								   ':deal_id' => $id));
	}
	
	function delete($id)
	{
		$query = $this->database->prepare("DELETE FROM tbldeal WHERE id = :id");
		$query->execute(array(':id' => $id));
	}

	function approve($id)
	{
		$query = $this->database->prepare("UPDATE tbldeal SET status = :status
											WHERE id = :id");
        $query->execute(array(":id" => $id,
							  ":status" => "approved"));
	}
	
	function deny($id)
	{
		$query = $this->database->prepare("UPDATE tbldeal SET status = :status
											WHERE id = :id");
        $query->execute(array(":id" => $id,
							  ":status" => "denied"));
	}
	
	function used($id, $auth)
	{
		if($auth == "pepdebwilboy")
		{
			$query = $this->database->prepare("UPDATE tbldeallimited SET amountleft = (amountleft - 1) WHERE deal_id = :id;");
			$query->execute(array(":id" => $id));
		}
	}
	
	function rating($rating, $deal_id)
	{
		$query = $this->database->prepare("INSERT INTo tbldealrating (rating, deal_id) VALUES (:rating, :deal_id)");
		$query->execute(array(":rating" => $rating,
							  ":deal_id" => $deal_id));
	}
}
